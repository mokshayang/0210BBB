<?php include_once "base.php";
$sh = $Movie->find($_POST['id']);
$sh['sh'] = ($sh['sh']+1)%2;
$Movie->save($sh);