<?php
$url = "http://127.0.0.1/projetPlanteConnectees/plante.php?id=test3"; // modifier la plante
$data = array('Libelle_plante' => 'MAC', 'Date_plantation_plante' => '2022-06-11', 'Description_plante' => '9658', 'Niveau_irrigation_plante' => '2', 'Seuil_humidite_plante' => '56');

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

$response = curl_exec($ch);

var_dump($response);

if (!$response) 
{
    return false;
}
?>