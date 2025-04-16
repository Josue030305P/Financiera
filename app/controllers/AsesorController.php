<?php

require_once '../models/Asesor.php';

$asesor = new Asesor();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        if (isset($_GET['id'])) {
            
            $id = $_GET['id'];
            $result = $asesor->getAsesorByLead($id);
        } else {
            
            $result = $asesor->getAll();
        }

        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
    }
}
