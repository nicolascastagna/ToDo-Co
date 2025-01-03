<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Doctrine\Set\DoctrineSetList;

return RectorConfig::configure()
    ->withSets([
        // SymfonySetList::SYMFONY_54,
        LevelSetList::UP_TO_PHP_82,
        SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
        DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
        // SymfonySetList::SYMFONY_CODE_QUALITY,
        // SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
    ])
    ->withPaths([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withTypeCoverageLevel(0);
