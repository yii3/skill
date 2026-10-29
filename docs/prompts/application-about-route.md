# Add a Site About page

## Prompt

```text
Use `$yii3-application` in this disposable checkout of `yiisoft/demo-diary`.

Implement a public `GET /about` page for the Site application only. Match the repository's existing use-case, action,
template, route, naming, and test conventions. Inspect Composer resolution, entry points, runner groups, and effective
configuration before editing. Keep the API and console applications unchanged, add no dependencies, do not access the
network or secrets, and never edit `config/.merge-plan.php` manually.

Add the smallest focused automated test that proves the Site runner returns a successful About page with distinctive
content. Run the relevant existing checks available in the checkout. In the final response, state whether the requested
skill was discovered and which skill/reference files were actually read, summarize the files changed, report every
test or check with its real exit status, and identify any verification limits.
```

## Observed run results

Tested on 2026-10-29 from skill revision `bce8d690`. All edits described below exist only in isolated copies.

| Harness             | Model               | Effort    | Result |
| ------------------- | ------------------- | --------- | ------ |
| Claude Code 2.1.312 | `claude-sonnet-5-5` | `medium`  | Pass   |
| Codex CLI 0.165.0   | `gpt-6-luna`        | `default` | Pass   |
| Copilot CLI 1.0.105 | `kimi-k3`           | `default` | Pass   |

### Claude Code 2.1.312

- Loaded the skill and reference and added the Site route, action, template, and focused test.
- Focused, Functional, Console, Unit, Psalm, syntax, and style checks passed.
- Browser Site and API request verification remained explicit limits.

### Codex CLI 0.165.0

- Added the same four artifacts; focused, Functional, syntax, style, and single-threaded Psalm checks passed.
- Verified that `/api/about` remained 404 and that the console runner still built.

### Copilot CLI 1.0.105

- Reported `kimi-k3` after the authorized retry and added the same four artifacts.
- Functional, Unit, Console, Psalm, style, and real-entry-point checks passed.
- The Site suite reached an unrelated process on port 8080; a separate real-server check passed.
