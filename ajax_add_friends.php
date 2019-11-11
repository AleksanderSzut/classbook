<?php
	session_start();

	if((!isset($_SESSION['online'])) && ($_SESSION['online'] == false))
	{
		$result = 0;
	}

	elseif($_SESSION['activated'] == 0)
	{
		$result = 0;
	}
    
	elseif(isset($_GET['id_user']))
	{
		require_once "connect.php";
		require_once "function.php";
		
		if($connected == true)
		{
			$id_user = $_GET['id_user'];
			$id = $_SESSION['id'];
			$connection = new mysqli($host, $db_user, $db_pass, $db_name);
			
			$result = $connection->query("SELECT * FROM friends WHERE (id_user_1='$id' OR id_user_2='$id') AND (id_user_1='$id_user' OR id_user_2='$id_user')");
			if (!$result) throw new Exception($connection->error);

			$friends = $result->num_rows;

			if($friends>0)
			{
				if($connection->query("DELETE FROM friends WHERE (id_user_1='$id' OR id_user_2='$id') AND (id_user_1='$id_user' OR id_user_2='$id_user')"))
				{
					$result = 1;
				}
				else
				{
					echo "<div style='color:red;font-size:50px;'>Błąd serwara</div>";
				}
			}
			else
			{
				$date = date("U");

				if($connection->query("INSERT INTO friends (id_knowledge, id_user_1, id_user_2, was_accepted, date) VALUES (NULL,'$id', '$id_user', '0', '$date')"))
				{
					$result = $connection->query("SELECT * FROM friends ORDER BY id_knowledge DESC ");
					$row = $result->fetch_assoc();
					$id_knowledge = $row['id_knowledge'];
					
					$news = new news($id_knowledge, 2);
					$add_news = $news->add_news($id_user);
					$result = 2;

				}
				else
				{
					echo "<div style='color:red;font-size:50px;'>Błąd serwara</div>";
				}
			}
				
		}
		$connection->close();	
	}

	if($result == 1)
	{
		$fontello = "user-plus";
	}
	elseif($result == 2)
	{
		$fontello = "help";
	}
	echo '<i class="icon-'.$fontello.'"></i>';

	

	
?>
