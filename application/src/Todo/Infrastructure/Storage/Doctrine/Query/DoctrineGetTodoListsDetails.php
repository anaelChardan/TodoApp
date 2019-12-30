<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Infrastructure\Storage\Doctrine\Query;

use Doctrine\DBAL\Connection;
use Todo\Todo\Domain\TodoList\Read\GetTodoListsDetails;
use Todo\Todo\Domain\TodoList\Read\Task;
use Todo\Todo\Domain\TodoList\Read\TodoList;
use Todo\Todo\Domain\TodoList\Read\TodoLists;

final class DoctrineGetTodoListsDetails implements GetTodoListsDetails
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function __invoke(): TodoLists
    {
        $query = <<<SQL
SELECT
    todo_list.identifier as todo_list_identifier,
    todo_list.name as todo_list_name,
    count(t) as task_count,
    coalesce(
        json_agg(json_build_object('task_identifier', t.identifier, 'task_name', t.name)) FILTER ( WHERE t.identifier IS NOT NULL ),
        '[]'
    ) as tasks
FROM todo_list
LEFT JOIN task t on todo_list.identifier = t.todo_list_identifier
GROUP BY todo_list.identifier
SQL;

        $result = $this->connection->executeQuery($query)->fetchAll();

        $todoLists = [];

        /** @var array<string, string> $todoList */
        foreach ($result as $todoList) {
            /** @var array<array<string, string>> $tasks */
            $tasks = \Safe\json_decode($todoList['tasks'], true);
            $tasksObject = [];
            foreach ($tasks as $task) {
                $tasksObject[] = new Task($task['task_identifier'], $task['task_name']);
            }

            $todoLists[] = new TodoList(
                (string) $todoList['todo_list_identifier'],
                (string) $todoList['todo_list_name'],
                (int) $todoList['task_count'],
                $tasksObject
            );
        }

        return new TodoLists($todoLists);
    }
}
