<?php

namespace ItsPixStore\Database;

class Database
{

    private $driver = 'mysql'; // default driver
    private $port = 3306; // default port
    private $host = "localhost"; // default host
    private $username = "root"; // default username
    private $password = "Vush@w123"; // default password
    private $dbname = "itspixstoredev"; // default database name

    private $connection = null; // database connection
    private $table = null; // table name
    private $columns = null; // columns
    private $data = []; // data (columns and values)
    private $sql = null; // sql query

    /**
     * Database constructor.
     * @param string $table
     * @param string $columns
     */
    public function __construct()
    {
        try {
            $this->connection = new \PDO("$this->driver:host=$this->host;port=$this->port;", $this->username, $this->password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->connection->query("CREATE DATABASE IF NOT EXISTS $this->dbname");
            $this->connection->query("USE $this->dbname");
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Set the table name
     * @param $table
     * @return $this
     */
    public function table($table): Database
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Initilize the SELECT query with the columns
     * @param $columns
     * @return $this
     */
    public function select(): Database
    {
        $args = func_get_args();

        $this->sql = "SELECT ";

        if (count($args) > 0) {
            $this->sql .= implode(', ', $args);
        } else {
            $this->sql .= "*";
        }

        $this->sql .= " FROM $this->table";

        return $this;
    }

    /**
     * where method: add WHERE clause to the query
     *
     * @return $this
     * @throws \Exception
     */
    public function where(): Database
    {
        try {
            $args = func_get_args();

            if (preg_match('(SELECT|UPDATE|DELETE)', $this->sql) == 0) {
                throw new \Exception("You must use the select() or update() or delete() method before using the where() method");
            }

            if (str_contains($this->sql, "WHERE")) {
                $this->sql .= " AND $args[0] ";
            } else {
                $this->sql .= " WHERE $args[0] "
                ;
            }


            if (count($args) === 3) {
                $this->sql .= "$args[1] :$args[0]";
                $this->data = array_merge($this->data, [$args[0] => $args[2]]);

            } elseif (count($args) === 2) {
                $this->sql .= is_integer($args[1]) ? "= :$args[0]" : "LIKE :$args[0]";
                $this->data = array_merge($this->data, [$args[0] => $args[1]]);
            } else {
                throw new \Exception("Invalid arguments");
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    /**
     * Or Where method: used to add an OR condition to the WHERE clause
     * @return $this
     */
    public function orWhere(): Database
    {
        try {
            $args = func_get_args();

            if (str_contains($this->sql, "WHERE")) {
                $this->sql .= " OR $args[0] ";
            } else {
                throw new \Exception("Use where() method first");
            }

            if (count($args) === 3) {
                $this->sql .= " $args[1] ";
                $this->sql .= is_integer($args[2]) ? "$args[2]" : "'$args[2]'";

            } elseif (count($args) === 2) {
                $this->sql .= is_integer($args[1]) ? " = $args[1]" : " LIKE '$args[1]'";
            } else {
                throw new \Exception("Invalid arguments");
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    /** and Where method: used to add an AND condition to the WHERE clause
     * @param $data
     * @return bool
     */
    public function andWhere(): Database
    {
        try {
            $args = func_get_args();

            if (str_contains($this->sql, "WHERE")) {
                $this->sql .= " OR $args[0] ";
            } else {
                throw new \Exception("Use where() method first");
            }

            if (count($args) === 3) {
                $this->sql .= " $args[1] ";
                $this->sql .= is_integer($args[2]) ? "$args[2]" : "'$args[2]'";

            } elseif (count($args) === 2) {
                $this->sql .= is_integer($args[1]) ? " = $args[1]" : " LIKE '$args[1]'";
            } else {
                throw new \Exception("Invalid arguments");
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    /**
     * join method: used to join tables
     * @param $column
     * @param string $order
     * @return $this
     */
    public function join($table_secundary, $primary_column, $type_condition, $secundary_column): Database
    {
        try {

            if (preg_match('(SELECT)', $this->sql) == 0) {
                throw new \Exception("You must use the select() method before using the join() method");
            }

            $this->sql .= " JOIN $table_secundary ON $primary_column $type_condition $secundary_column";

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    /**
     * leftJoin method: used to join tables
     */
    public function leftJoin(): Database
    {
        try {
            $args = func_get_args();

            if (preg_match('(SELECT)', $this->sql) == 0) {
                throw new \Exception("You must use the select() method before using the join() method");
            }

            if (count($args) === 4) {
                $this->sql .= " LEFT JOIN $args[0] ON $args[0].$args[1] = $args[2].$args[3]";
            } elseif (count($args) === 5) {
                $this->sql .= " LEFT JOIN $args[0] ON $args[0].$args[1] $args[2] $args[3].$args[4]";;
            } else {
                throw new \Exception("Invalid arguments");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    /**
     * innerJoin method: used to join tables
     */
    public function innerJoin(): Database
    {
        try {
            $args = func_get_args();

            if (preg_match('(SELECT)', $this->sql) == 0) {
                throw new \Exception("You must use the select() method before using the join() method");
            }

            if (count($args) === 4) {
                $this->sql .= " INNER JOIN $args[0] ON $args[0].$args[1] = $args[2].$args[3]";
            } elseif (count($args) === 5) {
                $this->sql .= " INNER JOIN $args[0] ON $args[0].$args[1] $args[2] $args[3].$args[4]";;
            } else {
                throw new \Exception("Invalid arguments");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    /**
     * rightJoin method: used to join tables
     */
    public function rightJoin(): Database
    {
        try {
            $args = func_get_args();

            if (preg_match('(SELECT)', $this->sql) == 0) {
                throw new \Exception("You must use the select() method before using the join() method");
            }

            if (count($args) === 4) {
                $this->sql .= " RIGHT JOIN $args[0] ON $args[0].$args[1] = $args[2].$args[3]";
            } elseif (count($args) === 5) {
                $this->sql .= " RIGHT JOIN $args[0] ON $args[0].$args[1] $args[2] $args[3].$args[4]";;
            } else {
                throw new \Exception("Invalid arguments");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    /**
     * Order the result by the column
     * @return array
     */
    public function orderBy($column, $order = "ASC"): Database
    {
        $this->sql .= " ORDER BY $column $order";
        return $this;
    }

    /**
     * Limit the result
     * @return array
     */
    public function limit($limit): Database
    {
        $this->sql .= " LIMIT $limit";
        return $this;
    }

    public function insert(array $data): void
    {
        try {
            if ($data == null || count($data) == 0) {
                throw new \Exception("You must pass an array to the insert method");
            }

            $this->sql = "INSERT INTO " . $this->table . " (" . implode(', ', array_keys($data)) . ") VALUES (";

            $i = 0;
            foreach ($data as $value) {
                $i++;
                $this->sql .= "?";
                if ($i < count($data)) {
                    $this->sql .= ", ";
                }
            }

            $this->sql .= ");";

            $stmt = $this->connection->prepare($this->sql);

            foreach($data as $value){
                switch(gettype($value))
                {
                    case "integer":
                        $stmt->bindValue("i", $value, \PDO::PARAM_INT);
                        break;
                    case "double":
                        $stmt->bindValue("d", $value, \PDO::PARAM_INT);
                        break;
                    case "string":
                        $stmt->bindValue("s", $value, \PDO::PARAM_STR);
                        break;
                    case "boolean":
                        $stmt->bindValue("b", $value, \PDO::PARAM_BOOL);
                        break;
                    case "NULL":
                        $stmt->bindValue("n", $value, \PDO::PARAM_NULL);
                        break;
                    default:
                        $stmt->bindValue("s", $value, \PDO::PARAM_STR);
                        break;
                }
            }

            echo $this->sql;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function get() : array
    {
        $this->sql .= ";";

        $stmt = $this->connection->prepare($this->sql);

        if(is_array($this->data) && count($this->data) > 0){
            foreach($this->data as $column => $value){
                $stmt->bindValue($column, $value);
            }
        }

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}