# Installation guide

## Requirements

- Composer 2 and PHP 8.2 or later for `llm/skills` 1.15.0.
- A coding agent that supports project skills, or a manual workflow that reads a complete skill directory.
- A Yii3 application whose installed components and supported PHP versions are resolved independently.

This bundle has no Yii runtime dependency. Install the Composer plugin and the bundle as development dependencies of the
application in which agents will use them.

## Composer setup

Create `skills.json` in the application root before enabling the plugin:

```json
{
    "target": ".agents/skills",
    "aliases": [".claude/skills"],
    "auto-sync": true,
    "vendor-sources": false,
    "dependencies": {
        "composer": {
            "trusted-replace": true,
            "trusted": ["yii3/skill"]
        }
    }
}
```

The first stable `yii3/skill` release has not been published. Add the VCS repository and pin the current development
branch explicitly:

```bash
composer config repositories.yii3-skill vcs https://github.com/yii3/skill
composer config allow-plugins.llm/skills true
composer require --dev llm/skills:1.15.0 yii3/skill:dev-main
composer skills:show
```

Composer records the resolved commit in `composer.lock`. `dev-main` remains a moving branch, so review its changes
before updating. Replace that constraint with a stable release range only after the repository publishes a matching tag
and the consuming project has reviewed it.

## Local checkout testing

Use a Composer path repository when developing this package beside a disposable consumer:

```bash
composer config repositories.yii3-skill path ../skill
composer require --dev llm/skills:1.15.0 yii3/skill:dev-main
composer skills:show
```

Composer may symlink a path repository. Verify the installed source and synchronized target rather than assuming the
consumer contains an immutable copy. Keep local repository configuration out of shared application metadata unless the
team intentionally uses that path.

## Manual installation

Copy one complete `skills/<name>/` directory, including its `references/`, into the client's project skill path. Keep
the `<name>/SKILL.md` structure and one effective donor for each skill name. Manual copies do not receive Composer
synchronization or revision tracking.

[Back to documentation](../README.md#-documentation)
