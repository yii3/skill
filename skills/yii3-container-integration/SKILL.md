---
name: yii3-container-integration
description: Configure or troubleshoot Yii3 config groups, DI definitions, service providers, bootstrap callbacks, events, logging targets, and middleware pipelines. Use for runtime wiring changes; not general application architecture or package-specific integration when the owning skill is available.
license: BSD-3-Clause
metadata:
  source: https://github.com/yii3/skill
---

# Integrate Yii3 container and runtime wiring

Read [configuration and runtime wiring](references/configuration-wiring.md) before changing integration points. This
skill is independently usable; use package-owned instructions as additional evidence when the affected dependency
provides them.

## Establish the effective wiring

- Resolve the installed revisions and source of `yiisoft/config`, `yiisoft/definitions`, `yiisoft/di`, the actual runner
  packages, and every logger, event, or middleware package touched by the task.
- Inspect the root configuration declaration, generated merge plan, every affected entry point, and the exact groups its
  runner consumes. A file present in the merge plan is not necessarily in the selected runner group.
- Inspect existing definitions, providers, delegates, tags, bootstrap callbacks, event listeners, logger targets, and
  middleware lists before choosing an integration point. Preserve their merge behavior and order.
- Do not edit the generated merge plan. Change the owning package metadata/configuration or the root source mapping,
  then rebuild it.

## Choose the integration point by responsibility

| Mechanism        | Use it for                                                                             |
| ---------------- | -------------------------------------------------------------------------------------- |
| Params group     | Scalar and array options consumed by definitions or application code                   |
| DI definitions   | Service IDs, interfaces, constructor arguments, factories, and post-construction calls |
| Service provider | A cohesive set of definitions or extensions to services already defined elsewhere      |
| Bootstrap        | Authorized startup side effects that require the built container                       |
| Events group     | Listener mappings consumed by the event dispatcher configuration                       |
| Middleware list  | Ordered request processing for the specific application runner                         |

Keep providers idempotent and free of application startup or database mutation. Return definitions from
`getDefinitions()` and service decorators from `getExtensions()`; use bootstrap for deliberate startup actions.

Use the simplest existing mechanism that preserves ownership. Do not move a working definition into a provider, add a
bootstrap callback, or create a new group merely to match an example.

## Preserve configuration semantics

- When `extra.config-plugin-file` exists, that file is the effective root declaration. Keep group references such as
  `$di`, `$params`, and `$events-web` aligned with the runner's group arguments.
- Standard Yii runners apply reverse merge to selected event groups and recursive merge to selected parameter and event
  groups, including the nested groups passed to the runner. Match the installed runner source before relying on these
  defaults. A custom `Config` instance must configure the required modifiers itself.
- Same-name keys in one configuration layer are errors unless the applicable merge behavior explicitly handles the
  structure. Do not solve collisions by deleting unrelated vendor contributions.
- Rebuild with `composer yii-config-rebuild` after source mappings, package configuration, or matched file sets change.
  Review the resulting package and root entries; do not hand-edit the result.

## Preserve container and application contracts

- Bind interfaces and non-inferable constructor values explicitly. Use `Reference`, `DynamicReference`,
  `ReferencesArray`, tags, or factories according to the installed definitions API and current project conventions.
- Yii DI caches a built service by ID. Account for mutable state in long-running workers and use the application's
  state-reset strategy when needed; do not introduce shared mutable state accidentally.
- Provider extensions require the base service definition. Load the provider group before first resolution and verify
  that decoration occurs exactly once.
- Alias configuration, autoloading, and DI definitions are different concerns. Read the installed `yiisoft/aliases`
  configuration before adding aliases, and never use an alias as a Composer namespace mapping.
- Preserve logger targets contributed through application parameters when the logger definition is designed to consume
  them. A hardcoded target list can silently disconnect package logging.
- Middleware order is behavioral and application-specific. Inspect what each middleware catches, creates, mutates, or
  delegates before placing it. There is no universal Yii3 middleware order.

## Verify each layer

1. Rebuild configuration when required and confirm the intended package/root files appear under the selected groups.
2. Resolve affected definitions through the same runner/container path as production. Verify concrete type, constructor
   values, provider extension count, and repeated-resolution identity where relevant.
3. Exercise bootstrap and events through the actual lifecycle; the presence of a callable or listener mapping is not
   proof it ran.
4. Exercise a request through the full middleware pipeline and verify ordering with observable behavior, not array
   position alone.
5. Resolve the logger and inspect its effective targets when packages contribute targets.
6. Build every web, API, console, worker, or test runner that shares changed groups.

Report unavailable extensions, services, databases, servers, or credentials as exact limits. Do not install arbitrary
implementations merely to make container construction pass.
