<!--
Name: Liping Wang
Date: Nov. 18 , 2023
Section: CST 8285 section 303
Description: database helper
-->
<?php

function db_connect()
{
    require_once('config.php');
    $connection = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);
    confirm_db_connect();
    return $connection;
}

function db_disconnect($connection)
{
    if (isset($connection)) {
        mysqli_close($connection);
    }
}

function confirm_db_connect()
{
    if (mysqli_connect_errno()) {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " (" . mysqli_connect_errno() . ")";
        exit($msg);
    }
}

function confirm_result_set($result_set)
{
    if (!$result_set) {
        exit("Database query failed.");
    }
}
