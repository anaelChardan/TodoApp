<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Tool\MessageBus\Command;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Webmozart\Assert\Assert;

final class IdentifierMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        if (property_exists($message, 'identifier')) {
            $lastIdentifierGeneratedStampHasNotBeenGenerated = null === $envelope->last(IdentifierGeneratedStamp::class);
            if ($lastIdentifierGeneratedStampHasNotBeenGenerated) {
                if (null === $message->identifier) {
                    $uuid = Uuid::uuid4();
                    $message->identifier = $uuid->toString();
                    $envelope = $envelope->with(new IdentifierGeneratedStamp($uuid));
                } else {
                    Assert::string($message->identifier);
                    $identifier = (string) $message->identifier;
                    Assert::uuid((string) $identifier);
                    $uuid = Uuid::fromString($identifier);
                    $envelope = $envelope->with(new IdentifierGeneratedStamp($uuid));
                }
            }
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
