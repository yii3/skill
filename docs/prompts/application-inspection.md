# Inspect a Yii3 application

## Prompt

```text
Use `$yii3-application` in this checkout of `yiisoft/app`.

This is a read-only inspection. Do not modify files, install or update dependencies, access the network, or use secrets.
Inspect the application before proposing any change and report:

1. The root Composer constraints, locked selections, and installed versions/paths for `yiisoft/config`,
   `yiisoft/definitions`, `yiisoft/di`, and the HTTP and console runners.
2. Every HTTP, console, and test entry point you can verify, including the runner arguments and configuration groups
   each production runner consumes.
3. The effective root configuration declaration, generated merge-plan evidence, environment layers, and the
   distinction between source configuration and generated configuration.
4. Any package-owned skills declared by installed dependencies, keeping installation, synchronization, discovery, and
   loading as separate facts.

Run only read-only commands that substantiate the report. In the final response, state whether the requested skill was
discovered and which skill/reference files were actually read, cite repository-relative evidence, list commands that
were run with their exit status, and identify any verification limits. Do not infer runtime success from static files.
```

## Observed run results

Tested on 2026-10-29 from skill revision `bce8d690`. The source application remained unchanged.

| Harness             | Model               | Effort    | Result |
| ------------------- | ------------------- | --------- | ------ |
| Claude Code 2.1.312 | `claude-sonnet-5-5` | `medium`  | Pass   |
| Codex CLI 0.165.0   | `gpt-6-luna`        | `default` | Pass   |
| Copilot CLI 1.0.105 | `kimi-k3`           | `default` | Pass   |

### Claude Code 2.1.312

- Reported the canonical model `claude-sonnet-5-5` and loaded the skill and reference.
- Produced the requested read-only constraints, installed-package, runner, and configuration report.
- Left runtime construction unverified as required; the source application remained unchanged.

### Codex CLI 0.165.0

- Accepted `gpt-6-luna`; its event stream did not independently echo the model identity.
- Read the skill and reference directly, produced the same evidence layers, and made no source changes.

### Copilot CLI 1.0.105

- Reported `kimi-k3` after the explicitly authorized retry and loaded the skill and reference.
- Produced the same read-only evidence and runtime limits without changing the source application.
