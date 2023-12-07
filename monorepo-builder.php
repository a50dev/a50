<?php

declare(strict_types=1);

use Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\AddTagToChangelogReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushNextDevReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateReplaceReleaseWorker;

return static function (MBConfig $mbConfig): void {
    $mbConfig->packageDirectories([__DIR__ . '/packages']);
    $mbConfig->packageDirectoriesExcludes([__DIR__ . '/packages/next-package']);

    $mbConfig->defaultBranch('main');

    // release workers - in order to execute
    $mbConfig->workers([
        UpdateReplaceReleaseWorker::class,
        SetCurrentMutualDependenciesReleaseWorker::class,
        AddTagToChangelogReleaseWorker::class,
        TagVersionReleaseWorker::class,
        PushTagReleaseWorker::class,
        SetNextMutualDependenciesReleaseWorker::class,
        UpdateBranchAliasReleaseWorker::class,
        PushNextDevReleaseWorker::class,
    ]);

    // what extra parts to add after merge?
    $mbConfig->dataToAppend([
        ComposerJsonSection::REQUIRE_DEV => [
            'friendsofphp/php-cs-fixer' => '^3.16',
            'phpstan/extension-installer' => '^1.2',
            'phpstan/phpstan' => '^1.10',
            'phpstan/phpstan-phpunit' => '^1.3',
            'phpunit/phpunit' => '^9.6',
            "roave/security-advisories" => "dev-latest",
            "dg/bypass-finals" => "^1.3",
        ],
        ComposerJsonSection::SCRIPTS => [
            'cs.lint' => 'php-cs-fixer fix --config=.php-cs-fixer.php --allow-risky=yes --dry-run --diff',
            'cs.fix' => 'php-cs-fixer fix --config=.php-cs-fixer.php --allow-risky=yes',
            'analyse' => 'phpstan analyse -c phpstan.neon',
            'test' => 'vendor/bin/phpunit --colors=always',
        ]
    ]);
};
