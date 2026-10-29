# Usage examples

## Choose a workflow

| Task                                                                | Workflow                     |
| ------------------------------------------------------------------- | ---------------------------- |
| Identify the real Yii3 components and entry points before a change  | `yii3-application`           |
| Add a service binding without replacing existing application wiring | `yii3-container-integration` |
| Connect package-provided config groups to a custom HTTP runner      | `yii3-container-integration` |
| Integrate `yii3/debug` when its package skill is installed          | `yii3-debug-integration`     |

The last workflow belongs to `yii3/debug`, not this repository. If its donor is unavailable, report that gap and use the
package's installed source and documentation; do not claim the skill was loaded.

## Invoke and verify

Start a fresh client session from the application root and confirm the intended workflow appears in the client's skill
interface. Invoke `$yii3-application` for an application-level change or `$yii3-container-integration` for configuration
and container wiring.

Ask the agent to report the evidence it used. A useful application report distinguishes:

- root `composer.json`, lock-file resolution, and installed package files;
- web, API, console, worker, or test entry points and their runner arguments;
- root configuration groups, generated merge-plan entries, and groups actually consumed by each runner;
- package-owned skills that are installed, synchronized, discovered, and loaded.

After a change, run the application's existing targeted checks. A rebuilt merge plan proves configuration discovery;
container resolution proves definitions can be built; an exercised request or command proves the intended entry point
consumed the wiring. These are separate acceptance results.

[Back to documentation](../README.md#-documentation)
