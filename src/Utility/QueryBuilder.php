<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 16.06.18
 * Time: 16:37
 */

/**
 * Basic QueryBuilder with support for raw queries
 * and includes a database connection
 * @author Nikolaj Keist (lemony.io) github.com/n-keist
 */

namespace Angle\Utility;

use \PDO;

class QueryBuilder {

    private $connection = null;
    private $raw = false;
    private $table;
    private $queryType = null;
    private $queryHasWhereClause = false;
    private $queryWhereUseAnd = false;
    private $finalQuery;
    private $finalParams = [];
    private $queryUpdate;
    private $queryInsert;
    private $querySelect;
    private $queryWhere;
    private $queryOrderType;
    private $queryOrderColumn;
    private $queryUseOrder = false;
    private $queryUseLimit = false;
    private $queryLimitOffset;
    private $queryLimitCount;


    protected function __clone() {
    }

    public function __construct($host, $database, $user, $password) {
        try {
            $pdo = new PDO("mysql:host=" . $host . ";dbname=" . $database . ";charset=utf8", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection = $pdo;
        } catch (\PDOException $e) {
            echo "PDO Unable to connect. (" . $e->getMessage() . ")";
        }
    }

    /**
     * @return PDO the created SQL Connection
     */
    public function getConnection(): PDO {
        return $this->connection;
    }

    /**
     * @return string the created SQL Query
     */
    public function getQuery(): string {
        try {
            self::build();
        } catch (\Exception $e) {
            print_r($e);
            die();
        }
        return $this->finalQuery;
    }

    /**
     * since this class is based on prepared statements it automatically creates all the
     * necessary parameters
     * @return array with all parameters
     */
    public function getParams(): array {
        return $this->finalParams;
    }

    /**
     * If you do not want to use the QueryBuilder (in this class included)
     * you are able to run raw queries
     * @return QueryBuilder
     */
    public function raw(string $query, array $params = []): QueryBuilder {
        $this->raw = true;
        $this->finalQuery = $query;
        $this->finalParams = $params;
        return $this;
    }

    /**
     * pick a table
     * @param $table The Table name
     * @return QueryBuilder chainable class
     */
    public function table(string $table): QueryBuilder {
        $this->raw = false;
        $this->table = $table;
        return $this;
    }

    /**
     * @param $columns colums with column => value syntax
     * @return QueryBuilder chainable class
     */
    public function update(array $columns): QueryBuilder {
        $this->queryType = "update";
        $this->queryUpdate = $columns;
        return $this;
    }

    /**
     * @param $columns colums with column => value syntax
     * @return QueryBuilder chainable class
     */
    public function insert(array $columns): QueryBuilder {
        $this->queryType = "insert";
        $this->queryInsert = $columns;
        return $this;
    }

    /**
     * tells the query builder that you are trying to delete an entry
     * @return QueryBuilder chainable class
     */
    public function delete(): QueryBuilder {
        $this->queryType = "delete";
        return $this;
    }

    /**
     * @param string columns the string type of rows you want to select e.g. "id,fullname"
     * @return QueryBuilder chainable class
     */
    public function select(string $columns): QueryBuilder {
        $this->queryType = "select";
        $this->querySelect = $columns;
        return $this;
    }

    /**
     * @param array $columns syntax e.g. id => 13
     * @param bool $useAnd use AND in the Where clause
     * @return QueryBuilder chainable class
     */
    public function where(array $columns, bool $useAnd = false): QueryBuilder {
        $this->queryWhere = $columns;
        $this->queryHasWhereClause = true;
        $this->queryWhereUseAnd = $useAnd;
        return $this;
    }

    /**
     * @param string $orderType ASC or DESC
     * @param string $orderColumn the column you want it to be ordered by
     * @return QueryBuilder chainable class
     */
    public function order(string $orderType, string $orderColumn): QueryBuilder {
        $this->queryOrderType = $orderType;
        $this->queryOrderColumn = $orderColumn;
        $this->queryUseOrder = true;
        return $this;
    }

    /**
     * @param int $itemCount the amount of items you want to be displayed
     * @param int $offset the offset you want to apply
     * @return QueryBuilder chainable class
     */
    public function limit(int $itemCount, int $offset): QueryBuilder {
        $this->queryUseLimit = true;
        $this->queryLimitCount = $itemCount;
        $this->queryLimitOffset = $offset;
        return $this;
    }

    /**
     * builds the query
     * @throws \Exception
     */
    private function build() {
        if ($this->queryType == "update") {
            $query = "UPDATE `{$this->table}` SET ";
            foreach ($this->queryUpdate as $key => $value) {
                $query .= "`{$key}` = :{$key}, ";
                $this->finalParams[$key] = $value;
            }
            $query = trim($query, ', ');
            if ($this->queryHasWhereClause) {
                $query .= " WHERE ";
                foreach ($this->queryWhere as $key => $value) {
                    $query .= "`{$key}` = :{$key} " . ($this->queryWhereUseAnd ? "AND" : "OR");
                    $this->finalParams[$key] = $value;
                }
                $query = trim($query, ($this->queryWhereUseAnd ? "AND" : "OR"));
            }
            $query .= ";";
            $this->finalQuery = $query;
        } else if ($this->queryType == "insert") {
            $query = "INSERT INTO `{$this->table}` (";
            foreach ($this->queryInsert as $key => $value) {
                $query .= "`{$key}`, ";
            }
            $query = trim($query, ', ') . ") VALUES (";
            foreach ($this->queryInsert as $key => $value) {
                $query .= ":{$key}, ";
                $this->finalParams[$key] = $value;
            }
            $query = trim($query, ", ") . ");";
            $this->finalQuery = $query;
        } elseif ($this->queryType == "select") {
            $query = "SELECT {$this->querySelect}" . ($this->queryHasWhereClause ? " WHERE " : "");
            if ($this->queryHasWhereClause) {
                foreach ($this->queryWhere as $key => $value) {
                    $query .= "`{$key}` = :{$key}" . ($this->queryWhereUseAnd ? " AND " : " OR ");
                    $this->finalParams[$key] = $value;
                }
                $query = trim($query, ($this->queryWhereUseAnd ? "AND " : "OR "));
            }
            if ($this->queryUseOrder) {
                $query .= " ORDER BY `{$this->queryOrderColumn}` {$this->queryOrderType}";
            }
            if ($this->queryUseLimit) {
                $query .= " LIMIT {$this->queryLimitOffset}, {$this->queryLimitCount}";
            }
            $query .= ";";
            $this->finalQuery = $query;
        } elseif ($this->queryType == "delete") {
            $query = "DELETE FROM `{$this->table}` ";
            if ($this->queryHasWhereClause) {
                $query .= "WHERE ";
                foreach ($this->queryWhere as $key => $value) {
                    $query .= "`{$key}` = :{$key}" . ($this->queryWhereUseAnd ? " AND " : " OR ");
                    $this->finalParams[$key] = $value;
                }
                $query = trim($query, $this->queryWhereUseAnd ? " AND " : " OR ");
            }
            $query .= ";";
            $this->finalQuery = $query;
        } else {
            throw new \Exception("Unknown query type", 1);
        }
    }

    /**
     * @return int|array (lastInsertId) or array(Data) depending on query type
     */
    public function execute() {
        $statement = $this->connection->prepare($this->finalQuery);
        $statement->execute($this->finalParams);
        if (explode(' ', $query)[0] == 'SELECT') {
            $data = $statement->fetchAll();
            return $data;
        }
        if (explode(' ', $query)[0] == 'INSERT') {
            return $this->connection->lastInsertId();
        }
    }

    /**
     * closes the PDO Connection
     */
    public function closeConnection() {
        $this->connection = null;
    }

    public function resetClass() {
        foreach ($this as $key) {
            unset($this->$key);
        }
    }
}