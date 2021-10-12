<?php

class Conectar
{
  private $servername, $username, $password, $dbname;

  public function __construct()
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
    } else {
      return $conn;
    }
  }
}
