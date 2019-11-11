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
	else
	{
		require "connect.php";

		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			$connection = new mysqli($host, $db_user, $db_pass, $db_name);
			
		 	if($connection->connect_errno != 0)
		 	{
		 	 	throw new Exception(mysqli_connect_errno());
		 	}
			else
			{
				if(isset($_SESSION['no_my_profile']))
				{	
					$id_user = $_SESSION['id_user_profile'];
				}
				else
				{
					$id_user = $_SESSION['id'];
				}
				$result = $connection->query("SELECT * FROM info_users WHERE id_user = '$id_user' ");

				if (!$result) throw new Exception($connection->error);

				$number_info = $result->num_rows;
				$i = 0;
				while($i < $number_info )
				{
					$row = $result->fetch_assoc();
					$type = $row['type'];
					$content = $row['content'];

					switch($type)
					{
						case (1):
							$fontello = "location";
						break;
					}

					echo '<div class="div_info_tabel"><fontello><i class="icon-'.$fontello.'"></i></fontello>Strzelce kraj</div>';
					$i++;
				}
			}
		}
		catch(Exception $e)
		{
			echo "<div style='color:red;font-size:50px;'>Błąd serwera</div>".$e;
		}
	}
?>