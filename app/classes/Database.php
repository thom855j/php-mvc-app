<?php

class Database
{
    protected $connection = [
        'host' => '127.0.0.1',
        'driver' => 'mysql',
        'dbname' => 'validation',
        'username' => 'root',
        'password' => 'mysql',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ];

    protected $driver;
    protected $host;
    protected $dbname;
    protected $username;
    protected $password;
    protected $charset;
    protected $collation;
    protected $prefix;

    protected $stmt;
    protected $table;

    public $pdo;
    public $query;
    public $error = false;
    public $results;
    public $first;
    public $count = 0;

    public function __construct($connection = array())
    {
        if(!empty($connection)) {
            $this->connection = $connection;
        }

        $this->driver = $this->connection['driver'];
        $this->host = $this->connection['host'];
        $this->dbname = $this->connection['dbname'];
        $this->username = $this->connection['username'];
        $this->password = $this->connection['password'];
        $this->charset = $this->connection['charset'];

        try {
            $this->pdo = new PDO(
                $this->driver . ':host=' . 
                $this->host . ';dbname=' . 
                $this->dbname . ';charset=' .
                $this->charset, 
                $this->username, 
                $this->password
            );

        } catch (PDOException $error) {
            die($error->getMessage());
        }
    }

    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    public function query($sql, $params = array())
    {

        $this->error = false;

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $prepare = $this->query = $this->pdo->prepare($sql);

        if (isset($prepare)) {

            $datatype = 2;
            $x         = 1;

            if (count($params)) {
                foreach ($params as $param) {

                    if (is_numeric($param)) {
                        $datatype = 1;
                    }

                    $this->query->bindValue($x, $param, $datatype);
                    $x++;
                }
            }

            if ($this->query->execute()) {
                    $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
                    $this->count   = $this->query->rowCount();
            } else {
                $this->error = true;
            }
        }
        return $this;
    }

    /**
     * Method for dynamically generating SQL queries
     * 
     * @param string $action SQL statement
     * @param string $table Database table
     * @param array $where Multi-dimensional array for multiple WHERE statements
     * @param array $options Array with miscellaneous satements like ORDER BY
     * @return boolean|object
     */
    public function action($action, $where = array(), $options = array())
    {
        $sql   = "{$action} FROM {$this->table}";
        $value = array();

        if (!empty($where)) {

            $sql .= " WHERE ";

            $where = [$where];

            foreach ($where as $clause) {

                if (count($clause) === 3) {

                    $operators = array('=', '>', '<', ' >=', '<=', '<>');

                    if (isset($clause)) {
                        $field     = $clause[0];
                        $operator  = $clause[1];
                        $value[]   = $clause[2];
                        $bindValue = '?';
                    }

                    if (in_array($operator, $operators)) {
                        $sql .= "{$field} {$operator} {$bindValue}";
                        $sql .= " AND ";
                    }
                }
            }
            $sql = rtrim($sql, " AND ");
        }

        if (!empty($options)) {
            foreach ($options as $optionKey => $optionValue) {
                $sql .= " {$optionKey} {$optionValue}";
            }
        }

        if (!$this->query($sql, $value)->error()) {
            return $this;
        }

        return false;
    }


    public function where($field, $operator, $value)
    {
        $where = [$field, $operator, $value];
        $this->get(['*'], $where);
        return $this;
    }

    public function insert($fields = array())
    {
        $keys   = array_keys($fields);
        $values = '';
        $x      = 1;

        foreach ($fields as $field)
        {
            $values .= '?';
            if ($x < count($fields))
            {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$this->table} (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

        if (!$this->query($sql, $fields)->error())
        {
            return $this->lastId();
        }
        return false;
    }

    public function update($fields = array(), $where = array())
    {
        $set = '';
        $x   = 1;

        foreach ($fields as $name => $value)
        {
            $set .= "{$name} = ?";
            if ($x < count($fields))
            {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$this->table} SET {$set} WHERE {$where[0]} {$where[1]} {$where[2]}";

        if (!$this->query($sql, $fields)->error())
        {
            return true;
        }
        return false;
    }

    public function get($select = array(), $where = array(), $options = null)
    {
        return $this->action('SELECT ' . implode($select, ', '), $where, $options);
    }

    public function search($attributes = array(), $searchQuery)
    {

        if (!empty($searchQuery) && !empty($attributes)) {

            $query = "";

            foreach ($attributes as $term) {
                foreach ($searchQuery as $search) {
                    $query .= "{$term} LIKE ? OR ";
                }
            }

            $search = trim($query, "OR ");
            $sql = "SELECT " . implode($attributes, ', ') . " FROM {$this->table} WHERE {$search}";
            $z = 1;

            for ($x = 0; $x < count($attributes); $x++)
            {
                for ($y = 0; $y < count($searchQuery); $y++)
                {
                    $params[$z++] = $searchQuery[$y];
                }
            }

            if (!$this->query($sql, $params)->error())
            {
                return (object) $this;
            }
        }
    }

    public function delete($where = array())
    {
        return $this->action('DELETE', $where);
    }

    public function exists($field, $operator, $value)
    {
        return $this->where($field, $operator, $value)->count() ? true : false;
    }

    public function results()
    {
        return $this->results;
    }

    public function first()
    {
        $this->first = $this->results();
        return $this->first[0];
    }

    public function error()
    {
        return $this->error;
    }

    public function count()
    {
        return $this->count;
    }

    public function lastId()
    {
        return $this->pdo->lastInsertId();
    }
}