<?php

/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

declare(strict_types=1);

namespace Todo\Todo\Infrastructure\UserInterface\Mercure;

use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use Todo\Todo\Domain\TodoList\Write\Event\TaskAdded;
use Todo\Todo\Domain\TodoList\Write\Event\TodoListCreated;

final class MercureSseEventHandler implements MessageSubscriberInterface
{
    private Publisher $publisher;

    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    public function __invoke(TodoListCreated $todoListCreated): void
    {
        $this->publish(
            'http://test.com/todo-list',
            ['event' => 'TodoListCreated', 'todo_list_identifier' => $todoListCreated->todoListIdentifier]
        );
    }

    public function taskAdded(TaskAdded $taskAdded): void
    {
        $this->publish(
            'http://test.com/todo-list/'.$taskAdded->todoListIdentifier,
            ['event' => 'TaskAdded', 'task_identifier' => $taskAdded->taskIdentifier]
        );
    }

    private function publish(string $url, array $data): void
    {
        \Safe\file_put_contents('/srv/todo/var/cache/toto.json', "JESUISCOOL");
        ($this->publisher)(new Update($url, \Safe\json_encode($data)));
    }

    public static function getHandledMessages(): iterable
    {
        yield TodoListCreated::class;
        yield TaskAdded::class => ['method' => 'taskAdded'];
    }
}
