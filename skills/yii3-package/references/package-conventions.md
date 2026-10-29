# Yii3 package conventions

Use these upstream documents as team conventions, then match them to the target package's selected revision, public
contract, and repository instructions. The links point to the current Yii documentation branch and can evolve
independently of a released package.

## Use the definitive guide selectively

Start at the [Yii3 definitive guide](https://yiisoft.github.io/docs/guide/) and open only the pages that match the task.
The index identifies incomplete sections, so do not treat every page as equally authoritative or current. When a guide
example differs from installed package source, tests, or versioned package documentation, follow the selected revision
and report the difference.

- [Designing packages for Yii applications](https://yiisoft.github.io/docs/guide/structure/designing-packages.html)
  covers Yii-aware Composer metadata, optional package layout, config groups, parameters, DI definitions and providers,
  routes, events, commands, migrations, translations, assets, and themes. Use only the facilities the package needs.
- [Using packages](https://yiisoft.github.io/docs/guide/structure/package.html) describes the application consumer side;
  use it when a package change also affects installation or application integration.
- [Configuration](https://yiisoft.github.io/docs/guide/concept/configuration.html) and the
  [DI container](https://yiisoft.github.io/docs/guide/concept/di-container.html) explain application assembly. Match
  their examples to the installed `yiisoft/config`, `yiisoft/definitions`, `yiisoft/di`, and runner versions.
- The guide's [testing](https://yiisoft.github.io/docs/guide/testing/overview.html),
  [unit testing](https://yiisoft.github.io/docs/guide/testing/unit.html), and
  [quality tools](https://yiisoft.github.io/docs/guide/testing/quality-tools.html) pages describe the default
  application template's selected tools. They do not require a package to replace Testo, PHPUnit, Codeception, PHPStan,
  Psalm, or another established toolchain.
- Read [performance tuning](https://yiisoft.github.io/docs/guide/tutorial/performance-tuning.html) for a relevant
  application performance task, not as a requirement to add benchmarks to every package change.

## Package boundaries and design

- [Packages](https://github.com/yiisoft/docs/blob/master/src/internals/000-packages.md) distinguishes general-purpose
  packages from Yii-specific packages, defines independent SemVer, namespaces package parameters, and excludes
  configuration-only dependencies from Composer `require`.
- [Yii goal and values](https://github.com/yiisoft/docs/blob/master/src/internals/001-yii-values.md) favors practical,
  explicit, simple solutions with sensible flexibility.
- [Design decisions](https://github.com/yiisoft/docs/blob/master/src/internals/009-design-decisions.md) explains the
  move away from magic properties and service locators toward standalone packages, PSRs, and dependency injection.

Classify the package before changing dependencies. A general-purpose package must not gain a Yii-specific dependency. A
configuration file may reference an optional integration package without making that package a runtime dependency;
source code, public signatures, and unconditional runtime paths require a separate dependency analysis.

## PHP and API conventions

Apply the following when they do not conflict with a deliberately preserved public contract:

- [Namespaces](https://github.com/yiisoft/docs/blob/master/src/internals/004-namespaces.md),
  [interfaces](https://github.com/yiisoft/docs/blob/master/src/internals/008-interfaces.md), and
  [exceptions](https://github.com/yiisoft/docs/blob/master/src/internals/007-exceptions.md) define Yii naming and
  exception-message conventions.
- [Code style](https://github.com/yiisoft/docs/blob/master/src/internals/010-code-style.md) builds on PER Coding Style
  3.0 and covers strict types, useful type declarations, 120-character lines, imports, immutable methods, and
  `final`/`private` defaults.

Treat “by default” as a design starting point. Do not make an extensible class `final`, narrow visibility, or change a
return type when that would violate the package's supported API. For new API, assess SemVer and downstream use rather
than relying on formatting rules alone.

## Tests and verification

[Tests](https://github.com/yiisoft/docs/blob/master/src/internals/012-tests.md) documents the Yii team's PHPUnit
conventions: `final` test classes by default, `test`-prefixed purpose names without “should,” one arrange-act-assert
case per method, public-API testing, and avoiding configuration or DI dependencies unless necessary.

If the user explicitly chooses PHPUnit or Testo, use that framework. Otherwise inspect repository dependencies, Composer
scripts, configuration, and CI and preserve the selected harness. Translate the behavioral intent into its conventions
instead of introducing another framework, and route Testo-specific work to its owning skill when available.

[Code review](https://github.com/yiisoft/docs/blob/master/src/internals/013-code-review.md) expects a regression test
that fails without a behavioral fix and passes with it, plus types, strict typing, documentation, and a changelog entry
for a stable package. Static analysis and unrelated passing tests are supporting evidence, not a substitute for
reproducing the reported behavior. For a security issue, keep proofs of concept scoped to local or disposable targets.

Use existing benchmarks for material performance decisions. If none exists, explain the decision and measurement limit;
do not add a benchmark framework or claim a performance improvement without representative before-and-after evidence.

## Documentation and specialized conventions

- [Documentation](https://github.com/yiisoft/docs/blob/master/src/internals/014-docs.md) covers package-documentation
  placement, definitive-guide translations, useful PHPDoc, qualified `@see` references, and the package README
  checklist. Edit definitive-guide `.po` sources rather than generated translated Markdown.
- For widget APIs, read [widget conventions](https://github.com/yiisoft/docs/blob/master/src/internals/018-widgets.md).
- For PHP view templates, read
  [view code style](https://github.com/yiisoft/docs/blob/master/src/internals/019-view-code-style.md).
- For framework configuration group names, read
  [config groups](https://github.com/yiisoft/docs/blob/master/src/internals/022-config-groups.md). These are group-name
  conventions, not mandatory file names.

Explain package-specific behavior and non-obvious consequences. Do not duplicate signatures or declared defaults in
PHPDoc, and do not expand routine PHP syntax into a tutorial unless the target documentation is written for that
audience.

## Contribution and release-only guidance

Read these documents only when the requested deliverable requires them:

- [Git commit messages](https://github.com/yiisoft/docs/blob/master/src/internals/006-git-commit-messages.md) for a Yii
  team commit.
- [Changelog and upgrade](https://github.com/yiisoft/docs/blob/master/src/internals/021-changelog-upgrade.md) when a
  stable package change needs release notes or a breaking change needs upgrade instructions.
- [Package release](https://github.com/yiisoft/docs/blob/master/src/internals/020-package-release.md) only for an
  explicitly authorized release.

These pages describe conventions; they do not grant permission to commit, resolve pull-request threads, push, tag, or
publish a release.

## Provenance

The initial skill and concept were shared for improvement by Alexander Makarov
([`@samdark`](https://github.com/samdark)). This adaptation preserves that attribution while distinguishing later
changes made in `yii3/skill` and the Yii documentation maintained by its contributors.
