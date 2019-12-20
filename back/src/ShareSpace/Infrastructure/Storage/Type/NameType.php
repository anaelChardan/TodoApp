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

abstract class NameType extends Type
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = $this->getFqcn();
        try {
            return $className::fromString((string) $value);
        } catch (\InvalidArgumentException $exception) {
            throw ConversionException::conversionFailed($value, $className);
        }
    }

    public function convertToDatabaseValue($name, AbstractPlatform $platform)
    {
        $className = $this->getFqcn();

        if ($name instanceof $className) {
            return (string) $name;
        }

        if (is_string($name)) {
            return $name;
        }

        throw ConversionException::conversionFailed($name, $className);
    }

    abstract protected function getFqcn(): string;
}
