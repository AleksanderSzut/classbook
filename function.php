<?php

	function text_month($month)
	{
		switch($month)
		{
			case(1):
				return "stycznia";
				break;
			case(2):
				return "lutego";
				break;
			case(3):
				return "marca";
				break;
			case(4):
				return "kwietnia";
				break;
			case(5):
				return "maja";
				break;
			case(6):
				return "czerwca";
				break;
			case(7):
				return "lipca";
				break;
			case(8):
				return "sierpnia";
				break;
			case(9):
				return "września";
				break;
			case(10):
				return "października";
				break;
			case(11):
				return "listopada";
				break;
			break;
			case(12):
				return "grudnia";
				break;
			default:
				return "błąd";
		}
	}
	function convert_time($sec)
	{
		if($sec==0)
		{
			return "błąd";
		}
		else
		{
			if($sec<60)
			{
				return $sec;
			}
			else
			{
				$minute = floor($sec/60);
				$sec = $sec-$minute*60;
				if($minute > 60)
				{
					$hour = floor($minute/60);
					$minute = $sec-$hour*60;
					if($hour>24)
					{
						$day = floor($minute/60);
						$minute = $sec-$hour*60;

						

					}
					else
					{
						return $hour.'-'.$minute.'-'.$sek;
					}
				}
				else
				{
					return '00-'.$minute.'-'.$sec;
				}
			}
		}
	}
	function view_profile($profileid)
	{
		$img1 = 'style="background-image: url(profile/'.$profileid.'.jpg)"';
		$img2 = 'style="background-image: url(style/img/no_profile.jpg)"';
		
		if($profileid != 0)
		{
			return $img1;
		}
		else
		{
			return $img2;
		}
		
	}
    function view_boxPost()
    {
        $loadingRing = loadingRing("#fff", 50);
        
        echo '<div id="view_post">'.$loadingRing.'</div>';
    }
	function view_nav()
	{
		$prof = view_profile($_SESSION['id_profile']);

		echo '<div class="nav">
				<div class="logo">
					<div class="text_logo">
						Classbook
					</div>
				</div>
				<div '.$prof.'class="square">
					<a href="profile.php" class="a_square">
						
					</a>
				</div>
				<div class="square">
					<a href="./" class="a_square2">
						<i class="icon-home"></i>
					</a>
				</div>
				<div class="square" >
					<a href="group_index" class="a_square3">
						<i class="icon-users"></i>
					</a>
				</div>
				<div class="square">
					<a href="#user" class="a_square4">
						<i class="icon-gamepad"></i>
					</a>
				</div>
				<div class="more"><div style="float:left;"><i class="icon-right-dir"></i></div> 
					<div class="more_tabele">
						<div class="list_more"><a href="" class="a_list_more"><i class="icon-tag"></i>Dodaj reklamę</a></div>
						<div class="list_more"><a href="" class="a_list_more"><i class="icon-cog"></i>Ustawienia</a></div>
						<div class="list_more"><a href="" class="a_list_more"><i class="icon-crop"></i>Stwórz stronę</a></div>
						<div class="list_more"><a href="" class="a_list_more"><i class="icon-mobile"></i>Wersja na smartfona</a></div>
						<div class="list_more"><a href="logout.php" class="a_list_more"><i class="icon-off"></i>Wyloguj się</a></div>
					</div>
				</div>
			</div>';
	}
	function view_search()
	{
        $loadingRing = loadingRing("333", 10);
		echo '<div class="topdiv">
				<div class="search">
					<div class="search_result_div" id="result_ajax_search">
						
					</div>
					<input type="text" id="q" class="i_search" autocomplete="off" onkeydown="search()" onblur="view_search_div(0)" onfocus="view_search_div(1)" />
					<input type="submit" value="szukaj" onclick="search()" class="i_search_buttom" />

					<div class="square_min" >
						<div class="ghostSquareDiv" onMouseOver="view_news()">
							<i class="icon-globe"></i>
						</div>
						<div id="number_news" class="view_number_notifications"></div>
						<div class="square_min_slide">
							<squareminslide>Powiadomienia</squareminslide>
							<div class="square_min_slide_white" id="view_news">
				                '.$loadingRing.'
							</div>
						</div>
					</div>
					<div class="square_min">
						<div class="ghostSquareDiv" onMouseOver="view_news()">
							<i class="icon-comment"></i>
						</div>
						<div id="number_news" class="view_number_notifications"></div>
						<div class="square_min_slide">
							<squareminslide>Powiadomienia</squareminslide>
							<div class="square_min_slide_white" id="view_news">
								'.$loadingRing.'
							</div>
						</div>
					</div>
				</div>
			</div>';
	}
    function view_rightDiv()
    {
        $loadingRing = loadingRing("333", 0);
        echo '
        
        <div class="rightdiv">
            <div class="friends" id="friends">
            '.$loadingRing.'
            </div>
        
        </div>
        
        ';
    }
	function loadingRing($color, $marginTop)
	{
		$style='style="';
        $style2 = '';
		if($marginTop != 0)
			$style=$style."margin-top:".$marginTop."px;";
		if((strlen($color) == 3) || (strlen($color) == 6))
		{
			$style=$style."border-color:#".$color.";";
			$style2 = 'style="border-color:#'.$color.';"';
		}
		$style = $style.'"';
			
		return '<div '.$style.' class="loadingRing">
						<div '.$style2.'class="kidsLoadingRing">
						</div>
					</div>';
	}
	function onloadBodyJs($type)
	{
		$Exceptions="";
		if(isset($_SESSION['logged_on']))
		{ 
			$Exceptions = $Exceptions."size_screen(), "; 
			unset($_SESSION['logged_on']);
		}
		switch ($type) 
		{
			case 0:
				$Exceptions = $Exceptions."view_post(1), "; 
				break;
			
			case 1:
				$Exceptions = $Exceptions."view_post(2), "; 
				break;
		}
		echo 'onload="'.$Exceptions.'amount_of_news(), online(), friends(), view_info()"';
	}
	function view_info($content,$color)//0 =red 1=green 2= normall
	{
		switch ($color)
		{
			case 0:
				$view_color="red"; 
				break;
			case 1:
				$view_color="green";
				break;
			default:
			 	$view_color=""	;
		}
		return '
		<div class="view_info">
			<div class="delete_view_info" onclick="view_info()">
				x
			</div>
			<div class="view_info_do"><div style="color:'.$view_color.';">'.$content.'</div></div>
		</div>
		</div>';
	}
	function convert_number_of_img($number)
	{
		switch ($number) 
		{
			case 1:
				return "jpg";
				break;
			case 2:
				return "jpeg";
				break;
			case 3:
				return "tiff";
				break;
			case 4:
				return "tif";
				break;
			case 5:
				return "png";
				break;
			case 6:
				return "gif";
				break;
		
		}

	}
	function convert_unix_date($time)
	{

		$int  = date("U") - $time;

		if($int >= 60)
		{
			$int = round($int / 60);
			$result = 1;
			if($int >= 60)
			{
				$int = round($int/60);
				$result = 2;
				if($int  >= 24)
				{
					$result = 3;
				}
			}
		}
		else
		{
			$result = 0;
		}

		switch ($result) 
		{
			case 0:
				return " Parę sekund temu";
				break;
			case 1:
				if($int == 1)
					return $int." Minutę temu";
				else if($int >= 2 && $int <= 4)
					return $int." Minuty temu";
				else
					return $int." Minut temu";
				break;
			case 2:
				if($int == 1)
					return $int." Godzinę temu";
				else if ($int >= 2 && $int <= 4)
					return $int." Godziny temu";
				else
					return $int." Godzin temu";
				break;
			default:
				return date("Y-m-d H:i", $time);
				break;
		}
	
	}

	
	class user
	{
		var $id_user ;
		var $email ;
		var $name;
		var $last_name;
		var $birth_y;
		var $birth_m;
		var $birh_d;
		var $sex;
		var $activated ;
		var $id_profile;


		function user($sent_id_user)
		{
			require "connect.php";

			$result = $connection->query("SELECT * FROM users WHERE id='$sent_id_user'");
			if (!$result) throw new Exception($connection->error);

			$row = $result->fetch_assoc();


			$this->id_user = $sent_id_user;
			$this->email = $row['email'];
			$this->name = $row['name'];
			$this->last_name = $row['last_name'];
			$this->birth_y = $row['birthday_year'];
			$this->birth_m = $row['birthday_month'];
			$this->birh_d = $row['birthday_day'];
			$this->sex = $row['sex'];
			$this->activated = $row['activated'];
			$this->id_profile = $row['id_profile'];

			$connection->close();
		}

		function update_data($column_name, $value)
		{
			require "connect.php";
			$id_user = $this->id_user;
			if($result = $connection->query("UPDATE users SET '$column_name'='$value' WHERE id='$id_user' "))
			{

				$this->sex ="pyklo";
			}
			else
			{
				$this->sex="nie pyko".$id_user;
			}
			$connection->close();

		}
	}	
	class news
	{
		var $id_news;
		var $id_element;
		var $id_user;
		var $view;
		var $date;
		var $type;
		var $result;

		function news($id_element_get, $type_get)
		{
			$this->id_element = $id_element_get;
			$this->type = $type_get;
		}

		function add_news($id_user)
		{
			include "connect.php";
			$id_element = $this->id_element;
			$type = $this->type;
			$date = date("U");

			if($connection->query("INSERT INTO news (id, id_user, id_item, type_news, view, date) VALUES (NULL, '$id_user', '$id_element', '$type', 0, '$date')"))
            {
                return 1;
            }
            else
            {
                return 0;
            }

			$connection->close();
		}

		function delete_news()
		{
			include "connect.php";
			$id_element = $this->id_element;
			$type = $this->type;
			if($connection->query("DELETE FROM news WHERE id_item='$id_element' AND type_news= '$type'"))
				$this->result = 0;
			else
				$this->result = 1;
			$connection->close();
		}
	}
	class friend
	{
		var $id_friend;

		function friend($id_user)
		{
			$this->$id_friend = $id_user;
		}

		function add_friend()
		{

		}

		function accepting_knowledge()
		{

		}

	}
    class group
    {
        
        private $idG;
        protected $connection;
        
        public function group($id_group)
        {
            require "connect.php";
            
            if($connected)
            {
                $result = $connection->query("SELECT * FROM group_db WHERE id = '$id_group'");             
		        if (!$result) throw new Exception($connection->error);
                $group = $result->num_rows;
                if($group == 1)
                    $this->idG = $id_group;
                
            }
            $connection->close();
        }
        
        function __construct()
        {
            require "connect.php";
            if($connected)
            {
                $this->connection = $connection;
            }
            else
            {
                exit('problem z połączeniem z bazą danych');
            }
        }
        function __destruct()
        {
            $connection = $this->connection;
            $connection->close();
        }
        private function view_one_group($id) 
        {
			$connection = $this->connection;   
            $result = $connection->query("SELECT * FROM group_db WHERE id='$id'");
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $desc = $row['description'];
            $type = $row['type'];
            $date = $row['date'];
            $bg = $row['background'];
            $img = $row['img'];
            $idU = $_SESSION['id'];
            $result = $this->should($id, $idU);
            switch ($result)
            {
                case 0:
                    $content = '<div onClick="join_group('.$id.')" class="join_gp_button">+</div>';
                    break;
                case 1:
                    $content = '<div class="join_gp_button"><i class="icon-help"></i></div>';
                    break;
                case 3:
                    $content = '<div class="join_gp_button">moderator</div>';
                    break;
                case 4:
                    $content = 'Admin';
                    break;
            }
            return '<div class="table_group">
                '.$content.'
                <section class="table_group_box_img">
                    <img src="background/'.$bg.'.jpg" class="table_group_img" alt="zjęcie '.$name.'"/>
                </section>
                <section class="table_grop_foot">
                    <header class="table_group_header">'.$name.'</header>
                    <article class="table_group_desc"><p>Typ grupy: Klasa.</p><p> Opis: '.$desc.'</p></article>
                </section>
            </div>';
                
            
		}
        public function view_group()
        {
            require "connect.php";
            
            if($connected)
            {
                $result = $connection->query("SELECT * FROM group_db ORDER BY id DESC");          
		        if (!$result) throw new Exception($connection->error);
                $howmany = $result->num_rows;
                $row = $result->fetch_assoc();
                $id = $row['id'];
                for($i = 1; $i <= $howmany; $i++)
                {
                    echo $view = $this->view_one_group($id);  
                }
            }
        }
        function should($id_group, $id_user)
        {
            $connection = $this->connection;
            $result = $connection->query("SELECT * FROM group_users WHERE id_group = '$id_group' and id_user = '$id_user'");
            if (!$result) throw new Exception($connection->error);
            
            $howMany = $result->num_rows;
            if($howMany > 0)
            {
                $row = $result->fetch_assoc();
                $type = $row['type'];
                return $type+1;
            }
            else
            {
                return 0;
            }
        }
        private function whoIsWho()
        {
            $idG = $this->idG;
            $connection = $this->connection;
            
        }
        function add_news()
        {
            
        }
        function join_group()
        {
            $idG = $this->idG;
            $idU = $_SESSION['id'];
            $date = date("U");
            $connection = $this->connection;
            $should = $this->should($idG, $idU);
            if(!$should)
            {
                if($result = $connection->query("INSERT INTO group_users(id, id_user, id_group, type, date) VALUES (NULL, '$idU', '$idG', 0, '$date')"))
                {
                    $news = new news($idAdmin);

                    $idUserGr = $result->fetch_assoc();
                    $news = new news($idG, 3);
                    $result = $news->add_news($id);
                    if($result)
                       return view_info("Wysłano prośby o dołączenie do grupy", 1); 


                }
                else
                {
                    return view_info("Nie wysłano prośby o dołączenie do grupy",0);
                }
            }
            else
            {
                return view_info("Nie wysłano prośby o dołączenie do grupy",0);
            }
            

		/*function add_news($id_user)
		{
			include "connect.php";
			$id_element = $this->id_element;
			$type = $this->type;
			$date = date("U");

			if($connection->query("INSERT INTO news (id, id_user, id_item, type_news, view, date) VALUES (NULL, '$id_user', '$id_element', '$type', 0, '$date')"))

			$connection->close();
		}
            }
                
        }*/
        }
    }

    abstract class uploadFile
    {
        protected $file, $exten, $dir;
        public $errno, $errDesc;

        public function __construct($file, $dir)
        {
            $this->file = $file;
            $this->dir = $dir;

            if ($file['error'] > 0) {
                $this->errno = $file['error'];

                switch ($file['error']) {

                    // jest większy niż domyślny maksymalny rozmiar,
                    // podany w pliku konfiguracyjnym
                    case 1:
                        {
                            $this->errDesc = 'Rozmiar pliku jest zbyt duży.';
                            break;
                        }

                    // jest większy niż wartość pola formularza
                    // MAX_FILE_SIZE
                    case 2:
                        {
                            $this->errDesc = 'Rozmiar pliku jest zbyt duży.';
                            break;
                        }

                    // plik nie został wysłany w całości
                    case 3:
                        {
                            $this->errDesc = 'Plik wysłany tylko częściowo.';
                            break;
                        }

                    // plik nie został wysłany
                    case 4:
                        {
                            $this->errDesc = 'Nie wysłano żadnego pliku.';
                            break;
                        }

                    // pozostałe błędy
                    default:
                        {
                            $this->errDesc = 'Wystąpił błąd podczas wysyłania.';
                            break;
                        }
                }
                return false;
            }

            return true;


        }
        protected function getType()
        {
            return $this->file['type'];
        }
        protected function getExten()
        {
            $file = $this->file;

            $fileName = explode(".", $file['name']);
            $extension = $fileName[count($fileName) - 1];
            $this->exten = $extension;
        }
        function saveFile($name)
        {

            $file = $this->file;

            $extension = $this->exten;

            $location = '../'.$this->dir.'/' . $name . '.' . $extension;

            if (is_uploaded_file($file['tmp_name'])) {
                if (!move_uploaded_file($file['tmp_name'], $location)) {
                    echo 'problem: Nie udało się skopiować pliku do katalogu.';
                    return false;
                }
            } else {
                echo 'problem: Możliwy atak podczas przesyłania pliku.';
                echo 'Plik nie został zapisany.';
                return false;
            }
            return true;
        }
    }





    function createUrl($text_url)
    {
        $text_url = preg_replace('|(?<!href=")(https?://[A-Za-z0-9+\-=._/*(),@\'$:;&!?]+)|','<a href="$1"  target="_blank">$1</a>',$text_url);
        return $text_url;
    }
    function send_email_activation($email, $key, $id)
    {
        $naglowki = "Reply-to: aktywacja@classbook.pl ".PHP_EOL;
        $naglowki .= "From: moj@mail.pl ".PHP_EOL;
        $naglowki .= "MIME-Version: 1.0".PHP_EOL;
        $naglowki .= "Content-type: text/html;".PHP_EOL; 

        //Wiadomość najczęściej jest generowana przed wywołaniem funkcji
        $wiadomosc = '<html>
                        <head>
                            <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
                            <title>Witamy na Classbook</title>
                        </head>
                        <body style="background: #efefef; font-family: Arial, Verdana; margin:0;">
                         
                            <div style=""><a href="classbook.pl/activate.php?id='.$id.'&&keys='.$key.' "><button>aktywuj !</button></a></div>
                        </body>
                    </html>';


        if(mail($email, 'Witaj', $wiadomosc, $naglowki))
        {
            echo 'Wiadomość została wysłana';
        }
    }
?>