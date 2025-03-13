<?php
require_once "../models/Leads.php";

header('Content-Type: application/json; charset=utf-8');

$leads = new Leads();

$metodo = $_SERVER["REQUEST_METHOD"];

if ($metodo == "GET") {
  $registros = $leads->getAll();
  header('HTTP/1.1 200 OK');
  echo json_encode($registros);

}






