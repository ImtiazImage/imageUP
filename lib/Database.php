<?php

class Database{

	public $host   = DB_HOST;
	public $user   = DB_USER;
	public $pass   = DB_PASS;
	public $dbname = DB_NAME;


	public $link;
	public $error;




//Connection to the Database
	public function __construct(){
		$this->connectDB();
	}
//Creating Database connection Function
	private function connectDB(){
		$this->link = new mysqli($this->host,$this->user,$this->pass,$this->dbname);
		if (!$this->link) {
			$this->error = "Connection Failed!!".$this->link->connect_error;
		}
	}

//Insert Image/Data Function
	public function insert($query){
		$insert_row = $this->link->query($query) or die ($this->link->erro.__LINE__);
		if($insert_row){
			return $insert_row;
		}else{
			return false;
		}
	}

//Select/Show Image/Data function
	public function read($query){
		$read_row = $this->link->query($query) or die ($this->link->error.__LINE__);
		if($read_row->num_rows > 0){
			return $read_row;
		}else{
			return false;
		}
	}
//Delete Image/Data function
	public function delete($query){
		$delete = $this->link->query($query) or die ($this->link->error.__LINE__);
		if($delete){
			return $delete;
		}else{
			return false;
		}
	}



}



?>