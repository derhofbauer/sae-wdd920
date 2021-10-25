<?php

namespace Core;

use Core\Config;

/**
 * @todo: comment
 */
class Database
{

    private object $link;
    private object $stmt;
    private mixed $lastResult;
    private array $data;

    public function __construct()
    {
        $this->link = new \mysqli(
            Config::get('database.host'),
            Config::get('database.user'),
            Config::get('database.password'),
            Config::get('database.dbname'),
            Config::get('database.port', 3306),
            Config::get('database.socket')
        );

        $this->link->set_charset('utf8');
    }

    public function query(string $query, array $params = []): bool|array
    {
        if (empty($params)) {
            $this->lastResult = $this->executeQuery($query);
        } else {
            $this->lastResult = $this->prepareStatementAndExecuteQuery($query, $params);
        }

        if ($this->lastResult === false) {
            if ($this->stmt->errno === 0) {
                $this->lastResult = true;
            }
        }

        if (is_bool($this->lastResult)) {
            return $this->lastResult;
        }

        $this->data = $this->lastResult->fetch_all(MYSQLI_ASSOC);

        return $this->data;
    }

    private function executeQuery(string $query): \mysqli_result|bool
    {
        return $this->link->query($query);
    }

    private function prepareStatementAndExecuteQuery(string $queryWithPlaceholders, array $params): \mysqli_result|bool
    {
        $this->stmt = $this->link->prepare($queryWithPlaceholders);

        $paramTypes = [];
        $paramValues = [];

        foreach ($params as $typeAndName => $value) {
            $paramTypes[] = explode(':', $typeAndName)[0];

            $_value = $value;
            $paramValues[] = &$_value;
            unset($_value);
        }

        $paramTypesString = implode('', $paramTypes); // ['s', 's', 'i', 'd'] => 'ssid'

        $this->stmt->bind_param($paramTypesString, ...$paramValues);
        $this->stmt->execute();
        return $this->stmt->get_result();
    }

    /**
     * @return \mysqli|object
     */
    public function getLink(): \mysqli
    {
        return $this->link;
    }

    /**
     * @return mixed
     */
    public function getLastResult(): mixed
    {
        return $this->lastResult;
    }

    public function getInsertId(): int|string
    {
        return $this->link->insert_id;
    }

    public function getResult(): array
    {
        return $this->lastResult->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function __destruct()
    {
        $this->link->close();
    }
}
