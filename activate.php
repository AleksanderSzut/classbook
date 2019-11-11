<?php
	session_start();
	
	if($_SESSION['activate_online'] == false)
	{
		header('Location:index.php');exit();
	}
	
	else
	{
		if(!isset($_GET['id']))
		{
			if(!isset($_SESSION['id']))		
			{
				header('Location:home');exit();
			}
			else
			{
				$id = $_SESSION['id'];
			}
		}
		else
		{
			$id = $_GET['id'];
			$_SESSION['id'] = $id;
		}
		
		require_once "connect.php";
			
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
				$result = $connection->query("SELECT * FROM users WHERE id='$id' AND activated=0");
				if (!$result) throw new Exception($connection->error);
				
				$ile_id = $result->num_rows;
				
				if($ile_id != 1)
				{
					header ('Location:home');session_unset();exit();
				}
				$result->free_result();
			
				$result = $connection->query("SELECT * FROM users WHERE id='$id'");
				if (!$result) throw new Exception($connection->error);
				
				$wiersz = $result->fetch_assoc();
				$keys = $wiersz['keys'];
				$_SESSION['email'] = $wiersz['email'];
				
				if(isset($_GET['keys']))
				{
					$get_keys = $_GET['keys'];
					
					if($get_keys == $keys)
					{
						if($result = $connection->query("UPDATE users SET activated=1 WHERE id='$id'"))
						{
							unset($_SESSION['activate_online']);
							$_SESSION['activated'] = 1;

							mkdir ("./users/".$id, 0777);
							mkdir ("./users/".$id."/upload", 0777);
							header('Location:index.php');
						}
					}
					else
					{
						$_SESSION['e_aktywacja'] = true;
					}
					
				}					
			}
			$connection->close();		
			
		}
		catch(Exception $e)
		{
			echo $e;
		}
	}
?>
<!DOCTYPE html>
<html lang="pl" >
	<head>
		<meta charset="utf-8" />
		<title>Classbook-strona główna</title>
		<link rel="shortcut icon" href="style/img/logo.gif" />
		<link rel="stylesheet" href="style/style.css"  type="text/css" />
		<link rel="stylesheet" href="css/fontello.css"  type="text/css" />
		<link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="jquery/jquery.scrollTo.min.js"></script>
	</head>
	<body background="style/img/jpg.jpg" onload="online(), friends(), view_news(), view_info()">
		<a href="#" class="scroll_up_click"><div class="scrollup"><i class="icon-angle-up"></i></div></a>
		<div id="div_info"></div>		
		<div id="conteiner">
			<div class="nav">
				<div class="logo" id="logo">
					<div class="text_logo">
						Classbook
					</div>
				</div>
				<div class="square">
					<a href="profile.php" class="a_square">
						<?php
							if($_SESSION['id_profile'] != 0)
							{
								echo '<img src="users/'.$_SESSION['id'].'/profile/'.$_SESSION['id_profile'].'.jpg" class="img_square"/>';
							}
							else
							{
								echo '<img src="style/img/no_profile.jpg" class="img_square"/>';
							}
						?>
					</a>
				</div>
				<div class="square">
					<a href="index.php" class="a_square2">
						<i class="icon-home"></i>
					</a>
				</div>
				<div class="square" >
					<a href="#user" class="a_square3">
						<i class="icon-users"></i>
					</a>
				</div>
				<div class="square">
					<a href="#user" class="a_square4">
						<i class="icon-gamepad"></i>
					</a>
				</div>
				<div class="more"><div style="float:left;"><i class="icon-right-dir"></i></div> 
					<div class="more_tabele">
						<div class="list_more"><a href="" class="a_list_more"><i class="icon-tag"></i>Dodaj reklamę</a></div>
						<div class="list_more"><a href="" class="a_list_more"><i class="icon-cog"></i>Ustawienia</a></div>
						<div class="list_more"><a href="" class="a_list_more"><i class="icon-crop"></i>Stwórz stronę</a></div>
						<div class="list_more"><a href="" class="a_list_more"><i class="icon-mobile"></i>Wersja na smartfona</a></div>
						<div class="list_more"><a href="logout.php" class="a_list_more"><i class="icon-off"></i>Wyloguj się</a></div>
					</div>
				</div>
			</div>
			<div class="topdiv">
				<div class="search">
					<form method="get">
						<input type="text" name="q" class="i_search"/>
						<input type="submit" value="szukaj" class="i_search_buttom" />
					</form>
					<div class="square_min"><i class="icon-globe"></i>
						<div class="square_min_slide">
							<squareminslide>Powiadomienia</squareminslide>
							<div class="square_min_slide_white"  id="view_news">
								
							</div>
						</div>
					</div>
					<div class="square_min"><i class="icon-comment"></i>
						<div class="square_min_slide">
							<squareminslide>Wiadomości</squareminslide>
							<div class="square_min_slide_white">
								Nie masz jeszcze wiadomości
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="mid_div">
				<div class="content" style="width:750px;">
					<div class="post_activated">
						<div class="etakt">Aktywacja konta</div>
						<div class="info_activation">
							Kod aktywacyjny znajdziesz w adresie email, twój adres email: </br><?php echo $_SESSION['email']; ?> <a href="#Just do id">Zmień adres email</a>
						</div>
						<div style="height:70%;width:100%;margin-left:auto; margin-right:auto;">
							<form method="get">
								<input type="text" <?php
								if(isset($_SESSION['e_aktywacja']))
								{
									echo 'placeholder="Zły kod aktywacyjny" class="e_activate_inp_keys"';
									unset($_SESSION['e_aktywacja']);
								}
								else
								{
									echo 'placeholder="Kod aktywacyjny" class="activate_inp_keys"';
								}
								
								?> name="keys" />
								<a href="aktywacja_email.php" style="font-size:25px; display:block; text-align:center;">Wyślij ponownie kod</a>
								<input type="submit" value="Aktywuj" class="activate_inp_buttom"/>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="rightdiv">
				<div class="friends" id="friends">
				</div>
			</div>
		</div>
	</body>
</html>