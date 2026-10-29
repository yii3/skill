# Evaluate a Yii3 package

These scenarios exercise package-specific decisions rather than application assembly or container wiring. Each model
must receive an independent copy of the same prepared base. The original package checkouts remain unchanged.

The evaluated working-tree skill snapshot is identified by these SHA-256 hashes:

- `yii3-package/SKILL.md`: `5df1c82768ebd5d8cd7b094a843b3a71767ddeb37a7d55cf8c7c91e04aef47ca`.
- `references/package-conventions.md`: `db364e546a2c61c6b9ccd2afcd3a5bff010adad06519b55202a45cd7ef13ff5b`.

The result tables record the requested harness, model, exposed effort, and factual execution state. A denied or aborted
invocation is not a model result, and an uncertain inference start is reported as such.

## Audit a general-purpose package contract

### Audit prompt

```text
Use `$yii3-package` in this disposable checkout of `yiisoft/log`.

This is a read-only package audit. Do not modify files, install or update dependencies, access the network, use secrets,
or create commits. Inspect the package before making any recommendation and report:

1. Whether this is a general-purpose or Yii-specific package, with evidence from Composer metadata, production source,
   and documentation.
2. The runtime and development dependency boundary. Trace every production use of `yiisoft/var-dumper`, determine
   whether its current Composer placement is correct, and distinguish direct requirements from optional log targets.
3. The observable public contract and release/compatibility evidence available locally, including interfaces, public
   classes and methods, deprecations, Composer constraints, changelog, tests, and tags.
4. The repository's selected test, static-analysis, benchmark, coding-style, and CI tools. Preserve its existing PHPUnit
   choice; do not migrate it to Testo or add tools.
5. Whether the README description of context-value formatting and installation requirements agrees with production
   code, and which official Yii package or guide sections are relevant without treating examples as universal rules.

Run only read-only commands that substantiate the report. In the final response, state whether the requested skill was
discovered and which skill/reference files were actually read, cite repository-relative evidence, list commands with
their real exit status, identify verification limits, and confirm whether the checkout remained unchanged. Do not infer
runtime behavior from Composer metadata alone.
```

### Audit base and acceptance

- Source: clean `yiisoft/log` revision `2e385fb3e992a601a53c7d49f400c83bf1b67ef9`.
- Prepared base: `/tmp/yii3-package-evaluation-20261029/log-audit-base`.
- Preflight: `composer validate --no-check-publish` exited `0`; `git status --porcelain` was empty.
- Factual dependency evidence: `Yiisoft\VarDumper\VarDumper` is imported by production `src/Message.php` and
  `src/Message/Formatter.php`; `yiisoft/var-dumper` is therefore a direct runtime dependency, not configuration-only.
- Post-run acceptance: `git status --porcelain` remains empty, `git diff --exit-code` exits `0`, and the recorded hashes
  of `composer.json`, `README.md`, `src/Message.php`, and `src/Message/Formatter.php` remain unchanged.

### Audit run results

| Harness         | Model        | Effort  | Result    |
| --------------- | ------------ | ------- | --------- |
| Claude 2.1.312  | Sonnet 5.5   | medium  | Completed |
| Codex 0.165.0   | `gpt-6-luna` | default | Completed |
| Copilot 1.0.105 | Kimi K3      | default | Completed |

### Audit result details

- Claude Code requested and observed `claude-sonnet-5-5`. It discovered both skill files, classified the package as a
  general-purpose PSR-3 library with optional Yii integration, and traced both production uses of `yiisoft/var-dumper`.
  It found that the dependency belongs in `require`, identified the PHPUnit/Psalm/PHPBench and CI toolchain, and
  reported README nuances around boolean and formatter context values. It could not execute tests because the checkout
  has no `vendor/`. Its structured result completed successfully with no permission denial or web search.
- Codex CLI requested `gpt-6-luna`. It discovered both skill files and reached the same package, dependency, contract,
  toolchain, and README conclusions. It reported one failed read of a nonexistent workflow before reading the actual
  `static.yml`. The turn completed successfully; no test or network command ran.
- GitHub Copilot CLI requested and observed `kimi-k3` in all 13 successful model calls. It discovered both skill files
  and independently reached the same classification and dependency conclusion. It also identified the public contract,
  deprecations, selected tools, and README behavior. No tests ran because dependencies were absent.
