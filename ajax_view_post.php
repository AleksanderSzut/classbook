<?php
	session_start();

	if((!isset($_SESSION['online'])) || ($_SESSION['online'] == false))
	{
		echo "błąd";
	}
	elseif($_SESSION['activated'] == 0)
	{
		echo "błąd";	
	}
	elseif((isset($_POST['type'])))
	{
        $myId= $_SESSION['id'];
		$type = $_POST['type'];
		if($type == 2)
		{
			if(isset($_SESSION['no_my_profile']))
			{	
				$id = $_SESSION['id_user_profile'];
				if($_SESSION['my_friends'] == 1)
				{
					$sql = "SELECT * FROM post WHERE view != 2 AND id_user='$id' ORDER BY data DESC";
				}
				else 
				{
					$sql = "SELECT * FROM post WHERE view = 3 AND id_user='$id' ORDER BY data DESC";
				}
				
			}
			else
			{
				$id = $_SESSION['id'];
				$sql = "SELECT * FROM post WHERE id_user='$id' ORDER BY data DESC";
			}
		}
		else
		{
			$id = $_SESSION['id'];
			$sql = "SELECT * FROM friends, post WHERE (id_user!='$id' AND (id_user_1 = id_user OR id_user_2 = id_user) AND (id_user_1 = '$id' OR id_user_2 = '$id') AND view != 2 AND (was_accepted = 1)) ORDER BY data DESC";
		}
		require "connect.php";
		require_once "function.php";

		
		$result = $connection->query($sql);

		if (!$result) throw new Exception($connection->error);
			
		$ip = $result->num_rows;
		if($ip>0)
		{							
			
			$i = 0;
			while($i < $ip )
			{
				$i++;
				
				$row = $result->fetch_assoc();
				$id_user = $row['id_user'];
				$id_post = $row['id_post'];
				$text = $row['text'];
				$unix = $row['data'];
				$date = convert_unix_date($unix);
				$id_img = $row['img'];
				if($type == 2)
				{

					$content_menu =  '<div class="optinos_post_div" onclick="delete_post('.$id_post.')"><i class="icon-crop" type="test"></i>Usuń Post</div>';
				}	
				else
				{
					$content_menu =  '<div class="optinos_post_div"><i class="icon-crop" type="test"></i>Zgłoś post</div>';
				}	
				$content_menu = $content_menu.'<div class="optinos_post_div"><i class="icon-crop" type="test"></i>Edytuj</div>';
				
				if($id_img == 1)
				{
					$content = $text.'<div class="img_post_div"><img class="img_post" src="post_img/'.$id_post.'.jpg" /></div>';
				}
				else
				{

					$content = $text;
				}
				$class1 = "post_like";
				$class2 = "post_like";

				//users
				$result_user = $connection->query("SELECT * FROM users WHERE id = '$id_user'");
				$row_user = $result_user->fetch_assoc();
				$name = $row_user['name'];
				$last_name = $row_user['last_name'];
				$id_profile = $row_user['id_profile'];
				if($id_profile != 0)
				{
					$profile =view_profile($id_profile);
				}
				else
				{
					$profile = view_profile(0);
				}
				//Where ist Like?
				$result2 = $connection->query("SELECT * FROM like_post WHERE id_post='$id_post' AND type_like=1");

				if (!$result2) throw new Exception($connection->error);
				$like=0;	
				$like = $result2->num_rows;

				//Where ist Dont Like?
				$result3 = $connection->query("SELECT * FROM like_post WHERE id_post='$id_post' AND type_like=2");

				if (!$result3) throw new Exception($connection->error);
					
				$dont_like = $result3->num_rows;
				
				//if my likes?
				$result4= $connection->query("SELECT * FROM like_post WHERE id_user = '$myId' AND id_post = '$id_post'");
                
				if (!$result4) throw new Exception($connection->error);
					
				$if_my_likes = $result4->num_rows;
				if($if_my_likes == 1)
				{
					$active_type = $result4->fetch_assoc();
					$type = $active_type['type_like'];
					if($type == 1)
					{
						$class1 = "post_like_active";
					}
					else
					{
						$class2 = "post_like_active";
					}
				}

				
				
				echo '				<div class="post_type_text" id="post.'.$id_post.'"><div class="post_top_div"><div class="post_info_user"><div '.$profile.' class="post_profile"></div><div class="post_user_name"><a href="profile.php?id='.$id_user.'">'.$name." ".$last_name.'</a></div><div class="time_post">'.$date.'</div></div>
					<div class="menu_post_options_view">
						<div class="post_options">
							<i class="icon-angle-down"></i>
						</div>
						<div class="view_post_option">
								'.$content_menu.'
						</div>
					</div>
					</div><div class="post_mid_div">'.$content.'</div><div class="post_bottom_div"><div class="'.$class1.'" id="id_'.$id_post.'" onclick="like(1, '.$id_post.',11)" ><div id="num_like_'.$id_post.'" class="post_num_like" >'.$like.'</div><i class="icon-thumbs-up-alt"></i></div><div class="'.$class2.'" id="id_'.$id_post.'_dont" onclick="like(2,'.$id_post.', 2)"><div id="num_like_dont_'.$id_post.'" class="post_num_like" >'.$dont_like.'</div><i class="icon-thumbs-down-alt"></i></div></div></div>';	
			}
		}
		
		
	}
		$connection->close();		
			
		
		

?>