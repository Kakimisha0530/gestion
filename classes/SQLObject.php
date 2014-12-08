<?php

function getFormVariable ($name)
{
    if (isset($_POST[$name]))
        return $_POST[$name];
    else
        return $_GET[$name];
}

function openSession ()
{
    $session = mysqli_connect("localhost", "root", "shasha", "petitverdot");
    if ($session)
        return $session;
    else
        return null;
}

function closeSession ($session)
{
    mysqli_close($session);
}

function createQueryString ($name, $value)
{
    return " $name='" . addslashes($value) . "', ";
}

function createQueryInt ($name, $value)
{
    return " $name=$value, ";
}


class SQLObject
{

    var $table;

    var $id;

    function __construct ($tab)
    {
        $this->table = $tab;
    }

    function reset ()
    {}

    function set ()
    {}

    function size ()
    {
        return 1;
    }
    
    function exist(){
    	return $this->id > 0;
    }

    function setFromDB ($row)
    {}

    function save ($session)
    {}

    function delete ($session)
    {
        $query = "DELETE FROM " . $this->table . " WHERE ";
        $query .= createQueryInt("id", $this->id);
        $query = trim($query, ", ");
        mysqli_query($session, $query);
    }

    function getById ($session, $id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE ";
        $query .= createQueryInt("id", $id);
        $query = trim($query, ", ");
        $result = mysqli_query($session, $query);
        
        if ($result && $row = mysqli_fetch_array($result)) {
            $this->setFromDB($session, $row);
        }
    }

    function getAll ($session, $limit = 0)
    {
        $query = "SELECT * FROM " . $this->table;
        $result = mysqli_query($session, $query);
        return $result;
    }
}