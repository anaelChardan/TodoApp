<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\ShareSpace\Application\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Todo\ShareSpace\Application\DomainDrivenDesign\BoundedContextExtension;
use Todo\ShareSpace\Application\Symfony\Container\Compiler\RegisterYmlValidationFile;
use Todo\ShareSpace\Application\Symfony\Container\SymfonyExtension;
use Todo\Todo\Infrastructure\Application\DomainDrivenDesign\TodoExtension;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    /**
     * @return \Generator
     *
     * @psalm-suppress MixedMethodCall
     *
     * @psalm-return \Generator<int, object, mixed, void>
     */
    public function registerBundles(): iterable
    {
        /** @var string $environment */
        $environment = $this->environment;
        /**
         * @var array
         * @psalm-suppress UnresolvableInclude
         */
        $contents = require $this->getProjectDir().'/config/bundles.php';
        /**
         * @var string[]
         * @var class-string $class
         */
        foreach ($contents as $class => $envs) {
            if ($envs[$environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    public function getLogDir()
    {
        return $this->getProjectPath('var/logs');
    }

    public function getCacheDir(): string
    {
        return $this->getProjectPath('var/cache/'.$this->getEnvironment());
    }

    public function getProjectDir(): string
    {
        return \dirname(__DIR__).'/../../..';
    }

    public function getProjectPath(string $extraPath): string
    {
        return $this->getProjectDir().'/'.$extraPath;
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        foreach ($this->registeredBoundedContexts() as $boundedContextExtension) {
            $this->configureBoundedContext($boundedContextExtension, $container);
        }

        $container->addResource(new FileResource($this->getProjectDir().'/config/bundles.php'));
        $container->setParameter('container.dumper.inline_class_loader', \PHP_VERSION_ID < 70400 || !ini_get('opcache.preload'));
        $container->setParameter('container.dumper.inline_factories', true);
        $confDir = $this->getProjectPath('config');

        $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment().'/**/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/services/default/**/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/services/'.$this->environment().'/**/*'.self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectPath('config');

        $routes->import($confDir.'/routes/default/**/*'.self::CONFIG_EXTS, '/', 'glob');
    }

    private function environment(): string
    {
        /** @var string|null $environment */
        $environment = $this->environment;

        return $environment ?? '';
    }

    private function configureBoundedContext(BoundedContextExtension $boundedContext, ContainerBuilder $container): void
    {
        $container->registerExtension(new SymfonyExtension($boundedContext));
        $container->addCompilerPass(new RegisterYmlValidationFile($boundedContext->path()));
    }

    /**
     * @return BoundedContextExtension[]
     */
    private function registeredBoundedContexts(): array
    {
        return [
            new TodoExtension(),
        ];
    }
}
