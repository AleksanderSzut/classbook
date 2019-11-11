<?php 

	session_start();

	if((!isset($_SESSION['online'])) || ($_SESSION['online'] == false))
	{
		echo "0";	
	}
	else
	{
		$id = $_SESSION['id'];
		
		require "connect.php";
		require "function.php";

		if(!$connected)
			exit("0");

		$resultQuery = $connection->query("SELECT * FROM news WHERE id_user='$id' AND view=0");
		if (!$resultQuery) throw new Exception($connection->error);
		$resultAjax= $resultQuery->num_rows;

		echo $resultAjax;

		$connection->close();
	}

?>