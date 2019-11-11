<?php

	session_start();

	if((isset($_SESSION['online'])) || ($_SESSION['online'] == TRUE))
	{
		//Include
		require "connect.php";
		require "function.php";

		if($connected)
		{
			//Atach session
			$id_user = $_SESSION['id'];
			$unix_date = date("U");

			$result = $connection->query("SELECT id, view, date-'$unix_date', id_user, id_item, type_news FROM news WHERE id_user='$id_user' AND view=0 ORDER BY date ASC");

			$row = $result->fetch_assoc();
			$type_news = $row['type_news'];
			$id_item = $row['id_item'];
			$id_news = $row['id'];

			switch ($type_news)
			{
				case 1:
					
					$result2 = $connection->query("SELECT * FROM like_post WHERE id_like='$id_item'");

					$row2 = $result2->fetch_assoc();
					$id_post = $row2['id_post'];
					$id_user = $row2['id_user'];
					$type_like = $row2['type_like'];


					break;
				case 2:
					$result2 = $connection->query("SELECT * FROM friends WHERE id_knowledge='$id_item'");
					$row2 = $result2->fetch_assoc();
					$id_user = $row2['id_user_1'];
					break;
				default:
					exit();
					break;
			}
			$user = new user($id_user);
			$name = $user->name;
			$last_name = $user->last_name;
			$sex = $user->sex;
			
			
			$id_profile = $user->id_profile;

			$profile = view_profile($id_profile);
			$view_date = convert_unix_date($unix_date);

			$content="";

			switch ($type_news)
			{
				case 1:
					if($type_like == 1)
					{
						if($sex == 0)
							$sex_print = "Polubiła twoje zdjęcie.";
						else
							$sex_print = "Polubił twoje zdjęcie.";
						
					}
					else
					{
						$sex_print = "Nie lubi twojego zdjęcia.";
					}

					$content = $content.'<div class="tag_news">'.$view_date.'
			<a href="profile.php#post.'.$id_post.'">
				<div class="div_news_friends">
					<div class="news_post_info">
						<div '.$profile.' class="div_profile_news"></div>
						<div class="text_news">
							<div class="name_user_news">'.$name.' '.$last_name.'</div>
							<div class="content_news">'.$sex_print.'</div>
						</div>
					</div>
					
				</div>
			</a>
		</div>';
					break;
				case 2:
					if($sex == 0)
						$sex_print = "Zaprosiła";
					else
						$sex_print = "Zaprosił";
                    
					$content = $content.'<div class="view_info" id="where_div_view">
			<div '.$profile.'class="profile_view_info">

			</div>	
			<div class="view_info_name_user">
				<a href="profile.php?id='.$id_user.'" style="text-decoration:none;">'.$name.' '.$last_name.'</a>
			</div>
			<div class="delete_view_info" onclick="view_info()">
				x
			</div>
			<div class="view_info_content">
				'.$sex_print.' cię do znajomych.
			</div>
		</div>';
					break;
				case 3:
					break;

			}

			if($result != $connection->query("UPDATE news SET view=1 WHERE id = '$id_item'"))
				
            echo $content;
			$connection->close();
		}
	}

?>