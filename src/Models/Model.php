<?php
namespace App\Models;

use Medoo\Medoo as MedooDB;
use \PDO; // for columns to work

class Model
{

    public $db;

    public function __construct()
    {

        $this->db = new MedooDB([
            // [required]
            'type'     => 'mysql',
            'host'     => 'localhost',
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],

            // [optional]
            // 'charset' => 'utf8mb4',
            // 'collation' => 'utf8mb4_general_ci',
            'port'     => $_ENV['DB_PORT'],

            // [optional] The table prefix. All table names will be prefixed as PREFIX_table.
            // 'prefix' => 'PREFIX_',

            // [optional] To enable logging. It is disabled by default for better performance.
            'logging'  => $_ENV['DB_LOGGING'],

            // [optional]
            // Error mode
            // Error handling strategies when the error has occurred.
            // PDO::ERRMODE_SILENT (default) | PDO::ERRMODE_WARNING | PDO::ERRMODE_EXCEPTION
            // Read more from https://www.php.net/manual/en/pdo.error-handling.php.
            // 'error' => PDO::ERRMODE_SILENT,

            // [optional]
            // The driver_option for connection.
            // Read more from http://www.php.net/manual/en/pdo.setattribute.php.
            // 'option' => [
            //     PDO::ATTR_CASE => PDO::CASE_NATURAL
            // ],

            // [optional] Medoo will execute those commands after the database is connected.
            // 'command' => [
            //     'SET SQL_MODE=ANSI_QUOTES'
            // ]
        ]);
    }

    public function count($where = NULL)
    {

        return $this->db->count($this->table, $where);
    }

    public function delete($where)
    {

        return $this->db->delete($this->table, $where);
    }

    public function columns()
    {

        return $this->db->query("DESCRIBE " . $this->table)->fetchAll(PDO::FETCH_COLUMN);
    }

    public function select($columns = '*', $where = [], $join = [])
    {

        if (empty($join)) {

            $rows = $this->db->select($this->table, $columns, $where);

        } else {
            $rows = $this->db->select($this->table, $join, $columns, $where);

        }

        return $rows;
    }

    public function get($columns, $where = [], $join = [])
    {

        if (empty($join)) {

            $row = $this->db->get($this->table, $columns, $where);
        } else {

            $row = $this->db->get($this->table, $join, $columns, $where);

        }

        return $row;
    }

    public function insert($rows)
    {

        $this->db->insert($this->table, $rows);

        return $this->db->id();
    }

    public function update($data, $where)
    {

        $this->db->update($this->table, $data, $where);

        return true;
    }

    public function migrate()
    {

        $this->db->drop($this->table);

        $this->db->create($this->table, $this->columns);

        return true;
    }

    public function seed()
    {

        $this->db->insert($this->table, $this->rows);

        return true;
    }
}
