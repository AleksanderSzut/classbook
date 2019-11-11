<?php

	session_start();

	if((!isset($_SESSION['online'])) && ($_SESSION['online'] == false))
	{
		echo "Jesteś nie zalogowany";
	}
	if((isset($_GET['id_post'])) && (isset($_GET['type'])) && ($_GET['type'] == 1 || $_GET['type'] == 2))
	{
		$id_post = $_GET['id_post'];
		$type = $_GET['type'];

		$id = $_SESSION['id'];
		$date = date("U");
		
		require_once "connect.php";
		require_once "function.php";

		$result2 = $connection->query("SELECT * FROM post WHERE id_post='$id_post'");
		if (!$result2) throw new Exception($connection->error);
		if(1 != ($result2->num_rows))
			exit("błąd");
		$row = $result2->fetch_assoc();
		$id_user_2 = $row['id_user'];


		$result = $connection->query("SELECT * FROM like_post WHERE id_user='$id' AND id_post='$id_post'");

		if (!$result) throw new Exception($connection->error);

		$ile_like = $result->num_rows;

		
		
		if($ile_like == 1)
		{
			$row = $result->fetch_assoc();
			$id_like = $row['id_like'];
			if($result = $connection->query("UPDATE like_post SET type_like = '$type', date='$date' WHERE id_user='$id' AND id_post='$id_post'"))
			{

				$result = $connection->query("SELECT * FROM like_post WHERE id_post = '$id_post' AND type_like = '$type'");
				if (!$result) throw new Exception($connection->error);

				$ile_like_2 = $result->num_rows;
				echo $ile_like_2;
			}
			else
			{
				echo "szut_mamy_problem".$type;
			}

		}
		else
		{
			if($result =  $connection->query("INSERT INTO like_post (id_like, id_user, id_post, type_like, date) VALUES (NULL, '$id', '$id_post', '$type', '$date')"))
			{
				
				$result = $connection->query("SELECT * FROM like_post WHERE id_post = '$id_post' AND type_like = '$type'");
				if (!$result) throw new Exception($connection->error);
				$ile_like_2 = $result->num_rows;

				$result = $connection->query("SELECT * FROM like_post WHERE id_user='$id' ORDER BY id_like DESC");
				$row = $result->fetch_assoc();
				$id_like = $row['id_like'];
				if($id != $id_user_2)
				{
					$connection->query("INSERT INTO news (id_user, id_item, type_news, view, date) VALUES ('$id_user_2', '$id_like', 1, 0 , '$date')");
				}

				echo $ile_like_2;
			}
			else
			{
				echo "szut mamy problem";
			}
		}
		$connection->close();
	}
	else
	{
		echo "1";
	}

?>