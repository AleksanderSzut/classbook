<?php

    session_start();
        
    require_once "function.php";

    if((!isset($_SESSION['online'])) && ($_SESSION['online'] == false))
	{
		$result = 0;
	}

	elseif($_SESSION['activated'] == 0)
	{
		$result = 0;
	}
    else if(isset($_GET['idG']))
    {
        $idG = $_GET['idG'];
        $group = new group($idG);
        echo $result = $group->join_group();
    }
    else
    {
        view_info("Bład nie podałeś id grupy", 1);  
    }
    $result = 0;