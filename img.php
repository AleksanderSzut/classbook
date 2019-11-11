<?php


if(isset($_GET['type']) && isset($_GET['id']))
{
    $id = $_GET['id'];
    $type = $_GET['type'];
    header('Content-Type: image/jpg');

    readfile('img/'.$id.'.'.$type);

}