<?php
	class Connection{

		private $servername = "";
		private $database = "";
		private $username = "";
		private $password = "";
		public $conn = "";

		public function __construct(){
			// Create connection
			/* LOCAL:*/
			$this->servername = "localhost";
			$this->database = "db_agenda";
			$this->username = "root";
			$this->password = "";

			$this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
			// Check connection
			if (!$this->conn) {
				die("<br/>Conexão falhou: " . mysqli_connect_error());
			} else{
				return $this->conn;
			}
		}

		public function closeConn($c){
			if($c->conn){
				mysqli_close($c->conn);
			}
		}
	}
?>
