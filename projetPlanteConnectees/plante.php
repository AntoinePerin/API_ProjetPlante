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

	/*function AddPlante()
	{
		global $conn;
		$adresseMac = $_POST["Adresse_Mac_plante"];
		$libelle = $_POST["Libelle_plante"];
		$datePlantation = $_POST["Date_plantation_plante"];
		$description = $_POST["Description_plante"];
		$niveauIrrigation = $_POST["Niveau_irrigation_plante"];
		$seuilHumidite = $_POST["Seuil_humidite_plante"];
		//$created = date('Y-m-d H:i:s');
		echo $query="INSERT INTO plante(Adresse_Mac_plante, Libelle_plante, Date_plantation_plante, Description_plante,Niveau_irrigation_plante,Seuil_humidite_plante) VALUES('".$adresseMac."', '".$libelle."', '".$datePlantation."', '".$description."', '".$niveauIrrigation."', '".$seuilHumidite."')";
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
		echo json_encode($response, JSON_PRETTY_PRINT);
	}*/

	function updatePlante($id)
	{
		global $conn;
		$_PUT = array();
		parse_str(file_get_contents('php://input'), $_PUT);
		$libelle = $_PUT["Libelle_plante"];
		$datePlantation = $_PUT["Date_plantation_plante"];
		$description = $_PUT["Description_plante"];
		$niveauIrrigation = $_PUT["Niveau_irrigation_plante"];
		$seuilHumidite = $_PUT["Seuil_humidite_plante"];
		$query="UPDATE plante SET Libelle_plante='".$libelle."', Date_plantation_plante='".$datePlantation."', Description_plante='".$description."', Niveau_irrigation_plante='".$niveauIrrigation."',Seuil_humidite_plante='".$seuilHumidite."' WHERE Adresse_Mac_plante='".$id."'";
		
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Plante mis a jour avec succes.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Echec de la mise a jour de plante. '. mysqli_error($conn)
			);
			
		}
		
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function deletePlante($id)
	{
		global $conn;
		$query = "DELETE FROM plante WHERE Adresse_Mac_plante='".$id."'";
		echo($query);
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Plante supprime avec succes.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'La suppression de la plante a echoue. '. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	switch($request_method)
	{
		case 'GET':		
			getAllPlante();
			break;

		case 'POST':
			// Ajouter une plante
			AddPlante();	
			break;

		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;

		case 'PUT':
			// Modifier une plante
			$id = strval($_GET["id"]);
			updatePlante($id);
			break;
				
		case 'DELETE':
			// Supprimer une plante
			$id = strval($_GET["id"]);
			deletePlante($id);
			break;
	}
?>