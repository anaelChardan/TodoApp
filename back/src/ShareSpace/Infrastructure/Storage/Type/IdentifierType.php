<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Infrastructure\Storage\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Todo\ShareSpace\Domain\Identifier;

abstract class IdentifierType extends Type
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = $this->getFqcn();
        try {
            return $className::fromUuidString((string) $value);
        } catch (\InvalidArgumentException $exception) {
            throw ConversionException::conversionFailed((string) $value, $className);
        }
    }

    public function convertToDatabaseValue($identifier, AbstractPlatform $platform)
    {
        $className = $this->getFqcn();

        if ($identifier instanceof $className) {
            return (string) $identifier;
        }

        if (is_string($identifier)) {
            return $identifier;
        }

        throw ConversionException::conversionFailed((string) $identifier, $className);
    }

    /**
     * @return class-string<Identifier>
     */
    abstract protected function getFqcn(): string;
}
