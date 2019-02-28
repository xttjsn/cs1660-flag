<?php
if (!defined('BASE_DIR'))
    exit;

class DB
{
    public function __construct()
    {
        $this->db = new PDO('sqlite:' . BASE_DIR . 'db/flag.sqlite');
    }

    public function query($query, $args = array())
    {
        $args = array_map(array($this, 'quote'), $args);
        $query = str_replace(array_keys($args), array_values($args), $query);

        $result = $this->db->query($query);
        if ($result === false)
        {
            if ($this->db->errorCode() === null)
            {
                return array();
            }
            else
            {
                echo 'An error was encountered!';
                var_dump($query);
                var_dump($this->db->errorCode());
                var_dump($this->db->errorInfo());
                exit;
            }
        }
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function quote($str)
    {
        return '"' . $str . '"';
    }
}
