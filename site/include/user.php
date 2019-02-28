<?php
if (!defined('BASE_DIR'))
    exit;

class User
{
    private $data;

    public function __construct()
    {
        $this->data = array();
    }

    // Attempt to authenticate the current user
    public static function loadFromSession()
    {
        if (!isset($_SESSION['username']))
            return new User();
        else
            return User::loadByUsername($_SESSION['username']);
    }

    public static function loadByUsername($username)
    {
        global $db;

        $user = new User();

        $args = array(
            ':username' => $username,
        );

        $result = $db->query('SELECT * FROM users WHERE username = :username', $args);
        if (count($result) == 0)
            return $user;

        foreach ($result[0] as $key => $val)
        {
            $user->{$key} = $val;
        }

        return $user;
    }

    public static function loadById($id)
    {
        global $db;

        $user = new User();

        $args = array(
            ':id' => $id,
        );

        $result = $db->query('SELECT * FROM users WHERE id = :id', $args);
        if (count($result) == 0)
            return $user;

        foreach ($result[0] as $key => $val)
        {
            $user->{$key} = $val;
        }

        return $user;
    }

    public function isLoggedIn()
    {
        return !empty($this->data);
    }

    public function isStaff()
    {
        return $this-> isLoggedIn() && $this->is_staff === '1';
    }

    public function enforceLogin()
    {
        if (!$this->isLoggedIn())
        {
            header('Location: index.php');
        }
    }

    public function __get($name)
    {
        return (array_key_exists($name, $this->data) ? $this->data[$name] : null);
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function save()
    {
        global $db;

        if (!empty($this->data))
        {
            $clauses = array();
            $args = array();
            foreach ($this->data as $key => $val)
            {
                $clauses[] = sprintf('%s = :%s', $key, $key);
                $args[':' . $key] = $val;
            }

            $query = 'UPDATE users SET ' . implode($clauses, ',') . ' WHERE id = :id';
            $db->query($query, $args);
        }
    }

    public static function isValidLoginAttempt($username, $password)
    {
        global $db;

        $args = array(
            ':username' => $username,
            ':password' => User::hash_password($password),
        );
        $result = $db->query('SELECT * FROM users WHERE username = :username AND password = :password', $args);
        return count($result) != 0;
    }

    /* This algorithm uses salting and stretching! It is super secure. -- Bob, Nov 15th 2012 */
    public static function hash_password($pwd)
    {
        $salt = 'supersecretsalt';
        for ($i = 0; $i < 30; ++$i)
        {
            $pwd = sha1($salt . $pwd);
        }
        return $pwd;
    }

    public function getMyHandinUrl($assignment, $ext)
    {
        return self::getHandinUrl($this->data['username'], $assignment, $ext);
    }

    public static function getHandinUrl($username, $assignment, $ext)
    {
        return BASE_DIR . sprintf('handins/%s.%s', sha1(sprintf('%s_%s', $username, $assignment)), $ext);
    }
}
