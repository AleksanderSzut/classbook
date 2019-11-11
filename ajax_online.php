<?php

	session_start();

	if((!isset($_SESSION['online'])) && ($_SESSION['online'] == false))
	{
		header('Location:home');session_unset();exit();
	}
	else
	{
		$id_user = $_SESSION['id'];
		require_once "connect.php";
			
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
        	$unix_serwer = Date("U");
			$connection= new mysqli($host, $db_user, $db_pass, $db_name);
			if($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				if($connection->query("UPDATE users SET online_time = '$unix_serwer' WHERE id='$id_user'"))
				{
					echo $unix_serwer."id".$id_user;
				}
				$connection->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera!</span></br>'.$e;
			echo'Informacja Developerska: '.$e;
		}
	}
?>