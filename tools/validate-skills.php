<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$errors = [];

$composerPath = $root . '/composer.json';
$composer = json_decode(
    file_get_contents($composerPath) ?: '',
    true,
    512,
    JSON_THROW_ON_ERROR,
);

$source = $composer['extra']['skills']['source'] ?? null;
if (!is_string($source) || $source === '') {
    $errors[] = 'composer.json must declare a non-empty extra.skills.source.';
    $source = 'skills';
}

$skillsPath = $root . '/' . $source;
if (!is_dir($skillsPath)) {
    $errors[] = sprintf('Skill source directory does not exist: %s', $source);
}

$skillDirectories = glob($skillsPath . '/*', GLOB_ONLYDIR) ?: [];
sort($skillDirectories);

if ($skillDirectories === []) {
    $errors[] = 'No skill directories were found.';
}

foreach ($skillDirectories as $skillDirectory) {
    $name = basename($skillDirectory);
    $skillFile = $skillDirectory . '/SKILL.md';

    if (!is_file($skillFile)) {
        $errors[] = sprintf('%s is missing SKILL.md.', $name);
        continue;
    }

    $contents = file_get_contents($skillFile) ?: '';
    if (!preg_match('/\A---\R(.*?)\R---\R/s', $contents, $frontmatterMatch)) {
        $errors[] = sprintf('%s/SKILL.md has invalid frontmatter.', $name);
        continue;
    }

    $frontmatter = $frontmatterMatch[1];
    if (!preg_match('/^name:\s*([^\s]+)\s*$/m', $frontmatter, $nameMatch) || $nameMatch[1] !== $name) {
        $errors[] = sprintf('%s/SKILL.md name must match its directory.', $name);
    }
    if (!preg_match('/^description:\s*\S.+$/m', $frontmatter)) {
        $errors[] = sprintf('%s/SKILL.md must have a description.', $name);
    }
    if (!preg_match('/^license:\s*BSD-3-Clause\s*$/m', $frontmatter)) {
        $errors[] = sprintf('%s/SKILL.md must declare the BSD-3-Clause license.', $name);
    }
    if (preg_match('/\b(TODO|TBD|PLACEHOLDER)\b/i', $contents)) {
        $errors[] = sprintf('%s/SKILL.md contains an unfinished placeholder.', $name);
    }

    validateMarkdownLinks($skillFile, $root, $errors);

    $referencesPath = $skillDirectory . '/references';
    if (is_dir($referencesPath)) {
        foreach (glob($referencesPath . '/*.md') ?: [] as $reference) {
            $relative = 'references/' . basename($reference);
            if (!str_contains($contents, '(' . $relative . ')')) {
                $errors[] = sprintf('%s does not route to %s.', $name, $relative);
            }
            validateMarkdownLinks($reference, $root, $errors);
        }
    }
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST,
);
foreach ($iterator as $item) {
    if (!$item->isDir()) {
        continue;
    }

    $path = $item->getPathname();
    if (str_contains($path, '/.git') || str_contains($path, '/vendor') || str_contains($path, '/node_modules')) {
        continue;
    }

    if ((new FilesystemIterator($path))->valid() === false) {
        $errors[] = sprintf('Empty directory: %s', relativePath($root, $path));
    }
}

$attributes = shell_exec(
    sprintf(
        'git -C %s check-attr export-ignore -- %s 2>/dev/null',
        escapeshellarg($root),
        escapeshellarg($source),
    ),
);
if (is_string($attributes) && !str_contains($attributes, 'unspecified')) {
    $errors[] = sprintf('%s must be included in Git archives.', $source);
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, '[ERROR] ' . $error . PHP_EOL);
    }
    exit(1);
}

printf("Validated %d skills.\n", count($skillDirectories));

/**
 * @param list<string> $errors
 */
function validateMarkdownLinks(string $file, string $root, array &$errors): void
{
    $contents = file_get_contents($file) ?: '';
    preg_match_all('/\[[^\]]*]\(([^)]+)\)/', $contents, $matches);

    foreach ($matches[1] as $target) {
        $target = trim($target, '<>');
        if (
            $target === ''
            || str_starts_with($target, '#')
            || preg_match('#^[a-z][a-z0-9+.-]*:#i', $target)
        ) {
            continue;
        }

        $path = explode('#', $target, 2)[0];
        if ($path === '') {
            continue;
        }

        $resolved = dirname($file) . '/' . rawurldecode($path);
        if (!file_exists($resolved)) {
            $errors[] = sprintf(
                '%s has a broken local link: %s',
                relativePath($root, $file),
                $target,
            );
        }
    }
}

function relativePath(string $root, string $path): string
{
    return ltrim(str_replace($root, '', $path), '/');
}
