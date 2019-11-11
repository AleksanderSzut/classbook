<?php

    session_start();

    if((!isset($_SESSION['online'])) || ($_SESSION['online'] == false))
	{
		echo "błąd";
	}
	elseif($_SESSION['activated'] == 0)
	{
		echo "0";	
	}
    else
    {
        
        require_once "connect.php";
        if($connected)
        {
            require_once "function.php";
            $group = new group(0);
            $view_tabele = $group->view_group();
            echo $view_tabele;
        }
    }

?>