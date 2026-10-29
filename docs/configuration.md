# Configuration guide

## Package trust

Keep `llm/skills` permission in the consuming application's Composer configuration. In `skills.json`,
`trusted-replace: true` replaces implicit trust with the exact package names listed in `dependencies.composer.trusted`.
Keep `vendor-sources: false` unless package-declared external sources have been reviewed separately.

Explicit Git and local-directory sources are trusted by their declaration. Pin a reviewed tag or commit when available.
Remove an older donor before adding another source that provides the same skill name.

## Client paths

| Client                    | Project path                                                           |
| ------------------------- | ---------------------------------------------------------------------- |
| Codex                     | `.agents/skills/<name>/SKILL.md`                                       |
| Claude Code               | `.claude/skills/<name>/SKILL.md`                                       |
| OpenCode                  | `.agents/skills/<name>/SKILL.md` or `.opencode/skills/<name>/SKILL.md` |
| GitHub Copilot in VS Code | `.agents/skills/<name>/SKILL.md` or `.github/skills/<name>/SKILL.md`   |

The recommended setup uses `.agents/skills` as the generated target and `.claude/skills` as an alias. Resolve an
existing real directory before configuring an alias at that path. Generated copies are not the authoring source.

## Package-owned skills

Yii3 is assembled from many Composer packages. A dependency may declare its own `extra.skills.source`, as `yii3/debug`
does for `yii3-debug-integration`. Approve the owning package by its exact Composer name when its skill is needed, then
verify the installed donor and synchronized target with:

```bash
composer skills:show
```

This command reports Composer sources and synchronization. It is not an internet catalog and does not prove that a
coding client discovered or loaded a skill. Do not copy a package-owned skill into this central bundle merely to make it
visible in the catalog.

## Synchronization and cleanup

With `auto-sync: true`, dependency installs and updates copy donor-owned files into the target. Local edits to generated
copies are overwritten. Retired files or skill directories may remain until deliberate cleanup.

Preview cleanup before accepting deletion:

```bash
composer skills:update --clean --dry-run
```

Unscoped cleanup may include manually authored skill directories. Review the preview and keep authored instructions
outside the generated target. Use `composer skills:update` when CI needs a failing exit code for synchronization.

[Back to documentation](../README.md#-documentation)
