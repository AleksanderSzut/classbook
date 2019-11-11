<?php
	session_start();

	unset($_SESSION['no_my_profile']);
	unset($_SESSION['id_profile_user'] );
	unset($_SESSION['email_profile_user']);
	unset($_SESSION['name_profile_user']);
	unset($_SESSION['last_name_profile_user']);
	unset($_SESSION['birthday_year_profile_user']);
	unset($_SESSION['birthday_month_profile_user']);
	unset($_SESSION['birthday_day_profile_user']);
	unset($_SESSION['sex_profile_user']);
	unset($_SESSION['nation_profile_user']);
	unset($_SESSION['city_profile_user']);
	unset($_SESSION['street_profile_user']);
	unset($_SESSION['h_number_profile_user']);
	unset($_SESSION['id_profile_profile_user']);
	unset($_SESSION['date_create_profile_user']);
	unset($_SESSION['my_friends']);
	
	if((!isset($_SESSION['online'])) && ($_SESSION['online'] == false))
	{
		header('Location:home');session_unset();exit();
	}
	elseif($_SESSION['activated'] == 0)
	{
		header('Location:activate.php?id='.$_SESSION['id']);$_SESSION['activate_online'] = true;exit();
	}
	//Sesje 
	$id = $_SESSION['id'];

	require_once "connect.php";
	require_once "function.php";

	if(isset($_GET['id']))
	{
		$id_profile_user = $_GET['id'];
		if($_SESSION['id'] != $id_profile_user)
		{
			$result = $connection->query("SELECT * FROM users WHERE id='$id_profile_user'");
			if (!$result) throw new Exception($connection->error);
			$user_id = $result->num_rows;
			if($user_id > 0)
			{
				$wiersz_user = $result->fetch_assoc();

				$_SESSION['no_my_profile'] = true;
				$_SESSION['id_profile_user'] = $id_profile_user;

				$result = $connection->query("SELECT * FROM friends WHERE (id_user_1 = '$id' OR id_user_2 = '$id') AND (id_user_1 = '$id_profile_user' OR id_user_2 = '$id_profile_user')");
				$my_friends = $result->num_rows;
				$row = $result->fetch_assoc();
				if($my_friends == 0)
				{
					$_SESSION['my_friends'] = 0;
				}
				elseif( $row['was_accepted'] == 0)
				{
					$_SESSION['my_friends'] = 3;
				}
				else
				{
					$_SESSION['my_friends'] = 1;
				}
				$_SESSION['id_user_profile'] = $wiersz_user['id'];
				$_SESSION['email_profile_user'] = $wiersz_user['email'];
				$_SESSION['name_profile_user'] = $wiersz_user['name'];
				$_SESSION['last_name_profile_user'] = $wiersz_user['last_name'];
				$_SESSION['birthday_year_profile_user'] = $wiersz_user['birthday_year'];
				$_SESSION['birthday_month_profile_user'] = $wiersz_user['birthday_month'];
				$_SESSION['birthday_day_profile_user'] = $wiersz_user['birthday_day'];
				$_SESSION['sex_profile_user'] = $wiersz_user['sex'];
				$_SESSION['id_profile_profile_user'] = $wiersz_user['id_profile'];
				$_SESSION['year_create_profile_user'] = $wiersz_user['year_create'];
				$_SESSION['month_create_profile_user'] = $wiersz_user['month_create'];
				$_SESSION['day_create_profile_user'] = $wiersz_user['day_create'];
			}
			else
			{
				header('Location:profile.php');
			}
		}
		else
		{
			header('Location:profile.php');exit();
		}
	}
		
