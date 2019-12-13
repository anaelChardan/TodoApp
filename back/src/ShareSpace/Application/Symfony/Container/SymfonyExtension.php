<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Application\Symfony\Container;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Todo\ShareSpace\Application\DomainDrivenDesign\BoundedContextExtension;

final class SymfonyExtension implements ExtensionInterface
{
    /** @var BoundedContextExtension */
    private $boundedContextExtension;

    public function __construct(BoundedContextExtension $boundedContextExtension)
    {
        $this->boundedContextExtension = $boundedContextExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        // TODO: Implement load() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace(): string
    {
        return 'http://example.org/schema/dic/'.$this->getAlias();
    }

    /**
     * {@inheritdoc}
     */
    public function getXsdValidationBasePath(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return $this->boundedContextExtension->name();
    }
}
