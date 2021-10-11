<?php

class Conectar
{
    private $servername, $username, $password, $dbname;

    public function _construct()
    {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "root";
        $this->dbname = "cursosapi";
    }

    public function conexion()
    {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            return false;
        }
        else{
            return $conn;
        }


    }
}


/*
$sql = "CREATE DATABASE capaIntermediaMartes";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error al crear BD: " . $conn->error;
}
*/
//////////////////////////////

/*
$sql = "CREATE TABLE tabla1 (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
  echo "Table tabla1 created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}*/


///////////////////////////

/*
$sql = "INSERT INTO tabla1 (firstname, lastname, email)
VALUES ('Juan', 'Perez', 'juanito@perez.com')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
*/


//$conn->close();