?>
<!DOCTYPE html>
<html lang="pl" >
	<head>
		<meta charset="utf-8" />
		<title>Classbook-<?php if(isset($_SESSION['no_my_profile'])) echo $_SESSION['name_profile_user']." ".$_SESSION['last_name_profile_user']; else echo $_SESSION['name']." ".$_SESSION['last_name'];?></title>
		<link rel="shortcut icon" href="style/img/logo.gif" />
		<link rel="stylesheet" href="style/style.css"  type="text/css" />
		<link rel="stylesheet" href="css/fontello.css"  type="text/css" />
		<link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="jquery/jquery.scrollTo.min.js"></script>
		<script src="function.js"></script>

	</head>
	<body background="style/img/jpg.jpg" <?php OnloadBodyJs(1)?>>
		<a href="#" class="scroll_up_click"><div class="scrollup"><i class="icon-angle-up"></i></div></a>
		<div id="div_info"></div>		
		<div id="conteiner">
			<?php
 
				view_nav();
				view_search();
			?>
		
			<div class="mid_div">
				<div class="content_profile">
					<div class="bottom_tabel">
						<div 
							<?php 

								if(isset($_SESSION['no_my_profile']))
								{
									$profile_id = $_SESSION['id_profile_profile_user'];
								}
								else
								{
									$profile_id = $_SESSION['id_profile'];
								}
								echo view_profile($profile_id);
							?> class="profile_user_profile_div" >
						</div>
							<?php
								if(!isset($_SESSION['no_my_profile']))
								{
									echo '
									<div class="div_add_profile"><i class="icon-camera"></i>
										<div class="menu_add_profile">
											<form enctype="multipart/form-data"  method="post">
											    <input type="file" name="file" style="display:none;" id="file" />
											    <label for="file" class="inp_add_profile">Wybierz zdjęcie</label>
											    <div class="info_add_profile">Zdjęcie profilowe może mieć maksymalnie 2 mb. </br>Najlepsza proporcja zdjęcia to 1:1 </div>
											    <input type="submit" class="button_add_profile" value="Ustaw" onclick="add_profile()"/>
											</form>
											<section >
											    <h3>Postęp wysyłania</h3>
											    <output id="status">Wybierz plik i naciśnij <i>Ustaw</i>.</output>
											    <progress value="0" max="100" id="progress"></progress>
											</section>
										</div>
									</div>';
								}
							?>
						<div class="nav_profile">
							<div class="profile_name_div">
								<?php 
									if(isset($_SESSION['no_my_profile']))
									{	
										echo $_SESSION['name_profile_user']." ".$_SESSION['last_name_profile_user']; 
									}
									else
									{
										echo $_SESSION['name']." ".$_SESSION['last_name']; 
									}
								?>
							</div>
							<?php

								if(isset($_SESSION['no_my_profile']))
								{	
									if($_SESSION['my_friends'] == 1)
									{
										$fontello = "user-times";
									}
									elseif($_SESSION['my_friends'] == 3)
									{
										$fontello = "help";
									}
									else
									{
										$fontello = "user-plus";
									}
									echo '<div class="profile_nav_div" id="add_user"onclick="add_friends('.$_SESSION['id_profile_user'].')"><i class="icon-'.$fontello.'"></i></div>';
									
								}


							?>
						</div>
						<div class="info_profile" id="info">
			
							<div class="div_info">
								<?php

									$user = new user(2);
								?>
								<div class="div_info_tag">Informacje</div>
								<div class="div_info_bottom">
									<?php

										
										if(isset($_SESSION['no_my_profile']))
										{
											$info[1] = $_SESSION['birthday_year_profile_user'];
											$info[2] = $_SESSION['birthday_month_profile_user'];
											$info[3] = $_SESSION['birthday_day_profile_user'];
											$info[4] = $_SESSION['sex_profile_user'];

											$id_user = $_SESSION['id_user_profile'];
											$to_edit = false;
										}
										else
										{
											$info[1] = $_SESSION['birthday_year'];
											$info[2] = $_SESSION['birthday_month'];
											$info[3] = $_SESSION['birthday_day'];
											$info[4] = $_SESSION['sex'];
											$id_user = $_SESSION['id'];
											$to_edit = true;
										}
										$info[2] = text_month($info[2]);
										$info[5] = $info[3]." ".$info[2]." ".$info[1];
										$result = $connection->query("SELECT * FROM info_users WHERE id_user = '$id_user' ");

										if (!$result) throw new Exception($connection->error);

										$number_info = $result->num_rows;
										$i = 0;
										while($i < $number_info+2 )
										{
											switch ($i+1)
											{
												case(1):
													$content = $info[5];
													$fontello = "birthday";
												break;
												case(2):
													$content = $info[4];
													if($content==1)
													{
														$fontello = "mars";
														$content = "Chłopak";
													}
													else
													{
														$fontello = "venus";
														$content = "Dziewczyna";
													}
												break;
												default:
													$row = $result->fetch_assoc();
													$type = $row['type'];
													$content = $row['content'];

													switch($type)
													{
														case (1):
															if($to_edit==true)
															{
																$to_edit=1;
															}
															$fontello = "location";
														break;
														case (2):
															if($to_edit==true)
															{
																$to_edit=2;
															}
														//fucking remember the feling
															$remember = $content;
															$transparent = true;
														break;
														case (3):
															if($to_edit==true)
															{
																$to_edit=3;
															}
															if(isset($remember))
															{
																$content = "ul.".$remember." ".$content;
															}
														break;
														case (4):
															if($to_edit==true)
															{
																$to_edit=4;
															}
															$fontello = "graduation-cap";
														break;
													}
											}
											$i++;
											if(!isset($transparent))
											{
												if($to_edit==true)$edit = '<div class="edit_profile_info"><i class="icon-cog" onclick="start_edit('.$i.')"></i></div>';
												else $edit = '';

												echo '<div class="div_info_tabel"><div class="div_info_tabel_content" id="start_edit_'.$i.'"><fontello><i class="icon-'.$fontello.'"></i></fontello>'.$content.'</div>'.$edit.'<div style="clear:both;"></div></div>';
											}
											else
											{
												unset($transparent);
											}
										}
											
									?>
								</div>
							</div>
							<div class="div_info">
								<div class="div_info_tag">Znajomi</div>
								<div class="div_info_bottom">
									<?php
										if(isset($_GET['id']))
										{
											$id_profile = $_GET['id'];
										}
										else
										{
											$id_profile = $_SESSION['id'];
										}

										$result = $connection->query("SELECT * FROM friends WHERE (id_user_1 = '$id_profile' OR id_user_2 = '$id_profile') AND was_accepted = 1");
										$iu = $result->num_rows;
										$i = 0;
										while($iu > $i)
										{
											$i++;
											$row = $result->fetch_assoc();
											$id_user_1_row = $row['id_user_1'];
											$id_user_2_row = $row['id_user_2'];
											if($id_user_1_row == $id_profile)
											{
												$id_user_3 = $id_user_2_row;
											}
											else
											{
												$id_user_3 = $id_user_1_row;
											}
											$result2 = $connection->query("SELECT * FROM users WHERE id='$id_user_3'");
											$row_2 = $result2->fetch_assoc();
											$id_profile_img = $row_2['id_profile'];
											if($id_profile_img != 0)
											{
												$img = view_profile( $id_profile_img);
											}
											else
											{
												$img = view_profile(0);
											}
											$name = $row_2['name'];
											$last_name = $row_2['last_name'];

											echo'<a title="'.$name.' '.$last_name.'"href="profile.php?id='.$id_user_3.'">
												<div '.$img.'class="profile_friends_view">
												</div>
											</a>';

										
										}

									?>
								</div>
							</div>
							<div class="div_info">
								<div class="div_info_tag">Grupy</div>
								<div class="div_info_bottom">Brak zawartości do wyświetlenia</div>
							</div>
						</div>
						<div class="post_tabel">
							<div class="new_post" id="add_post">
								<form method="post" action="javascript:add_post(2);">
									<div class="top_new_post">
										<div class="type_new_post" onclick="add_post_type(1,1)"><i class="icon-quote-right"></i></div>
										<div class="type_new_post" onclick="add_post_type(2,1)"><i class="icon-camera"></i></div>
										<div class="type_new_post" onclick="add_post_type(3,1)"><i class="icon-video"></i></div>
									</div>
									<textarea class="new_post_input" placeholder="Co tam?"  id="post"></textarea>
									<div class="bottom_new_post">
											<div class="type_new_post2"><i class="icon-tag"></i>
												<div class="menu_sliding">
													<div class="menu_sliding_justdoit">
														Już wkrótce
													</div>
												</div>
											</div>
											<div class="type_new_post2"><i class="icon-eye"></i>
												<div class="menu_sliding">
													<form>
														<div class="options_new_post_view">
															<input type="radio" name="view" value="1" id="checkbox_newpost" class="checkbox_newpost">
															<label for="checkbox_newpost" class="new_post_options_label">Znajomi</label>
														</div>
														<div class="options_new_post_view">
															<input type="radio" name="view" value="2" id="checkbox_newpost2" class="checkbox_newpost">
															<label for="checkbox_newpost2" class="new_post_options_label">Tylko ja!</label>
														</div>
														<div class="options_new_post_view">
															<input type="radio" name="view" value="3" id="checkbox_newpost3" class="checkbox_newpost">
															<label for="checkbox_newpost3" class="new_post_options_label">Publiczne</label>
														</div>
													</form>
												</div>
											</div>
											<div class="type_new_post2"><i class="icon-location"></i>
												<div class="menu_sliding">
													<div class="menu_sliding_justdoit">
														Już wkrótce
													</div>
												</div>
											</div>
										<input value="Dodaj post" class="new_post_buttom" type="submit">
									</div>
								</form>
							</div>
							<div id="view_post"></div>	
						</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
    
                require_once "function.php";
                
                view_rightDiv();
    
    
    
            ?>
		</div>
	</body>
</html>
<script>

	$(document).ready(function() {
	   var stickyNavTop = $('.nav_profile').offset().top;

	   var stickyNav = function(){
	   var scrollTop = $(window).scrollTop();

	   if (scrollTop > stickyNavTop) { 
	      $('.info_profile').addClass('sticky_profile_info');
	   } else {
	      $('.info_profile').removeClass('sticky_profile_info');
	    }
	   };

	   stickyNav();

	   $(window).scroll(function() {
	      stickyNav();

   });
   });
</script>
