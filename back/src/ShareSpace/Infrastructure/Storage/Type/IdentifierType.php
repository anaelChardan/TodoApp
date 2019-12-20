<?php
/**
 * MenuPleaz Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 MenuPleaz
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Infrastructure\Storage\Type;

use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

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
            throw ConversionException::conversionFailed($value, $className);
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

        throw ConversionException::conversionFailed($identifier, $className);
    }

    abstract protected function getFqcn(): string;
}