- All three audit copies finished clean. Their four recorded file hashes match the prepared base, and each model
  reported the verification limits instead of inferring executed behavior.

## Repair an immutable package API regression

### Repair prompt

```text
Use `$yii3-package` in this disposable checkout of `yii3/inertia`.

The evaluation fixture contains one controlled regression in the immutable configuration API of
`CsrfTokenCookieMiddleware`. It was introduced only in this disposable copy; do not report it as an upstream repository
bug. Reproduce the focused failure first, inspect the public contract and existing tests, then restore the intended
behavior with the smallest source change. Preserve every other public method, test, dependency, and documentation file.

Use the repository's existing PHPUnit harness. Do not migrate to Testo, weaken or rewrite assertions, install or update
dependencies, access the network or secrets, change `composer.lock`, add changelog entries for the fixture, or create
commits. Existing tests already cover the reported behavior; add a test only if you demonstrate a real coverage gap.

Run the focused middleware test before and after the change, followed by the relevant existing test, static-analysis,
dependency, and style checks that are available without network access. In the final response, state whether the
requested skill was discovered and which skill/reference files were actually read, explain the violated public
contract, list every changed file, report each command with its real exit status, and identify any baseline or
environment limits.
```

### Repair base and acceptance

- Source: clean `yii3/inertia` revision `1972a44a14bececf28ca503b5df21a207b8735c5`.
- Original pre-seed check: the focused PHPUnit file passed with `5` tests and `20` assertions.
- Prepared base: `/tmp/yii3-package-evaluation-20261029/inertia-regression-base`.
- Seeded change: only `CsrfTokenCookieMiddleware::withSecure()` returns the original instance instead of its configured
  clone. The seeded diff SHA-256 is `ad06ba6800bc6374463c4464bee20e7f197049ace33ca95b8b351ff90bd891c5`.
- Preflight reproduction: the focused test exited `1` with exactly two failures: it returned the same instance and an
  explicit `false` no longer overrode HTTPS secure-cookie detection.
- Post-run acceptance: the focused test exits `0` with `5` tests and `20` assertions; production code returns the clone;
  existing tests are not weakened; no unrelated file changes remain. The original checkout remains unchanged.
- Known baseline limit: the copied repository's `composer.lock` was already out of date with `composer.json`; agents
  must report that fact and must not update dependencies to hide it.

### Repair run results

| Harness         | Model        | Effort  | Result    |
| --------------- | ------------ | ------- | --------- |
| Claude 2.1.312  | Sonnet 5.5   | medium  | Completed |
| Codex 0.165.0   | `gpt-6-luna` | default | Completed |
| Copilot 1.0.105 | Kimi K3      | default | Completed |

### Repair result details

- Claude Code requested and observed `claude-sonnet-5-5`. It discovered both skill files, reproduced the two focused
  failures, restored `return $new`, and added no redundant test. The focused test passed with 5 tests and 20 assertions;
  the full suite passed with 64 tests and 296 assertions. PHPStan, the dependency checker, and ECS also passed. The
  final working tree matched `HEAD`.
- Codex CLI requested `gpt-6-luna`. It discovered both skill files, reproduced the regression, made the same one-line
  repair, and added no test. The focused and full test results matched Claude's. Direct PHPStan and dependency checks
  passed. ECS could not bind its local TCP socket, so Codex correctly left style verification unresolved. The final tree
  matched `HEAD`.
- GitHub Copilot CLI requested and observed `kimi-k3` in all 12 successful model calls. It discovered both skill files,
  reproduced the two failures, restored `return $new`, and added no test. The focused and full suites matched the other
  models. PHPStan, the dependency checker, and ECS passed in both its run and an independent verification. The final
  tree matched `HEAD`.

Initial harness-only failures that occurred before Claude and Codex inference are not counted as model results: Claude's
empty MCP object was changed to the required `mcpServers` object, and Codex's redundant sandbox option was removed
because `--approve-for-me` already selects `workspace-write`. These corrections did not change prompts, model
selections, skills, or package copies. An earlier Copilot repair launch was blocked before the command started; the
subsequently authorized retry completed and is the result reported above.
