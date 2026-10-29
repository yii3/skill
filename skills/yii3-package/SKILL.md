---
name: yii3-package
description: Develop, review, test, or document a Yii3 package while preserving its public contract, package classification, dependency boundaries, repository toolchain, and Yii contribution conventions. Use for package or library work; not application assembly, runtime wiring, or a package-specific workflow whose owning skill is available.
license: BSD-3-Clause
metadata:
  source: https://github.com/yii3/skill
  acknowledgement: Initial skill and concept by Alexander Makarov (@samdark); adapted by yii3/skill.
---

# Work with a Yii3 package

Read [Yii3 package conventions](references/package-conventions.md) before planning a package change. Treat the target
repository and its selected revision as the source of truth for the package's current contract, tools, and supported
versions.

## Establish the package contract

- Inspect repository instructions, `composer.json`, the lock file when present, source, tests, configuration, docs,
  Composer scripts, and CI. Preserve unrelated working-tree changes.
- Identify whether the package is a general-purpose `yiisoft/*` library or a Yii-specific package. General-purpose
  packages must remain usable without Yii-specific packages. Keep dependencies minimal and do not add a runtime
  dependency for files used only by optional Yii configuration.
- Determine the public contract and release status from code, tests, Composer constraints, configuration keys and
  groups, `CHANGELOG.md`, `UPGRADE.md`, and tags available locally. Preserve that contract unless the task explicitly
  changes it.
- Resolve package-owned skills before applying generic guidance. Use an owning workflow when it matches the task; do not
  claim it was loaded when it is unavailable.

## Follow the repository's toolchain

- When the user chooses PHPUnit or Testo, use that framework. Otherwise preserve the package's existing test framework,
  commands, static analysis, coding-standard, mutation, and benchmark setup. Do not migrate between harnesses merely to
  match an example or team-wide document, and do not duplicate a Testo-owned skill.
- Apply Yii conventions where the repository has not made a more specific compatible choice. `final` classes and
  `private` members are defaults, not permission to close an existing extension point or break a public API.
- Prefer explicit dependencies, dependency injection, composition, and the simplest design that covers known use cases.
  Avoid Yii 2-style service locators and magic properties.
- Keep the requested change focused. Do not rename public symbols, reorganize namespaces, add abstractions, or modernize
  unrelated code without a requirement and compatibility plan.

## Implement and verify behavior

- For a bug or security fix, create a safe, human-readable regression test or proof of concept that demonstrates the
  reported behavior and passes after the fix. Do not run an exploit against a live service or mutate external data.
- Test through the public API and observable behavior. Preserve the project's test style; apply the Yii PHPUnit naming
  and AAA conventions only when PHPUnit is the selected harness.
- Consider security, execution time, and memory in proportion to the changed path. Benchmark when the decision is
  performance-sensitive and the repository has a suitable harness, or an authorized representative comparison can be
  made. Do not require PHPBench for every change.
- Update documentation for user-visible behavior, configuration precedence, defaults, and non-obvious consequences. Add
  PHPDoc only when it contributes information not already present in the declaration.
- Run the narrowest existing checks that establish the change, then the relevant regression checks. Report commands,
  results, and unavailable tools or environments separately.

## Keep contribution actions explicit

Review commit, changelog, upgrade, pull-request, and release conventions only when the task involves those deliverables.
Editing code does not authorize commits, pushes, GitHub review-thread changes, tags, or releases. Before any external or
release mutation, confirm that the user requested that exact action and that its prerequisites are satisfied.

## Provenance

This workflow is based on an initial Yii3 skill and concept shared for improvement by Alexander Makarov
([`@samdark`](https://github.com/samdark)). The `yii3/skill` adaptation adds revision-aware evidence, narrower routing,
repository-toolchain choices, permission boundaries, and links to current official documentation. This acknowledgment
applies to the original skill and idea; it does not attribute later adaptations or the Yii project's collective
documentation to one author.
