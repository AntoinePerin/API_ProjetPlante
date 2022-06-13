<?php
	// Connect to database
	class MyClass {
	}

	class Data {
	}

	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getAllIrrigations()
	{
		global $conn;
		$query = "SELECT * FROM irrigation";
		$mesures = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$irrigations[] = $row;
		}

		$data = new Data();
		$data->irrigations = $irrigations;

		$myClass = new MyClass();
		$myClass -> data=$data;

		header('Content-Type: application/json');
		echo json_encode($myClass, JSON_PRETTY_PRINT);
	}
	
	function getIrrigationsPlante($id)
	{
		global $conn;
		$query = "SELECT * FROM irrigation WHERE Adresse_Mac_Plante= '".$id."' ORDER BY Date_irrigation ASC";
		$mesures = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$irrigations[] = $row;
		}

		$data = new Data();
		$data->irrigations = $irrigations;

		$myClass = new MyClass();
		$myClass -> data=$data;

		header('Content-Type: application/json');
		echo json_encode($myClass, JSON_PRETTY_PRINT);
	}
	
	function getLastIrrigationPlante($id)
	{
		global $conn;
		$query = "SELECT * FROM irrigation WHERE Adresse_Mac_Plante= '".$id."' ORDER BY Date_irrigation DESC LIMIT 1";
		$mesures = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$irrigations[] = $row;
		}
		$data = new Data();
		$data->irrigations = $irrigations;

		$myClass = new MyClass();
		$myClass -> data=$data;

		header('Content-Type: application/json');
		echo json_encode($myClass, JSON_PRETTY_PRINT);
	}

	function getNLastIrrigationPlante($id,$nbrMesure)
	{
		global $conn;
		$query = "SELECT * FROM irrigation WHERE Adresse_Mac_Plante= '".$id."' ORDER BY Date_irrigation DESC LIMIT ".$nbrMesure;
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
			if(!empty($_GET["id"])&& !isset($_GET["last"])&& !isset($_GET["nbrMesure"]))
			{
				$id=strval($_GET["id"]);
				getIrrigationsPlante($id);
			}
			elseif(!empty($_GET["id"])&& isset($_GET["last"])){
				$id=strval($_GET["id"]);
				getLastIrrigationPlante($id);
			}
			elseif(isset($_GET["id"])&& isset($_GET["nbrMesure"])){
				$id=strval($_GET["id"]);
				$nbrMesure=intval($_GET["nbrMesure"]);
				getNLastIrrigationPlante($id,$nbrMesure);
			}
			else
			{
				getAllIrrigations();
			}
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
?>