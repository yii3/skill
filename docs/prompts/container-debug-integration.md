# Complete development-only debug wiring

## Prompt

```text
Use `$yii3-container-integration` and the installed package-owned `$yii3-debug-integration` skill in this disposable
checkout of `yiisoft/demo-diary`.

Audit and complete the existing `yii3/debug` integration for both the Site and API HTTP runners in development only.
Use the installed package and its current configuration; do not install or update dependencies, access the network, or
use secrets. Verify `APP_ENV` gating, generated merge-plan discovery, the exact groups consumed by each runner, provider,
bootstrap and event loading, logger targets, middleware contribution and ordering, and mutually exclusive Site/API
runner control flow. Preserve empty production integration and existing application services. Make only source changes
supported by evidence and never edit `config/.merge-plan.php` manually.

Rebuild generated configuration when source configuration changes. Run focused construction or request checks that do
not require external services or persistent database data. In the final response, state whether both requested skills
were discovered and which skill/reference files were actually read, summarize the files changed, report every check
with its real exit status, and distinguish configuration discovery, container construction, and functional request
verification. Identify any verification limits instead of inferring success.
```

## Observed run results

Tested on 2026-10-29 from skill revision `bce8d690`. All edits described below exist only in isolated copies.

| Harness             | Model               | Effort    | Result |
| ------------------- | ------------------- | --------- | ------ |
| Claude Code 2.1.312 | `claude-sonnet-5-5` | `medium`  | Pass   |
| Codex CLI 0.165.0   | `gpt-6-luna`        | `default` | Pass   |
| Copilot CLI 1.0.105 | `kimi-k3`           | `default` | Pass   |

### Claude Code 2.1.312

- Loaded both skills, fixed logger targets and middleware, and made Site/API runner branches exclusive.
- Rebuilt configuration, verified development container/request behavior, and kept production empty.
- Proposed declaring the installed package in `require-dev`; the application owner must resolve that mismatch.

### Codex CLI 0.165.0

- Loaded both skills and fixed logger, middleware, and runner control flow in its isolated copy.
- Passed development/production container assertions and temporary-root Site/API request checks.
- Reported that a clean install still requires reconciled Composer metadata.

### Copilot CLI 1.0.105

- Reported `kimi-k3`, loaded both skills, and applied the same four core fixes in its isolated copy.
- Passed development/production containers and in-process plus real-server Site/API request checks.
- Left Composer metadata intentionally unlocked, so the application-level dependency decision remains pending.

The repeated defects are application findings, not proof that every Yii3 application needs the same edits. The central
skills already require inspecting installed package configuration and each runner. Apply any production fix in the
owning application only after reconciling its Composer metadata and tests.
