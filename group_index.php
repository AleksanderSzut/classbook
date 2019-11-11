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

?>
<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="utf-8" />
		<title>Classbook-grupy</title>
		<link rel="shortcut icon" href="style/img/logo.gif" />
		<link rel="stylesheet" href="style/style.css"  type="text/css" />
		<link rel="stylesheet" href="css/fontello.css"  type="text/css" />
		<link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="jquery/jquery.scrollTo.min.js"></script>
		<script src="function.js"></script>
	</head>
	<body background="style/img/jpg.jpg" onload="online(), friends(), view_news(), view_info(), view_tables_group()">
		<a href="#" class="scroll_up_click"><div class="scrollup"><i class="icon-angle-up"></i></div></a>
		<div id="div_info"></div>		
		<div id="conteiner" >
			<?php

				require_once "function.php";

				echo view_nav();
                echo view_search();

			?>
			
			<div class="mid_div">
                <nav class="index_groupNav">
                    <div class="buttonContainer">
                        <i class="icon-users"></i>
                        <img class="img_icon" src="style/img/004-plus.png"/>
                    </div>
                </nav>
				<div id="view_tabele_group" class="content">
					
				</div>
			</div>
			<div class="rightdiv">
				<div class="friends" id="friends">
				</div>
			</div>
		</div>
	</body>
</html>