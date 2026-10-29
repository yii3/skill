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

`yii3/skill` is published on Packagist, but it does not have a stable tagged release yet. Allow compatible `0.1`
development versions directly from Packagist:

```bash
composer config allow-plugins.llm/skills true
composer require --dev llm/skills:1.15.0 yii3/skill:^0.1@dev
composer skills:show
```

`^0.1@dev` is a development-compatible constraint, not a stable version or an exact pin. It currently resolves the
`0.1.x-dev` alias mapped to the moving `dev-main` branch. Composer records the resolved commit in `composer.lock`, so
review changes before updating. A custom VCS repository is unnecessary for the Packagist package; reserve repository
overrides for an unpublished fork or another deliberate development source.

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
