<?php
    session_start();

    if((!isset($_SESSION['online'])) && ($_SESSION['online'] == false))
    {
        header('Location:home');session_unset();exit();
    }
    elseif($_SESSION['activated'] == 0)
    {
        header('Location:activate.php?id='.$_SESSION['id']);$_SESSION['activate_online'] = true;exit();
    }
    else
    {
       
        $id = $_SESSION['id'];
        require "function.php";
       
        $profile = new profile;
        $profile->upload($id);
        
           
        
    }
?>