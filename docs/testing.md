# Testing

This skills-only package has no framework runtime test suite. It provides deterministic structural validation and the
same repository quality and workflow-security checks used in CI.

## Skill validation

Validate the Composer source declaration, skill frontmatter, local Markdown links, routed references, empty directories,
and export rules:

```bash
composer validate-skills
```

This proves package structure, not native client discovery or correct behavior on a Yii3 task. Test those separately in
a disposable consuming project with the installation flow from the [installation guide](installation.md).

## Repository quality checks

Make actionlint with ShellCheck, codespell, EditorConfig Checker, markdownlint-cli2, Prettier, and yamllint available on
`PATH`, then run:

```bash
composer quality
```

Each script is also independently runnable. CI uses the same linter configuration under `.github/linters` and the
Prettier configuration at the repository root.

## Workflow security checks

Make zizmor and Gitleaks available on `PATH`, then run:

```bash
composer security
```

Zizmor needs GitHub API access for online audits. If it runs offline, report that limit separately. Findings should be
investigated rather than disabled.

[Back to documentation](../README.md#-documentation)
