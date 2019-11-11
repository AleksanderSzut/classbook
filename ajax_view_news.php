<?php 

	session_start();

	if((isset($_SESSION['online'])) || ($_SESSION['online'] == TRUE))
	{
		$id = $_SESSION['id'];
		$content = "";
		require_once "connect.php";
		require_once "function.php";

		$result = $connection->query("SELECT * FROM news WHERE id_user='$id' ORDER BY date DESC");
		if (!$result) throw new Exception($connection->error);
		$number_of_news = $result->num_rows;
		if(isset($_GET['type']))
		{
			echo $number_of_news;
			exit(); 
		}
		$i = 1;

		while($number_of_news >= $i)
		{
			$row = $result->fetch_assoc();
			$id_item = $row['id_item'];
			$type_news = $row['type_news'];
			$view = $row['view'];
			$date = $row['date'];
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
			$view_date = convert_unix_date($date);

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
					$content = $content.'<div class="tag_news">'.$view_date.'
			<div class="div_news_friends">
				<div class="news_post_info">
					<a href="profile.php?id='.$id_user.'" class="user_news">
						<div '.$profile.'class="div_profile_news"></div>
						<div class="text_news">
							<div class="name_user_news">'.$name.' '.$last_name.'</div>
							<div class="content_news">'.$sex_print.' cię do znajomych</div>
						</div>										
					</a>
				</div>
				<div class="buttom_accepted_add_friend" onclick="friends(), accepting_knowledge(1,'.$id_user.'), view_news()">Akceptuj</div>
				<div class="buttom_accepted_add_friend" onclick="friends(), accepting_knowledge(0,'.$id_user.'), view_news()">Odrzuć</div>
			</div>
		</div>';
					break;
				case 3:
					break;

			}
			$i++;
		}
		if($result = $connection->query("UPDATE news SET view=1 WHERE id_user='$id'"))
		
		echo $content;
		$connection->close();
	}

?>