<?php
	session_start();
	
	if(isset($_SESSION['online']))
	{
		require_once "connect.php";
			
		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			$connection = new mysqli($host, $db_user, $db_pass, $db_name);
			if($connection->connect-errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				
				$id = $_SESSION['id'];
				$result = $connection->query("UPDATE users  SET online=0 WHERE id='$id'");
			
			}
		}
		catch(Exception $e)
		{
			echo "<div style='color:red;font-size:50px;'>Błąd serwara</div>";
		}
		session_unset();
		header('Location:home');
	}
	else
	{
		header('Loacation:index.php');
	}
?>