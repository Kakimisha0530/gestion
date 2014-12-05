<?php
function openSession(){
	$session = mysqli_connect("localhost", "root", "mysql", "petitverdot");
	if($session)
		return $session;
	else 
		return null;
}

function closeSession($session){
	mysqli_close($session);
}

function createQueryString($name,$value){
	return " ($name=\"$value\"), ";
}

function createQueryInt($name,$value){
	return " ($name=$value)";
}

class SQLObject{
	var $table;
	var $id;
	
	function __construct($tab){
		$this->table = $tab;
	}
	
	function reset(){
	
	}
	
	function set(){
	
	}
	
	function size(){
		return 1;
	}
	
	function setFromDB($row){
		
	}
	
	function save($session){
		
	}
	
	function delete($session){
		$query = "DELETE FROM " . $this->table . " WHERE ";
		$query .= createQueryInt("id", $this->id);
		mysqli_query($session, $query);
	}
	
	function getById($session,$id){
		$query = "SELECT * FROM " . $this->table . " WHERE ";
		$query .= createQueryInt("id", $this->id);
		$result = mysqli_query($session, $query);
		
		if($result && $row = mysqli_fetch_array($result)){
			$this->setFromDB($session,$row);
		}
	}
	
	function getAll($session,$limit = 0){
		$query = "SELECT * FROM " . $this->table;
		return mysqli_query($session, $query);
		
	}
}