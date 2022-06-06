<?php
	class MyClass {
	}

	class Data {
	}
	
	// Connect to database
	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getAllPlante()
	{
		global $conn;
		$query = "SELECT * FROM plante";
		$plantes = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$plantes[] = $row;
		}

		$data = new Data();
		$data->plantes = $plantes;

		$myClass = new MyClass();
		$myClass -> data=$data;

		header('Content-Type: application/json');
		echo json_encode($myClass, JSON_PRETTY_PRINT);
	}

	function AddPlante()
	{
		global $conn;
		$adresseMac = $_POST["Adresse_Mac_plante"];
		$libelle = $_POST["Libelle_plante"];
		$datePlantation = $_POST["Date_plantation_plante"];
		$description = $_POST["Description_plante"];
		//$created = date('Y-m-d H:i:s');
		echo $query="INSERT INTO plante(Adresse_Mac_plante, Libelle_plante, Date_plantation_plante, Description_plante) VALUES('".$adresseMac."', '".$libelle."', '".$datePlantation."', '".$description."')";
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Plante ajoutee avec succes.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'ERREUR!.'. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	switch($request_method)
	{
		case 'GET':		
			getAllPlante();
			break;
		case 'POST':
				// Ajouter un produit
			AddPlante();
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
?>