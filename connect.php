<?php

	$host = "localhost";
	$db_user = "root";
	$db_pass = "";
	$db_name = "classbook"; 
	$connected = false;
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		$connection = new mysqli($host, $db_user, $db_pass, $db_name);
		if($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			$connected = true;
		}
	}
	catch(Exception $e)
	{
	   $connected = false;
    }

?>