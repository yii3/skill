# Usage examples

## Choose a workflow

| Task                                                                | Workflow                     |
| ------------------------------------------------------------------- | ---------------------------- |
| Identify the real Yii3 components and entry points before a change  | `yii3-application`           |
| Add a service binding without replacing existing application wiring | `yii3-container-integration` |
| Connect package-provided config groups to a custom HTTP runner      | `yii3-container-integration` |
| Develop a package without breaking its supported public contract    | `yii3-package`               |
| Integrate `yii3/debug` when its package skill is installed          | `yii3-debug-integration`     |

The last workflow belongs to `yii3/debug`, not this repository. If its donor is unavailable, report that gap and use the
package's installed source and documentation; do not claim the skill was loaded.

## Reproducible prompts

Each example preserves the exact prompt used for cross-client forward tests and records the observed result beside it:

- [Inspect application evidence](prompts/application-inspection.md).
- [Add a Site About page](prompts/application-about-route.md).
- [Bind and inject an application service](prompts/container-service-binding.md).
- [Complete development-only debug wiring](prompts/container-debug-integration.md).

The results are evidence from disposable snapshots, not a model ranking or a patch to copy blindly. Client acceptance,
model identity, skill loading, generated artifacts, and executed checks are reported separately.

In result tables, `default` means the client's default effort; no internal reasoning level was observed or confirmed.

## Invoke and verify

Start a fresh client session from the application root and confirm the intended workflow appears in the client's skill
interface. Invoke `$yii3-application` for an application-level change, `$yii3-container-integration` for configuration
and container wiring, or `$yii3-package` for package development, review, tests, or documentation.

Ask the agent to report the evidence it used. A useful application report distinguishes:

- root `composer.json`, lock-file resolution, and installed package files;
- web, API, console, worker, or test entry points and their runner arguments;
- root configuration groups, generated merge-plan entries, and groups actually consumed by each runner;
- package-owned skills that are installed, synchronized, discovered, and loaded.

A useful package report distinguishes:

- general-purpose and Yii-specific package boundaries;
- the selected revision, supported public contract, and release status;
- the repository's existing test harness and an explicit user choice of PHPUnit or Testo;
- targeted behavioral evidence, supporting quality checks, and remaining environment limits;
- documentation, changelog, upgrade, or release work that the requested change actually requires.

After a change, run the application's existing targeted checks. A rebuilt merge plan proves configuration discovery;
container resolution proves definitions can be built; an exercised request or command proves the intended entry point
consumed the wiring. These are separate acceptance results.

[Back to documentation](../README.md#-documentation)
