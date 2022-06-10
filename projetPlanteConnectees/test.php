<?php
	$url = 'http://127.0.0.1/API_ProjetPlante/projetPlanteConnectees/plante.php';
	$data = array('Adresse_Mac_plante' => 'test569', 'Libelle_plante' => 'JPP', 'Date_plantation_plante' => '2022-06-10', 'Description_plante' => 'TEST AJOUT REQUETE POST', 'Niveau_irrigation_plante' => '3', 'Seuil_humidite_plante' => '55');

	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result === FALSE) { /* Handle error */ }

	var_dump($result);
?>