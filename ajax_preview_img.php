<?php
	session_start();

	if((!isset($_SESSION['online'])) && ($_SESSION['online'] == false))
	{
		echo '
		<div class="view_info">
			<div class="delete_view_info" onclick="view_info()">
				x
			</div>
			<div class="view_info_do"><div style="color:red;">Błąd nie dodano posta spróbuj jeszcze raz<i class="icon-cancel"></i></div></div>
		</div>
		</div>';
	}
	elseif($_SESSION['activated'] == 0)
	{
		echo '
		<div class="view_info">
			<div class="delete_view_info" onclick="view_info()">
				x
			</div>
			<div class="view_info_do"><div style="color:red;">Błąd nie dodano posta spróbuj jeszcze raz<i class="icon-cancel"></i></div></div>
		</div>
		</div>';
	}
	elseif(isset($_FILES['file']))
	{  
        require "function.php";
        
        $img = new img;
        echo $img->upload();
       
	}
	else
	{
		echo "nie pyklo";
	}

?>