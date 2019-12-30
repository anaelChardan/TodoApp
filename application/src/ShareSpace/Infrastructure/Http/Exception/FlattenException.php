<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Infrastructure\Http\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Validator\ConstraintViolationInterface;

final class FlattenException extends \Exception
{
    /** @var int */
    private $statusCode = 500;

    /** @var string */
    private $class = '';

    /** @var array */
    private $errors = [];

    private function __construct(\Throwable $throwable)
    {
        parent::__construct($throwable->getMessage(), (int) $throwable->getCode(), $throwable);
        $this->file = $throwable->getFile();
        $this->line = $throwable->getLine();
        $this->class = get_class($throwable);

        if ($throwable instanceof HttpExceptionInterface) {
            $this->statusCode = $throwable->getStatusCode();
        }

        if ($throwable instanceof ValidationFailedException) {
            $this->statusCode = 400;
            /** @var ConstraintViolationInterface $violation */
            foreach ($throwable->getViolations() as $violation) {
                $this->errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
        }
    }

    public static function createFrom(\Throwable $throwable): self
    {
        return new self($throwable);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
