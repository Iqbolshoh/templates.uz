<?php

class Database
{
    private $conn;

    public function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "templates";

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    function validate($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = str_replace(
            [
                '‘',
                '’',
                '“',
                '”',
                '"',
                '„',
                '‟',
                '‹',
                '›',
                '«',
                '»',
                '`',
                '´',
                '❛',
                '❜',
                '❝',
                '❞',
                '〝',
                '〞'
            ],
            "'",
            $value
        );
        return $value;
    }
    function eQuery($sql, $params = [])
    {
        if ($stmt = $this->conn->prepare($sql)) {
            if (!empty($params)) {
                $types = str_repeat('s', count($params));
                $stmt->bind_param($types, ...$params);
            }

            if ($stmt->execute()) {
                if (strpos($sql, 'SELECT') === 0) {
                    $result = $stmt->get_result();
                    return $result->fetch_all(MYSQLI_ASSOC);
                }
                return true;
            } else {
                error_log("ERROR: " . $stmt->error);
                return false;
            }
        } else {
            error_log("ERROR: " . $this->conn->error);
            return false;
        }
    }


    public function executeQuery($sql)
    {
        $result = $this->conn->query($sql);
        if ($result === false) {
            die("ERROR: " . $this->conn->error);
        }
        return $result;
    }

    public function select($table, $columns = "*", $condition = "")
    {
        $sql = "SELECT $columns FROM $table $condition";
        return $this->executeQuery($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($table, $id)
    {
        $id = intval($id);
        $condition = "WHERE id = $id";
        $result = $this->select($table, "*", $condition);
        return $result ? $result[0] : null;
    }

    function insert($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_map(function ($item) {
            return "'" . addslashes($item) . "'";
        }, array_values($data)));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        return $this->executeQuery($sql);
    }

    public function update($table, $data, $condition = "")
    {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key = '$value', ";
        }
        $set = rtrim($set, ', ');
        $sql = "UPDATE $table SET $set $condition";
        return $this->executeQuery($sql);
    }

    public function delete($table, $condition = "")
    {
        $sql = "DELETE FROM $table $condition";
        return $this->executeQuery($sql);
    }

    function hashPassword($password)
    {
        return hash_hmac('sha256', $password, "AccountPassword");
    }

    public function login($username, $password, $table)
    {
        $username = $this->validate($username);
        $condition = "WHERE username = '" . $username . "' AND password = '" . $this->hashPassword($password) . "'";
        return $this->select($table, "*", $condition);
    }

    public function count($table)
    {
        $userId = $_SESSION['id'];
        $result = $this->executeQuery("SELECT COUNT(*) AS total_elements FROM $table WHERE user_id = $userId");
        $row = $result->fetch_assoc();
        return $row['total_elements'];
    }

    function lastInsertId()
    {
        return $this->conn->insert_id;
    }
}
