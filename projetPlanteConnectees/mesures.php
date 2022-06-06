<?php
	// Connect to database
	class MyClass {
	}

	class Data {
	}

	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getAllMesures()
	{
		global $conn;
		$query = "SELECT * FROM mesures";
		$mesures = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$mesures[] = $row;
		}

		$data = new Data();
		$data->mesures = $mesures;

		$myClass = new MyClass();
		$myClass -> data=$data;

		header('Content-Type: application/json');
		echo json_encode($myClass, JSON_PRETTY_PRINT);
	}
	
	function getMesuresPlante($id)
	{
		global $conn;
		$query = "SELECT * FROM mesures WHERE Adresse_Mac_Plante= '".$id."' ORDER BY Date_mesure ASC";
		$mesures = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$mesures[] = $row;
		}

		$data = new Data();
		$data->mesures = $mesures;

		$myClass = new MyClass();
		$myClass -> data=$data;

		header('Content-Type: application/json');
		echo json_encode($myClass, JSON_PRETTY_PRINT);
	}
	
	function getLastMesurePlante($id)
	{
		global $conn;
		$query = "SELECT * FROM mesures WHERE Adresse_Mac_Plante= '".$id."' ORDER BY Date_mesure ASC LIMIT 1";
		$mesures = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$mesures[] = $row;
		}
		$data = new Data();
		$data->mesures = $mesures;

		$myClass = new MyClass();
		$myClass -> data=$data;

		header('Content-Type: application/json');
		echo json_encode($myClass, JSON_PRETTY_PRINT);
	}

	switch($request_method)
	{
		case 'GET':
			if(!empty($_GET["id"])&& !isset($_GET["last"]))
			{
				$id=strval($_GET["id"]);
				getMesuresPlante($id);
			}
			elseif(!empty($_GET["id"])&& isset($_GET["last"])){
				$id=strval($_GET["id"]);
				getLastMesurePlante($id);
			}
			else
			{
				getAllMesures();
			}
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
?>