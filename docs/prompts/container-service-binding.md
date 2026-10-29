# Bind and inject an application service

## Prompt

```text
Use `$yii3-container-integration` in this disposable checkout of `yiisoft/app`.

Introduce an application-owned `GreetingProviderInterface` and a default implementation that returns exactly
`Hello!`. Bind the interface through the application's existing Yii DI configuration and inject it into the existing
`hello` console command instead of constructing the implementation inside the command. Preserve the command name and
observable output. Use the simplest existing integration mechanism, add no dependencies, do not access the network or
secrets, and never edit `config/.merge-plan.php` manually.

Add or adjust the smallest focused automated test that proves the binding is consumed through the real console runner.
Rebuild generated configuration only if the source mapping requires it, then run the relevant existing checks. In the
final response, state whether the requested skill was discovered and which skill/reference files were actually read,
summarize the wiring and files changed, report every test or check with its real exit status, and identify any
verification limits.
```

## Observed run results

Tested on 2026-10-29 from skill revision `bce8d690`. All edits described below exist only in isolated copies.

| Harness             | Model               | Effort    | Result |
| ------------------- | ------------------- | --------- | ------ |
| Claude Code 2.1.312 | `claude-sonnet-5-5` | `medium`  | Pass   |
| Codex CLI 0.165.0   | `gpt-6-luna`        | `default` | Pass   |
| Copilot CLI 1.0.105 | `kimi-k3`           | `default` | Pass   |

### Claude Code 2.1.312

- Loaded the skill and reference and used the existing `di` wildcard for the interface binding.
- Injected the command and passed the full suite: 22 tests and 37 assertions.

### Codex CLI 0.165.0

- The real console runner printed exactly `Hello!`.
- Console tests, container resolution, syntax, style, single-threaded Psalm, and diff checks passed.
- Its isolated patch included an unnecessary changelog line; that artifact was not adopted.

### Copilot CLI 1.0.105

- Reported `kimi-k3`, loaded the skill and reference, and used an ordinary DI definition.
- The real command, Console, Unit, full-suite, Psalm, style, and dependency checks passed.
