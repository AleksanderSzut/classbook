<?php
	
	session_start();
	
	if((!isset($_POST['email'])) || (!isset($_POST['pass'])))
	{
		header('Location:start.php'); exit();
	}
	
	require_once "connect.php";
	
	if($connected)
    {
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $email = htmlentities($email, ENT_QUOTES, "UTF-8");

        if($rezultat = $connection->query(
        sprintf("SELECT * FROM users WHERE email='%s'",
        mysqli_real_escape_string($connection,$email))))
        {
            $ilu_userow = $rezultat->num_rows;
            if($ilu_userow > 0)
            {
                $wiersz = $rezultat->fetch_assoc();

                if(password_verify($pass, $wiersz['pass']))
                {
                    $_SESSION['online'] = true;
                    $_SESSION['id'] = $wiersz['id'];
                    $_SESSION['email'] = $wiersz['email'];
                    $_SESSION['name'] = $wiersz['name'];
                    $_SESSION['last_name'] = $wiersz['last_name'];
                    $_SESSION['birthday_year'] = $wiersz['birthday_year'];
                    $_SESSION['birthday_month'] = $wiersz['birthday_month'];
                    $_SESSION['birthday_day'] = $wiersz['birthday_day'];
                    $_SESSION['sex'] = $wiersz['sex'];
                    $_SESSION['activated'] = $wiersz['activated'];
                    $_SESSION['id_profile'] = $wiersz['id_profile'];
                    $_SESSION['year_create'] = $wiersz['year_create'];
                    $_SESSION['month_create'] = $wiersz['month_create'];
                    $_SESSION['day_create'] = $wiersz['day_create'];
                    $_SESSION['logged_on'] = true;

                    $id = $wiersz['id'];
                    $connection->query("UPDATE users SET online = 1 WHERE id = '$id'");

                    $_SESSION['one_login'] = true;
                    header('Location: ./');
                }
                else
                {
                    $_SESSION['e_login_p'] = true;
                    header('Location: home');
                }
            }
            else
            {
                $_SESSION['e_login_e'] = true;
                header('Location: home');
            }

        }

        $connection->close();
    }
    else
    {
    }


?>