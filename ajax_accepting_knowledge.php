<?php 

	session_start();

	if((!isset($_SESSION['online'])) && ($_SESSION['online'] == false))
	{
		header('Location:home');session_unset();exit();
	}
	elseif($_SESSION['activated'] == 0)
	{
		header('Location:activate.php?id='.$_SESSION['id']);$_SESSION['activate_online'] = true;exit();
	}
	elseif((isset($_GET['id_user'])) && (isset($_GET['type'])) && ($_GET['type'] == 1 || $_GET['type'] == 0))
	{

		$id_user = $_GET['id_user'];
		$type = $_GET['type'];
		$id = $_SESSION['id'];

		require "connect.php";
		require "function.php";

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
				$result = $connection->query("SELECT * FROM friends WHERE (id_user_1='$id' OR id_user_2='$id') AND (id_user_1='$id_user' OR id_user_2='$id_user') AND was_accepted = 0");

				$row = $result->fetch_assoc();
				$id_knowledge = $row['id_knowledge'];

				if (!$result) throw new Exception($connection->error);
					
				$ip = $result->num_rows;

				if($ip>0)
				{
					$date = date("Y-m-d H-i-s");
					$news = new news($id_knowledge, 2);
					if($type == 1)
					{
						$date = date("Y-m-d");
						if($connection->query("UPDATE friends SET was_accepted = 1, date = '$date' WHERE (id_user_1='$id' OR id_user_2='$id') AND (id_user_1='$id_user' OR id_user_2='$id_user') AND was_accepted = 0"))
						{
							$news->delete_news();
							$result = $news->result;
							if($result)
								echo "pyklo";
							else
								echo "nie pyklo";  
								

						}
						else
						{
							echo 02;
						}
					}
					else
					{
						if($connection->query("DELETE FROM friends WHERE (id_user_1='$id' OR id_user_2='$id') AND (id_user_1='$id_user' OR id_user_2='$id_user') AND was_accepted = 0"))
						{
							$news->delete_news();
							$result = $news->result;
							if($result)
								echo "pyklo";
							else
								echo "nie pyklo";  
							
						}
						else
						{

						}
					}
				}
				else
				{

				}

			}
			$connection->close();		
		
		}
		catch(Exception $e)
		{
			
		}
	}
	else
	{

	}



?>