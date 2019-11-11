<?php

	session_start();
	
	if ((isset($_SESSION['online'])) && ($_SESSION['online']==true))
	{
		header('Location: index.php');exit();
    }

    if (isset($_POST['email']))
	{
		$all_ok = true;
		
		//walidacja email'u
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$all_ok = false;
			$_SESSION['e_email'] = true;
		}
		
		
		//walidacja imienia i nazwiska
		$name = $_POST['name'];
		$last_name = $_POST['last_name'];
		if ((strlen($name)<1) || (strlen($name)>20))
		{
			$all_ok = false;
			$_SESSION['e_name'] = true;
		}	
		
		if ((strlen($last_name)<1) || (strlen($last_name)>20))
		{
			$all_ok = false;
			$_SESSION['e_last_name'] = true;
		}	
		
		
		//Walidacja hasła
		$pass = $_POST['pass'];
		$pass2 = $_POST['pass2'];
		  
		if ((strlen($pass)<8) || (strlen($pass)>20))
		{
			$all_ok = false;
			$_SESSION['e_pass'] = true;
		}
		else
		{
			if ($pass != $pass2 )
			{
				$all_ok = false;
				$_SESSION['e_pass2']=true;
			}
		}
		$pass_hash = password_hash($pass, PASSWORD_DEFAULT);
		
		
		//walidacja daty
		$birthday_day = $_POST['birthday_day'];
		$birthday_month = $_POST['birthday_month'];
		$birthday_year = $_POST['birthday_year'];
		
		if(($birthday_day >= 1 && $birthday_day <= 31) && ($birthday_month >= 1 && $birthday_month<=12)  && ($birthday_year >= 1905 && $birthday_year <= 2016))
		{
			$date = date("Y");
			$min = $date - 13;
			$max = $date - 35;
			if($birthday_year  > $min || $birthday_year < $max)
			{
				$all_ok = false;
				$_SESSION['e_birthday']=true;
			}
		}
		else
		{
			$all_ok = false;
			$_SESSION['e_birthday']=true;
		}
		
		//walidacja płci
		$gender = $_POST['gender'];
		if($gender != 1 && $gender != 2 )
		{
			$all_ok = false;
		}
		
		//easy in humans hard bot
		$sekret = "6LdESiIUAAAAALEP3Zk7_kPiKzF6TMcCWEtSy2vN";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$all_ok = false;
		}
		
		//czy akceptowano regulamin?
		if (!isset($_POST['regulations']))
		{
			$all_ok=false;
			$_SESSION['e_regulamin']=true;
		}
		
		require_once "function.php";
		require_once "connect.php";
		
		if($connected)
		{
				//czy email już istnieje
				$rezultat = $connection->query("SELECT id FROM users WHERE email='$email'");

				if (!$rezultat) throw new Exception($connection->error);

				$ile_maili = $rezultat->num_rows;
				if($ile_maili>0)
				{
						$all_ok=false;
						$_SESSION['e_email']= true;
				}
				$rezultat->free_result();

				if ($all_ok==true)
				{					
						$losowanie1 = rand(10000,9999999); 
						$losowanie2 = rand(10000,9999999); 
						$losowanie3 = rand(10000,9999999); 

						$l1=$losowanie2*$losowanie3+$losowanie1;

						$losowanie4 = rand(100,999); 
						$losowanie5 = rand(100,999); 
						$losowanie6 = rand(100,999); 

						$l2=$losowanie5*$losowanie6+$losowanie4;

						$k1=$l1+$l2;

						$losowanie7 = rand(100,999); 
						$losowanie8 = rand(100,999); 
						$losowanie9 = rand(100,999); 

						$l3=$losowanie8*$losowanie9+$losowanie7;

						$losowanie10 = rand(100,999); 
						$losowanie11 = rand(100,999); 
						$losowanie12 = rand(100,999); 

						$l4=$losowanie10*$losowanie12+$losowanie11;

						$k2 =$l3+$l4;
						$k3 = ($k1+$k2);
						$keys = round($k3/rand(1,15));
						$year = date("Y");
						$month = date("m");
						$day = date('d');
						if($connection->query("INSERT INTO users VALUES (NULL, '$email', NULL, '$pass_hash', '$name', '$last_name', '$birthday_year', '$birthday_month', '$birthday_day', '$gender', '$keys', 0, 0, 0, '$year', '$month', $day,0)"))
						{
								$result = $connection->query("SELECT * FROM users WHERE email='$email'");
				                $row = $result->fetch_assoc();
								$id = $row['id'];
							
				                send_email_activation($email, $keys, $id);

						}
						else
						{
								throw new exception($connection->error);
						}
				}		

				$connection->close();
		}
	}
