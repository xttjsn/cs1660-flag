<?php

$mydb = new PDO('sqlite:../db/flag.sqlite');

$result = $mydb->query("SELECT * FROM users");

echo "<table id='display'>";
while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>";
    echo $row['id'];
    echo "</td>";
    echo "<td>";
    echo $row['username'];
    echo "</td>";
    echo "<td>";
    echo $row['password'];
    echo "</td>";
    echo "<td>";
    echo $row['avatar'];
    echo "</td>";
    echo "<td>";
    echo $row['about_me'];
    echo "</td>";
    echo "<td>";
    echo $row['is_staff'];
    echo "</td>";
    echo "</tr>";
}
echo "</table>";

// $result = $mydb->query('select * from users limit 1');
// $fields = array_keys($result->fetch(\PDO::FETCH_ASSOC));
// print_r($fields);

