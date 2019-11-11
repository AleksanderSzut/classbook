<?php
	session_start();

	include "function.php";
	if((!isset($_SESSION['online'])) || ($_SESSION['online'] == false))
	{
		echo view_info('Błąd z logowaniem spróbuj się zalogować i wylogować<i class="icon-cancel"></i>',0);
	}
	elseif(isset($_GET['id_post']))
	{
		$id = $_SESSION['id'];
		$id_post = $_GET['id_post'];

		require "connect.php";
		require_once "function.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			$connection = new mysqli($host, $db_user, $db_pass, $db_name);
			
		 	if($connection->connect_errno != 0)
		 	{
		 	 	throw new Exception(mysqli_connect_errno());
		 	}
			else
			{
				$result = $connection->query("SELECT * FROM post WHERE id_user='$id' AND id_post='$id_post'");
				if(($result->num_rows)==1)
				{
					if($connection->query("DELETE FROM post WHERE id_user='$id' AND id_post='$id_post'"))
					{
						$row = $result->fetch_assoc();
						$img = $row['img'];
						$news = new news($id_post, 1);
						if($img == 1)
						@unlink('./users_img/'.$id_post.'.jpg');
						
						echo view_info('Usunięto post<i class="icon-ok"></i>',1);
					}
					else
					{
						echo view_info('Błąd nie Usunięto<i class="icon-cancel"></i>',0);
					}

				}
				else
				{
					echo view_info('Nie masz posta o takim id<i class="icon-cancel"></i>',0);
				}
			}
		}
		catch (Exception $e)
		{
			echo $e;
		}

	}
	else
	{
		echo view_info('Nie podałeś id<i class="icon-cancel"></i>',0);
	}

?>