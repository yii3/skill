---
name: yii3-application
description: Inspect, create, or change a Yii3 application by resolving its installed component versions, entry points, runner groups, configuration, and package-owned skills. Use for application-level Yii3 work; not Yii2 or a package-specific workflow whose owning skill is available.
license: BSD-3-Clause
metadata:
  source: https://github.com/yii3/skill
---

# Work with a Yii3 application

Read [application evidence](references/application-evidence.md) before planning a change. Yii3 applications compose
independently versioned packages; a repository name, template, or documentation page does not identify all code in use.

## Establish the project in use

- Inspect the root `composer.json`, `composer.lock`, configured vendor directory, and `vendor/composer/installed.php`.
  Distinguish required constraints, locked selections, and installed files.
- For a live package checkout or symlinked path dependency, inspect its current `HEAD`, working tree, and relevant
  files. Installed files govern behavior; report mismatches with Composer metadata. Uncommitted files have no matching
  source revision.
- Identify Yii3 from the installed components, runners, and configuration, not from a single package name. There is no
  required `yiisoft/yii` umbrella dependency.
- Resolve every affected component independently. Do not use a current upstream branch or a different application's lock
  file as proof of the installed API.

## Map the application before editing

1. Find every relevant HTTP, API, console, worker, test, and custom entry point. Inspect Composer scripts and executable
   files; do not assume `public/index.php` and `yii` are the only runners. When one script selects among multiple
   runners, verify that its branches are mutually exclusive or terminate; do not assume `run()` exits the process.
2. Record each runner class and its effective root, environment, config directory, vendor directory, merge-plan file,
   and group arguments. Defaults count only after matching the installed runner source.
3. Resolve the root configuration declaration. If `extra.config-plugin-file` is present, read that PHP file;
   `config-plugin*` keys beside it in `composer.json` are not the effective declaration.
4. Treat `config/.merge-plan.php` as generated evidence. Never edit it as source. Compare package contributions, root
   groups, environment layers, and the groups each runner actually consumes. Evaluate an aggregate with the parameter
   group, nested groups, and modifiers of that runner; reusing another runner's `Config` can produce false duplicate-key
   failures or incorrect effective parameters.
5. Preserve the application's namespaces, directory layout, architecture, public entry points, environment model, and
   existing tools unless the requested change requires one of them to change. The minimal web template and a
   domain-oriented demo are examples, not universal layouts.

## Route focused work to its owner

Inspect affected dependencies for `extra.skills.source` and complete `SKILL.md` bundles. When an installed package owns
a matching workflow, use that workflow with this application evidence instead of copying its instructions here. For
example, `yii3/debug` owns `yii3-debug-integration`.

`composer skills:show` can report declared donors and synchronization status when `llm/skills` is installed. It does not
prove a client discovered or loaded the skill. Keep these observations separate:

- package source is installed at a resolved revision;
- files were synchronized into a project skill path;
- the client discovered the skill;
- the client loaded its instructions for the task;
- the resulting change passed task acceptance.

If the owning skill is unavailable, say so and use the installed package source, PHPDoc, tests, and matching
documentation. Never claim an unavailable skill was loaded.

## Make the smallest coherent change

- Follow only the application paths and package APIs relevant to the request. Do not add DDD layers, controllers,
  middleware, migrations, or service providers merely because an example has them.
- Preserve all runners that share changed configuration. A working Site request does not prove the API, console, or a
  custom worker still builds.
- Respect an explicit user choice between PHPUnit, Testo, or another supported test framework. When the user does not
  choose, preserve the framework and conventions already used by the project; do not migrate frameworks or duplicate a
  framework-owned skill merely to add a focused test.
- Use existing Composer scripts and project checks where they establish the needed behavior. Do not install
  dependencies, run live migrations, or mutate external services without authorization.
- When a dependency or entry-point choice is not inferable from the project, present that exact choice instead of
  selecting an arbitrary Yii3 package.

## Verify observable behavior

Report each completed layer separately:

1. **Resolution:** root constraints, locked versions/references, installed paths, and any metadata mismatch.
2. **Discovery:** the generated merge plan contains the intended package and root configuration files.
3. **Construction:** the affected container services, routes, commands, or application object resolve.
4. **Execution:** the intended request, command, worker, or targeted test exercises the changed path.
5. **Regression scope:** every other runner sharing the modified groups at least builds or passes its existing targeted
   check.

A successful Composer operation or rebuilt merge plan does not by itself prove runtime integration. Report missing
vendor files, extensions, databases, servers, browsers, or credentials as verification limits.
