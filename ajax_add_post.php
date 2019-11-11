<?php
	session_start();

	if((!isset($_SESSION['online'])) || ($_SESSION['online'] == false))
	{
		echo view_info('Błąd nie dodano posta spróbuj jeszcze raz<i class="icon-cancel"></i>',0);
	}
	elseif($_SESSION['activated'] == 0)
	{
		echo view_info('Błąd nie dodano posta spróbuj jeszcze raz<i class="icon-cancel"></i>',0);
	}
	elseif(isset($_GET['post']))
	{

		$id = $_SESSION['id'];

		if(isset($_GET['view']) && ($_GET['view'] >=1 || $_GET['view'] <=3))
		{
			$view = $_GET['view'];
		}
		else
		{
			$view = 1;
		}
		require_once "connect.php";
		require_once "function.php";

		$text_post = $_GET['post'];
		$text_post = htmlentities($text_post, ENT_QUOTES, "UTF-8");

		$date = date("U");
		
		$text_post = nl2br($text_post);
		
		if($connected)
		{
			if($result = $connection->query("INSERT INTO post(id_post, id_user, type, text, view, data, img) VALUES (NULL, '$id', '1', '$text_post', '$view', '$date',0)"))
			{
				echo view_info('Dodano post<i class="icon-ok"></i>',1);
				
			}
			else
			{		
				echo view_info('Błąd nie dodano posta spróbuj jeszcze raz<i class="icon-cancel"></i>',0);
			}
			
		}
			
	}

?>