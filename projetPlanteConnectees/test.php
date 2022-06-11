<?php
	$url = 'http://azammouri.com/pc/uploads/plante.php';
	$data = array('Adresse_Mac_plante' => 'test777', 'Libelle_plante' => 'JPP2', 'Date_plantation_plante' => '2022-06-11', 'Description_plante' => 'TEST AJOUT REQUETE POST 2', 'Niveau_irrigation_plante' => '3', 'Seuil_humidite_plante' => '55');

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