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
use Todo\Todo\Domain\TodoList\Read\CountTaskForTodoList;

final class DoctrineCountTaskPerTodoList implements CountTaskForTodoList
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function __invoke(string $todoListName): int
    {
        $query = <<<SQL
SELECT COUNT(todo_list_identifier)
FROM task 
INNER JOIN todo_list tl on task.todo_list_identifier = tl.identifier
WHERE tl.name = :todo_list_name
GROUP BY todo_list_identifier
SQL;

        $result = $this->connection->fetchColumn($query, ['todo_list_name' => $todoListName]);

        return (int) $result;
    }
}
