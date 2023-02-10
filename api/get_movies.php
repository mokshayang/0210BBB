<?php include_once "base.php";


$day = date("Y-m-d");
$startday = date("Y-m-d", strtotime("-2 days"));
$movies = $Movie->all(['sh' => 1], " && ondate between '$startday' and '$day' ");
foreach($movies as $movie){
    echo "<option value='{$movie['id']}'  >{$movie['name']}</option>";
}
