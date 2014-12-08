<?php

class Pays extends SQLObject
{

    var $nom;

    function __construct ()
    {
        parent::__construct("pays");
    }

    function size ()
    {
        return parent::size() + 1;
    }

    function reset ()
    {
        $this->set(0, "");
    }

    function set ($fid, $fnom)
    {
        $this->id = intval($fid);
        $this->nom = $fnom;
    }

    function setFromDB ($session,$row)
    {
        $this->id = intval($row[0]);
        $this->nom = $row[1];
    }

    function save ($session)
    {
        $query = "";
        if ($this->id > 0)
            $query .= "UPDATE FROM " . $this->table . "SET ";
        else
            $query .= "INSERT INTO " . $this->table . "SET ";
        
        $query .= createQueryString("nom_pays", $this->nom);
        
        $query = trim($query, ", ");
        
        if ($this->id > 0)
            $query .= "WHERE " . createQueryInt("id", $this->id);
        
        $query = trim($query, ", ");
        
        echo $query;
        
        return mysqli_query($session, $query);
    }
}