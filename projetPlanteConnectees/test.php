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
	
	switch($request_method)
	{
		case 'GET':		
			getAllPlante();
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
?>