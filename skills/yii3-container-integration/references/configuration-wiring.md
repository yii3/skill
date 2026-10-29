# Configuration and runtime wiring

These patterns were verified against stable Yii3 components used by the current web application and demo application.
Resolve the installed revision before applying them because each component versions independently.

## Config plugin layers and groups

`yiisoft/config` assembles vendor package configuration, root application configuration, and the selected environment
layer into named groups. A root package commonly points to a PHP declaration:

```json
{
    "extra": {
        "config-plugin-file": "config/configuration.php"
    }
}
```

When this key exists, the declaration in that PHP file is effective and sibling `config-plugin*` metadata in
`composer.json` is ignored. Group values may be files, wildcard paths, or references prefixed with `$`. Wildcards may
match zero files; required literal files must exist.

The generated `config/.merge-plan.php` records package, root, and environment sources. It is replaced by the plugin.
After changing configuration sources, rebuild and inspect it:

```bash
composer yii-config-rebuild
composer yii-config-info
```

## Runner consumption

The standard HTTP and console runners build `Yiisoft\Config\Config` and `Yiisoft\Di\Container`. At the verified
`yiisoft/yii-runner` 2.2 line, the runner:

- reverse-merges the selected events group and its declared nested event groups;
- recursively merges the selected params and events groups and their nested groups;
- loads the selected DI definitions, provider, delegate, and tag groups into `ContainerConfig`;
- loads the selected bootstrap group after the container is built.

Constructor defaults are not universal application choices. A multi-runner application can explicitly use groups such as
`di-site`, `di-api`, `events-site`, and `events-api`. Trace every group back to the root declaration and merge plan.

## Definitions and providers

Use an ordinary definition for a direct binding:

```php
return [
    ClockInterface::class => SystemClock::class,
    ReportService::class => [
        '__construct()' => [
            'clock' => Reference::to(ClockInterface::class),
        ],
    ],
];
```

Use a provider when a cohesive integration owns several definitions or extends an existing service:

```php
final readonly class ServiceProvider implements ServiceProviderInterface
{
    public function getDefinitions(): array
    {
        return [
            ClockInterface::class => SystemClock::class,
        ];
    }

    public function getExtensions(): array
    {
        return [];
    }
}
```

Return provider class names from the selected `di-providers*` group. Provider methods must be idempotent and contain
container registration only. An extension callable receives the container and existing service and must return the
service to use.

## Bootstrap and events

A bootstrap group is a list of callables executed with the built container:

```php
/**
 * @var list<callable(ContainerInterface): void>
 */
return [
    static function (ContainerInterface $container): void {
        RuntimeRegistry::set($container->get(RuntimeService::class));
    },
];
```

Use this only when a library's runtime contract genuinely requires a side effect. A DI definition alone does not execute
bootstrap. Conversely, a provider should not apply migrations, open external connections, or mutate global runtime state
in its registration methods.

Event groups describe listeners; the selected runner/event dispatcher consumes them. Preserve reverse and recursive
merge behavior so package and application listeners are not silently replaced or reordered.

## Logger targets

Packages may contribute target IDs through parameters. When the application intentionally exposes that extension point,
construct the logger from the effective list rather than a hardcoded replacement. A verified pattern is:

```php
return [
    LoggerInterface::class => [
        'class' => Logger::class,
        '__construct()' => [
            'targets' => ReferencesArray::from(
                array_values($params['yiisoft/log']['targets'] ?? [StreamTarget::class]),
            ),
        ],
    ],
];
```

The fallback and parameter key are application choices, not framework requirements. Preserve the existing fallback and
target shape. Resolve the logger and inspect the resulting target instances after the change.

## Middleware pipelines

Package integrations may contribute middleware IDs through parameters. An application can deliberately include them:

```php
'withMiddlewares()' => [
    [
        ...($params['yiisoft/middleware-dispatcher']['middlewares'] ?? []),
        ErrorCatcher::class,
        SessionMiddleware::class,
        CsrfTokenMiddleware::class,
        Router::class,
    ],
],
```

This is an inclusion pattern, not a universal order. Determine whether contributed middleware must run before or after
error handling, routing, sessions, authentication, CSRF, response transformation, or another runner-specific concern.
Verify with a real request that reaches the intended middleware and downstream handler.

## Failure patterns

- Editing `.merge-plan.php` loses changes on rebuild.
- Adding a package group without referencing it from the runner's selected aggregate leaves it unused.
- Loading a provider after first resolution can miss or duplicate decoration.
- Replacing logger targets disconnects package-contributed logging without a container error.
- Copying one middleware list into every runner can break API, Site, console, or worker-specific behavior.
- Adding aliases without inspecting the installed aliases package can overwrite required root, runtime, or vendor paths.
