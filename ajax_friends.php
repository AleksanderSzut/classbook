<?php
	session_start();

	$id = $_SESSION['id'];
	require_once "connect.php";
	require_once "function.php";

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
			$result = $connection->query("SELECT * FROM friends, users WHERE id!='$id' AND (id_user_1 = id OR id_user_2 = id) AND (id_user_1 = '$id' OR id_user_2 = '$id') AND (was_accepted = 1)");

			if (!$result) throw new Exception($connection->error);
				
			$ip = $result->num_rows;
			if($ip>0)
			{									
				
				$i = 0;
				while($i < $ip )
				{
					$i++;
					
					$row = $result->fetch_assoc();
					
					$a1 = $row['name'];
					$a2 = $row['last_name'];
					$a3 = $row['id'];
					$a4 = $row['id_profile'];
					$profile = view_profile($a4);
					$a5 = $row['online_time'];
					$a6 = Date("U");
					$a7 = $a6 - $a5;
					if($a7 >= 20)
					{
						$class = "e_friends_online";
					}
					else
					{
						$class = "friends_online";
					}

	echo'<div class="friends_div">
	<div '.$profile.' class="div_profile_friends">
	</div>
	<div class="text_profile_friends">
		'.$a1.' '.$a2.'
	</div>
	<div class="'.$class.'">
		<i class="icon-desktop"></i>
	</div>
	</div>
	';
					
				}
			}
			$result->free_result();
			
			
		}
		$connection->close();		
		
	}
	catch(Exception $e)
	{
		echo "<div style='color:red;font-size:50px;'>Błąd serwara</div>";
	}

	?>