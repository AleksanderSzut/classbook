<?php 

	session_start();

	if((!isset($_SESSION['online'])) && ($_SESSION['online'] == false))
	{
		echo 0;	
	}
	elseif($_SESSION['activated'] == 0)
	{
		echo 0;	
	}
	elseif((isset($_GET['q'])))
	{
		$q = $_GET['q'];
		$q_sanitized = htmlentities($q, ENT_QUOTES, "UTF-8");
		$q_space = explode(" ", $q_sanitized);

		$z = $q_space[0];
		if($z != $q_sanitized)
		{
			$z = $q_space[0];
			$j = $q_space[1];
			$sql = "SELECT * FROM users WHERE (name LIKE '%$z%' AND last_name LIKE '%$j%') AND activated=1";

		}
		else
		{
			$z = $q_space[0];
			$j = $z;
			$sql = "SELECT * FROM users WHERE (name LIKE '%$z%' OR last_name LIKE '%$j%') AND activated=1";
		}

		require "connect.php";

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
					$result  = $connection->query($sql);
					$wyniki = $result->num_rows;
					if($wyniki > 3)
					{
						$wyniki = 3;
					}

					$i = 0;
					while($i < $wyniki)
					{
						$row = $result->fetch_assoc();
						$id_user = $row['id'];
						$name = $row['name'];
						$last_name = $row['last_name'];
						$id_profile = $row['id_profile'];
						require_once "function.php";
						$view_profile = view_profile($id_profile);

						echo '<div class="result">
							  	<a href="profile.php?id='.$id_user.'">
									<div '.$view_profile.'class="result_img_div"></div>
									<div class="result_name">'.$name.' '.$last_name.'</div>
								</a>
							  </div>';

						$i++;
						

					}
				}
				$connection->close();		
				
			}
			catch(Exception $e)
			{
				echo "<div style='color:red;font-size:50px;'>Błąd serwara</div>".$e;
			}
	}
	else
	{
		echo 2;	
	}



?>