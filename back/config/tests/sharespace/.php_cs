<?php

$rootDirectory = sprintf('%s/../../../', __DIR__);
$contextDirectory = sprintf('%s/src/ShareSpace', $rootDirectory);

$finder = PhpCsFixer\Finder::create()
    ->exclude('Test/Specification')
    ->in($contextDirectory)
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setCacheFile(sprintf('%svar/php_cs.cache', $rootDirectory))
    ->setFinder($finder)
;
