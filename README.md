<!-- markdownlint-disable MD041 -->
<p align="center">
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://www.yiiframework.com/image/design/logo/yii3_full_for_dark.svg">
        <source media="(prefers-color-scheme: light)" srcset="https://www.yiiframework.com/image/design/logo/yii3_full_for_light.svg">
        <img src="https://www.yiiframework.com/image/design/logo/yii3_full_for_light.svg" alt="Yii Framework" width="80%">
    </picture>
    <h1 align="center">Yii3 Skills</h1>
    <br>
</p>
<!-- markdownlint-enable MD041 -->

<p align="center">
    <a href="https://github.com/yii3/skill/actions/workflows/quality.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/yii3/skill/quality.yml?style=for-the-badge&label=Quality&logo=github" alt="Quality">
    </a>
    <a href="https://github.com/yii3/skill/actions/workflows/security.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/yii3/skill/security.yml?style=for-the-badge&label=Security&logo=github" alt="Security">
    </a>
</p>

<p align="center">
    <strong>Portable agent skills for Yii3 applications and packages</strong><br>
    <em>Evidence-first application discovery, package development, and container integration</em>
</p>

This package gives coding agents three focused workflows for Yii3 applications and packages. It discovers the components
and runners an application actually uses, preserves package contracts, and avoids treating Yii3 as one monolithic
framework package or imposing one project architecture.

## 🚀 Getting started

The package is published on Packagist but has no stable release yet. Allow compatible `0.1` development versions and
record the resolved revision in the consuming application's lock file:

```bash
composer config allow-plugins.llm/skills true
composer require --dev llm/skills:1.15.0 yii3/skill:^0.1@dev
composer skills:show
```

Create `skills.json` before installation when the project needs a non-default target, aliases, or an exact trust list.
See the [installation guide](docs/installation.md) for the recommended configuration and local-checkout testing.

## 🧭 Skill catalog

| Skill                                    | Use it for                                                     |
| ---------------------------------------- | -------------------------------------------------------------- |
| [`yii3-application`][application-skill]  | Application shape, components, entry points, and evidence      |
| [`yii3-container-integration`][di-skill] | Config, DI, providers, bootstrap, events, logs, and middleware |
| [`yii3-package`][package-skill]          | Package contracts, dependencies, tests, and contributions      |

[application-skill]: skills/yii3-application/SKILL.md
[di-skill]: skills/yii3-container-integration/SKILL.md
[package-skill]: skills/yii3-package/SKILL.md

Package-specific skills remain with their owning packages. For example, `yii3/debug` owns `yii3-debug-integration`; this
bundle explains how to discover such a workflow without copying it or claiming it was loaded.

## 📚 Documentation

- 📦 [Installation guide](docs/installation.md): Composer-first and manual installation.
- ⚙️ [Configuration guide](docs/configuration.md): trust, synchronization, client paths, and package-owned skills.
- 💡 [Usage examples](docs/examples.md): selecting a workflow and checking its result.
- 🧪 [Testing guide](docs/testing.md): deterministic validation and repository quality checks.
- 🧭 [Skill catalog](skills/README.md): scope and ownership of each portable bundle.

## 🤖 AI assistance

Agents should read the installed `SKILL.md` and only the references it routes to. Repository installation, client
discovery, instruction loading, and successful task behavior are separate facts; report each one honestly.

This repository does not yet publish a hosted AI documentation index. Use the versioned files in this repository or the
exact installed package revision. Resolve package-specific instructions from the owning dependency rather than assuming
this catalog contains every Yii3 package.

## 📦 Package information

The bundle contains instructions and referenced resources only. It has no Yii or application runtime dependencies.
Composer is the primary distribution path; each directory under `skills/` is also a complete portable bundle.

The package is available from Packagist, but the first stable release has not been published. The `^0.1@dev` constraint
currently resolves the `0.1.x-dev` alias mapped to the moving `dev-main` branch; the exact revision comes from the
consuming project's lock file.

## Built with AI

[![Built with Claude Code](https://img.shields.io/badge/Built%20with-Claude%20Code-D97757.svg?style=for-the-badge&logo=claude&logoColor=white)](https://claude.com/claude-code)
[![Reviewed by Codex](https://img.shields.io/badge/Reviewed%20by-Codex-10A37F.svg?style=for-the-badge&logo=openaigym&logoColor=white)](https://openai.com/codex)
[![Reviewed by CodeRabbit](https://img.shields.io/badge/Reviewed%20by-CodeRabbit-FF570A.svg?style=for-the-badge&logo=coderabbit&logoColor=white)](https://www.coderabbit.ai)

## 📄 License

[![License](https://img.shields.io/badge/License-BSD--3--Clause-brightgreen.svg?style=for-the-badge&logo=opensourceinitiative&logoColor=white&labelColor=555555)](LICENSE)
