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
use Doctrine\DBAL\FetchMode;
use Todo\Todo\Domain\TodoList\Read\GetTodoListDetails;
use Todo\Todo\Domain\TodoList\Read\Task;
use Todo\Todo\Domain\TodoList\Read\TodoList;

final class DoctrineGetTodoListDetails implements GetTodoListDetails
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function __invoke(string $todoListIdentifier): TodoList
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
WHERE todo_list.identifier = :todo_list_identifier
GROUP BY todo_list.identifier
SQL;

        /** @var array<string, string> $result */
        $result = $this->connection->fetchAssoc(
            $query,
            ['todo_list_identifier' => $todoListIdentifier],
            ['todo_list_identifier' => \PDO::PARAM_STR]
        );

        /** @var array<array<string, string>> $tasks */
        $tasks = \Safe\json_decode($result['tasks'], true);
        $tasksObject = [];

        /** @var array<string, string> $task */
        foreach ($tasks as $task) {
            $tasksObject[] = new Task($task['task_identifier'], $task['task_name']);
        }

        return new TodoList(
            (string) $result['todo_list_identifier'],
            (string) $result['todo_list_name'],
            (int) $result['task_count'],
            $tasksObject
        );
    }
}
