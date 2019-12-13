<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Application\Symfony\Container\Compiler;

use function Safe\sprintf;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;

final class RegisterYmlValidationFile implements CompilerPassInterface
{
    /** @var string */
    private $boundedContextPath;

    public function __construct(string $boundedContextPath)
    {
        $this->boundedContextPath = $boundedContextPath;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $applicationDirectory = sprintf('%s/Application', $this->boundedContextPath);
        if (!is_dir($applicationDirectory)) {
            return;
        }

        /** @var \SplFileInfo[] $mappingFiles */
        $mappingFiles = Finder::create()->files()->in($applicationDirectory)->name('*.yml');

        $validationFiles = [];

        /** @var \SplFileInfo $file */
        foreach ($mappingFiles as $file) {
            $validationFiles[] = $file->getPathname();
        }

        $container->getDefinition('validator.builder')->addMethodCall(
            'addYamlMappings',
            [$validationFiles]
        );
    }
}