?>
<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="utf-8" />
		<meta name="desciption" content="Classbook to strona społeczneściowa zrobiona głównie dla młodzierzy ,ale i dla dorosłych do 35 roku życia. Classbook to strona dla klas, grup i dużych społeczności. Więc zaloguj się i bądź szczęśliwy " />
		<meta name="keywords" content="strona, społecznościowa, grupa, klasa, classbook, class, book,  " />
		<title>Classbook-zaloguj się</title>
		<link rel="shortcut icon" href="style/img/logo.gif" />
		<link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style/start.css" />
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
	<body >
		<div id="conteiner">
			<div class="nav">
				<div id="logo">Classbook</div>
				<div id="flogin">
					<form method="post" action="login.php" />
						<input type="email" name="email" <?php 
								if (isset($_SESSION['e_login_e']))
								{
									echo 'class="e_lin" placeholder="Zły email"';
									unset($_SESSION['e_login_e']);
								}
								else
								{
									echo 'class="lin" placeholder="Wpisz email"';
								}
								?> />
						<input type="password" name="pass" <?php 
								if (isset($_SESSION['e_login_p']))
								{
									echo 'class="e_lin" placeholder="Złe hasło" value=""';
									unset($_SESSION['e_login_p']);
								}
								else
								{
									echo 'class="lin" placeholder="Wpisz hasło"';
								}
								?> 
                            />
						<input type="submit" value="zaloguj się" class="lsub"/>
					</form>
				</div>
			</div>
		    <div class="content">
				<div id="fregister">
					<div id="namediv">Rejestracja</div>
					<div id="register">
						<form method="post">
							<input type="text" name="name" <?php 
								if (isset($_SESSION['e_name']))
								{
									echo 'class="e_rin2" placeholder="Złe imię"';
									unset($_SESSION['e_name']);
								}
								else
								{
									echo 'class="rin2" placeholder="Imię"';
								}
								?>/>
							<input type="text" name="last_name"  title="Miesiąc"<?php 
								if (isset($_SESSION['e_last_name']))
								{
									echo 'class="e_rin2" placeholder="Złe nazwisko"';
									unset($_SESSION['e_last_name']);
								}
								else
								{
									echo 'class="rin2" placeholder="Nazwisko"';
								}
								?>/><br/>
							<input type="text" name="email"<?php 
								if (isset($_SESSION['e_email']))
								{
									echo 'class="e_rin" placeholder="Zły email lub numer telefonu"';
									unset($_SESSION['e_email']);
								}
								else
								{
									echo 'class="rin" placeholder="E-mail lub numer telefonu"';
								}
								?> /><br/>
							<input type="password" name="pass" <?php 
								if (isset($_SESSION['e_pass']))
								{
									echo 'class="e_rin2" placeholder="Złe hasło"';
									unset($_SESSION['e_pass']);
								}
								else
								{
									echo 'class="rin2" placeholder="Hasło"';
								}
								?> />
							<input type="password" name="pass2"<?php 
								if (isset($_SESSION['e_pass2']))
								{
									echo 'class="e_rin2" placeholder="Hasła nie są podobnę"';
									unset($_SESSION['e_pass2']);
								}
								else
								{
									echo 'class="rin2" placeholder="Potwierdź hasło"';
								}
								?> /><br/>
						    <span style="float:left;">
							    <select aria-label="Dzień" name="birthday_day"<?php			
									if (isset($_SESSION['e_birthday']))
									{
										echo 'title="Jesteś zamłody"class="e_birthday"';
									}
									else
									{
										echo 'title="Miesiąc" class="birthday"';
									}
								?>>
									<option value="0" selected="1">Dzień</option>
								    <?php
									
										for($i = 1; $i <= 31 ;$i++)
										{
											echo  '<option value="'.$i.'">'.$i.'</option>';
										}
										
										?>
								</select>
								<select aria-label="Miesiąc" name="birthday_month"<?php			
									if (isset($_SESSION['e_birthday']))
									{
										echo 'title="Jesteś zamłody"class="e_birthday"';
									}
									else
									{
										echo 'title="Miesiąc" class="birthday"';
									}
								?>>
									<option value="0" selected="1">Miesiąc</option>
									<?php
									
										for($i = 1; $i <= 12 ;$i++)
										{
											echo  '<option value="'.$i.'">'.$i.'</option>';
										}
									
									?>
								</select>
								<select aria-label="Rok" name="birthday_year"<?php			
									if (isset($_SESSION['e_birthday']))
									{
										echo 'title="Jesteś zamłody"class="e_birthday"';
										unset($_SESSION['e_birthday']);
									}
									else
									{
										echo 'title="Miesiąc" class="birthday"';
									}
								?>>
									<option value="0" selected="1">Rok</option>
								   <?php
										$min = date("Y") - 35;
										
										for($date = date("Y"); $date >= $min; $date--)
										{
											echo '<option value="'.$date.'">'.$date.'</option>';
										}
									?>
								</select>									
						    </span>
							<?php			
								 if (isset($_SESSION['e_date']))
								{
									echo '<div class="error">'.$_SESSION['e_date'].'</div>';
									unset($_SESSION['e_date']);
								 }
							 ?>		
                            <br/><br/>
							<label>
								<input type="radio" id="male" name="gender" value="1" checked/>
								<label for="male" class="gender">Mężczyzna</label>
							</label>
							<label>
								<input type="radio" id="female" name="gender" value="2"/> 
								<label for="female"  class="gender">Kobieta</label>
							</label><br/>	
							<div class="g-recaptcha" data-sitekey="6LdESiIUAAAAABkK2tTtBH4QlncQUy96tY-D1bO5"></div>
							<label class="regulamin">
								<input type="checkbox" name="regulations" />
								<?php			
									if (isset($_SESSION['e_regulamin']))
									{
										echo '<error>Potwierdź</errora> <a href="#Just do it">regulamin</a>';
										unset($_SESSION['e_regulamin']);
									}
									else
									{
										echo 'Potwierdź <a href="#Just do it">regulamin</a>';
									}
								?> 
							</label><br/>
							<input type="submit" value="Zarejestruj się" class="rsub"/>
						</form>
					</div>
				</div>
				<div id="contents">
					<div id="opis">Witaj na stronie społecznościowej Classbook<br/><text></text></div>
					<div id="happyimg">
						<?php
						if(isset($_GET['satyra']))
							$img = "satyra.jpg";
						else
							$img = "img1.jpg";
						echo '<div id="happytext"></div>
						<img src="style/img/'.$img.'" class="img" />';
                        ?>
					</div>
					<div id="lang">
						<div class="boxlang"><a href="pl-pl.classbook.pl" class="linklang">Polski</a></div>
						<div class="boxlang"><a href="en-en.classbook.pl" class="linklang">Engilsh</a></div>
						<div class="boxlang"><a href="de-de.classbook.pl" class="linklang">Deutsch</a></div>
						<div class="boxlang"><a href="zh-zh.classbook.pl" class="linklang">中國</a></div>
						<div class="boxlang"><a href="ru-ru.classbook.pl" class="linklang">русский</a></div>
						<div class="boxlang"><a href="ar-ar.classbook.pl" class="linklang">العربية</a></div>
						<div class="boxlang">></div>
					</div>
				</div>
			</div>
		    <div class="fother">©Copyright wszelkie prawa zastrzeżonę stworzył : Aleksander Szut <a href="#kup domenę">http://Classbook.pl</a></div>
		</div>
	</body>
</html>