<?php
	session_start();

	include_once "function.php";

	if((!isset($_SESSION['online'])) || ($_SESSION['online'] == false))
	{
		echo view_info('Błąd nie dodano posta spróbuj jeszcze raz<i class="icon-cancel"></i>',0);
	}
	elseif($_SESSION['activated'] == 0)
	{
		echo view_info('Błąd nie dodano posta spróbuj jeszcze raz<i class="icon-cancel"></i>',0);
	}
	elseif(isset($_POST['post']))
	{
		require_once "connect.php";
		require_once "function.php";

		$id = $_SESSION['id'];

		if(isset($_GET['view']) && ($_GET['view'] >=1 || $_GET['view'] <=3))
		{
			$view = $_GET['view'];
		}
		else
		{
			$view = 1;
		}

		
		$text_post = $_POST['post'];
		$text_post = htmlentities($text_post, ENT_QUOTES, "UTF-8");

		$date = date("U");
		
		$text_post = nl2br($text_post);
		$post_ok = createUrl($text_post);
			
		if($connected)
		{
	        $result = $connection->query("SELECT * FROM post ORDER BY id_post DESC");
	        $row = $result->fetch_assoc();
	        $id_img = $row['id_post']+1;

			$folder_upload = './post_img/';
	        $plik_nazwa = $id_img.".jpg";
	        $plik_lokalizacja = $_FILES['file']['tmp_name']; //tymczasowa lokalizacja pliku
	        $plik_mime = $_FILES['file']['type']; //typ MIME pliku wysłany przez przeglądarkę
	        $plik_rozmiar = $_FILES['file']['size'];
	        $plik_blad = $_FILES['file']['error']; //kod błędu
	         
	       

	        if(!$_POST['view'])
	        {
	        	echo "jest view";
	        }
	        /* sprawdzenie błędów */
	        switch ($plik_blad) {
	            case UPLOAD_ERR_OK:
	            break;

	            case UPLOAD_ERR_NO_FILE:
	                exit("Brak pliku.");
	            break;

	            case UPLOAD_ERR_INI_SIZE:
	            case UPLOAD_ERR_FORM_SIZE:
	                exit("Przekroczony maksymalny rozmiar pliku.");
	            break;

	            default:
	                exit("Nieznany błąd.");
	            break;
	        }
	         
	        $odczyt = pathinfo($plik_nazwa);
			$ext = $odczyt['extension'];
	        /* przeniesienie pliku z folderu tymczasowego do właściwej lokalizacji */
	        if ($ext !=("jpg" || $ext !="jpeg" || $ext !="tiff" || $ext !="tif"|| $ext !="png"|| $ext !="gif"))
	        {
				echo view_info('Błąd. Złe rozszerzenie pliku<i class="icon-cancel"></i>',0);exit();
	        }

	        if (!move_uploaded_file($plik_lokalizacja, $folder_upload."/".$plik_nazwa)) 
	        {
	            exit("Nie udało się przenieść pliku.");
	        }
	        else
	        {

				if(isset($_POST['post']))
				{
					$sql="INSERT INTO post(id_post, id_user, type, text, view, data, img) VALUES (NULL, '$id', '1', '$post_ok', '$view', '$date', 1)";
				}
				else
				{
					$sql="INSERT INTO post(id_post, id_user, type, text, view, data, img) VALUES (NULL, '$id', '1', NULL, '$view', '$date', 1)";
				}
				if($result = $connection->query($sql))
				{
					
					echo view_info('Dodano post<i class="icon-ok"></i>',1);
				}
				else
				{
					echo view_info('Błąd nie dodano posta spróbuj jeszcze raz<i class="icon-cancel"></i>',0);
			
				}
	  		}
		}
		$connection->close();	
  	}

?>