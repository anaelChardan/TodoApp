<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\Behat;

use Todo\ShareSpace\Application\DomainDrivenDesign\Command;
use Todo\ShareSpace\Domain\Identifier;
use Todo\ShareSpace\Tool\MessageBus\CommandBus;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Webmozart\Assert\Assert;

final class BusValidationHelper
{
    public static function testCreate(
        CommandBus $bus,
        Command $command,
        $repository,
        ?Identifier $identifier = null,
        ?string $expectedClass = null,
        ?callable $extraAssertOnEntity = null
    ): void {
        $before = $repository->count();
        try {
            $bus->dispatch($command);
        } catch (ValidationFailedException $exception) {
            $violations = [];
            /** @var ConstraintViolationInterface $violation */
            foreach ($exception->getViolations() as $violation) {
                $violations[] = $violation->getMessage();
            }
            throw new \Exception(sprintf('Errors in validation: %s', implode("/n", $violations)));
        }

        if ($identifier !== null) {
            $entity = $repository->get($identifier);
            if (null === $entity) {
                throw new \LogicException("No entity has been created");
            }

            Assert::isInstanceOf($entity, $expectedClass);

            if (null !== $extraAssertOnEntity) {
                $extraAssertOnEntity($entity);
            }

        }

        $after = $repository->count();

        if ($after <= $before) {
            throw new \LogicException("No entity has been created");
        }
    }

    public static function testCannotCreate(
        CommandBus $bus,
        Command $command
    ): void {
        try {
            $bus->dispatch($command);
        } catch (ValidationFailedException $exception) {
            return;
        }

        throw new \Exception("An exception should have been thrown");
    }
}
