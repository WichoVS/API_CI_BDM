<?php

class Conectar
{
  private $servername, $username, $password, $dbname;

  public function __construct()
  {
    $this->servername = "156.67.74.151";
    $this->username = "u176038041_admin";
    $this->password = "Proyectos2021!";
    $this->dbname = "u176038041_cursosapi";
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
