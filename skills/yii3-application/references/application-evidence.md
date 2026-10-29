# Application evidence

Use this reference to build a revision-aware application map. Commands are examples; equivalent read-only inspection is
valid.

## Resolve Composer state

Start with:

```bash
composer show --self --format=json
composer config vendor-dir --absolute
git status --short --branch
```

Read `composer.json` for declared intent and `composer.lock` for selected package versions and references. Read the
configured vendor directory's `composer/installed.php` for each affected package's `install_path`, `pretty_version`, and
`reference`. Follow real paths so a path repository or symlink cannot hide a different checkout.

A lock-only application has desired selections but no installed source. An installed tree may be stale relative to the
lock. A clean dependency checkout may still point at a different commit than its Composer metadata. State which layer
was actually inspected.

Record at least the directly affected packages. Application-level work commonly needs the versions of:

- `yiisoft/config`, `yiisoft/definitions`, and `yiisoft/di`;
- the specific `yiisoft/yii-runner-*` and application packages in each entry point;
- middleware, router, logger, event, database, view, or console packages touched by the task.

Package constraints are not installed versions. Do not rewrite stable constraints as development constraints when an
applicable stable release already satisfies the project.

## Inventory entry points and groups

Search executable scripts and source for runner construction:

```bash
rg -n -g '!vendor/**' 'ApplicationRunner|HttpApplicationRunner|ConsoleApplicationRunner|->run\(' .
rg -n -g '!vendor/**' 'bootstrapGroup|eventsGroup|diGroup|diProvidersGroup|paramsGroup|nested.*Groups' .
```

For each relevant entry point, record:

| Evidence         | Questions to answer                                                      |
| ---------------- | ------------------------------------------------------------------------ |
| Entry script     | Which autoloader/bootstrap runs first?                                   |
| Runner           | Which installed class and constructor revision is used?                  |
| Environment      | Which value chooses dev, test, or production configuration?              |
| Config paths     | Are config, vendor, or merge-plan paths customized?                      |
| Consumed groups  | Which bootstrap, events, DI, provider, delegate, tag, and params groups? |
| Nested groups    | Which parameter and event groups need the runner's merge modifiers?      |
| Temporary errors | How are failures handled before the real container exists?               |

An application may dispatch different URL prefixes to different runners or use separate entry scripts. Verify that
selection branches return, use `else`, or are otherwise mutually exclusive: standard runner `run()` methods may return
normally, allowing a later runner in the same script to execute. Verify each changed runner; do not infer one from
another.

## Inventory configuration

Read the root package's `extra.config-plugin-file` or effective `config-plugin*` metadata, then inspect the generated
merge plan without editing it. Use the installed command when available:

```bash
composer yii-config-info
```

The command and merge plan show discovery. The runner arguments show consumption. A package can contribute a valid
`di-web`, `events-web`, or `bootstrap` group that a custom `di-api`, `events-api`, or `bootstrap-api` runner never
references.

Build each effective view with that runner's selected params group, nested params/events groups, environment, and config
modifiers. Do not create a Site-oriented `Config` and query an API aggregate from it: referenced files receive the wrong
`$params` input and merge behavior, which can produce duplicate-key errors that the API runner itself would not.

## Discover package-owned skills

When `llm/skills` is installed:

```bash
composer skills:show
```

Also inspect the owning dependency's installed `composer.json` and its declared `extra.skills.source`. Confirm that the
named directory and complete `SKILL.md` bundle exist at the installed revision. Synchronization into `.agents/skills` or
another target is separate from the coding client's discovery and invocation.

## Evidence boundaries

- Generated configuration proves what was assembled, not that an entry point consumed it.
- Container resolution proves construction, not request ordering or event delivery.
- A passing unit test may bypass the real runner, environment, or middleware pipeline.
- Hosted documentation is usable only after matching it to the selected package revision; otherwise prefer installed
  source, PHPDoc, tests, and changelog and report the documentation gap.
- Reading a skill file is not evidence of native client activation.
