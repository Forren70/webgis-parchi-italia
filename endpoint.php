<?php
header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'webgis_parchi';

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    echo json_encode(["error" => "Connessione fallita"]);
    exit();
}

$sql = "SELECT * FROM parchi_e_giardini_aggiornato";
$result = $conn->query($sql);

$parchi = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $parchi[] = $row;
    }
}

$conn->close();

echo json_encode($parchi);
?>