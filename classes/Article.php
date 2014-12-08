<?php

class Article extends SQLObject
{

    var $nom;

    var $prix;

    var $qte;

    var $tva;

    var $date;

    var $type;

    var $id_pays;

    var $pays;

    public static $TYPES = array(
            "vin",
            "vin frais",
            "spiritueux",
            "&eacute;pices"
    );

    public static $TVA = array(
            2.3,
            5.5,
            12.6
    );

    function __construct ()
    {
        parent::__construct("article");
        $this->pays = null;
    }

    function size ()
    {
        return parent::size() + 6;
    }

    function reset ()
    {
        $this->set(null, 0, "", 0, 0, "", "", 0);
        $this->pays = null;
    }

    function set ($session, $fid, $fnom, $fprix, $fqte, $ftva, $ftype, $fpays)
    {
        $this->id = intval($fid);
        $this->nom = $fnom;
        $this->prix = floatval($fprix);
        $this->qte = intval($fqte);
        $this->tva = floatval($ftva);
        $this->date = $this->getDate();
        $this->type = $ftype;
        $this->id_pays = intval($fpays);
        if ($this->id_pays > 0 && $session != null) {
            $this->pays = new Pays();
            $this->pays->getById($session, $this->id_pays);
        }
    }

    function setFromDB ($session, $row)
    {
        $this->id = intval($row[0]);
        $this->nom = $row[1];
        $this->prix = floatval($row[2]);
        $this->qte = intval($row[3]);
        $this->tva = floatval($row[4]);
        $this->date = $row[5];
        $this->type = $row[6];
        $this->id_pays = intval($row[7]);
        
        if ($this->id_pays > 0 && $session != null) {
            $this->pays = new Pays();
            $this->pays->getById($session, $this->id_pays);
        }
    }

    function getDate ()
    {
        return date("Y-m-d");
    }

    function getPays ()
    {
        return $this->pays->nom;
    }

    function save ($session)
    {
        $query = "";
        if ($this->id > 0)
            $query .= "UPDATE " . $this->table . " SET ";
        else
            $query .= "INSERT INTO " . $this->table . " SET ";
        
        $query .= createQueryString("nom_article", $this->nom);
        $query .= createQueryString("type", $this->type);
        $query .= createQueryString("date_article", $this->date);
        $query .= createQueryInt("prix_article", $this->prix);
        $query .= createQueryInt("qte_article", $this->qte);
        $query .= createQueryInt("tva_article", $this->tva);
        $query .= createQueryInt("id_pays", $this->id_pays);
        
        $query = trim($query, ", ");
        
        if ($this->id > 0)
            $query .= " WHERE " . createQueryInt("id", $this->id);
        
        $query = trim($query, ", ");
        
        //echo "<br>" . $query;
        
        return mysqli_query($session, $query);
    }
}
