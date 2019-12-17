<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Application\Write;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Todo\ShareSpace\Tool\MessageBus\QueryBus;
use Webmozart\Assert\Assert;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class UniqueIdentifierConstraintValidator extends ConstraintValidator
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @psalm-suppress MissingParamType
     * @psalm-suppress MixedAssignment
     * @psalm-suppress MixedMethodCall
     * @psalm-suppress ArgumentTypeCoercion
     *
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueIdentifierConstraint) {
            throw new UnexpectedTypeException($constraint, UniqueIdentifierConstraint::class);
        }

        try {
            Assert::string($value);
        } catch (\InvalidArgumentException $exception) {
            throw new UnexpectedValueException($value, 'string');
        }

        $class = $constraint->queryClass;

        Assert::classExists($class);
        Assert::methodExists($class, '__construct');

        $query = new $class();

        Assert::propertyExists($query, 'identifier');

        $query->identifier = $value;

        /** @var bool $result */
        $result = $this->queryBus->fetch($query);

        if (false === $result) {
            return;
        }

        $this
            ->context
            ->buildViolation($constraint->message)
            ->setParameter('{{ entity_name }}', $constraint->entityName)
            ->setParameter('{{ identifier }}', $value)
            ->addViolation()
        ;
    }
}
