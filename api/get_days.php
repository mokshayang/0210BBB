<?php include_once "base.php";


$movie = $Movie->find($_GET['id']);
$ondate = $movie['ondate'];


$ondete = $movie['ondate'];
$today = strtotime(date("Y-m-d"));


$duration = 3 - (( $today - strtotime($ondate))/(60*60*24));

//echo $duration; //剩下天數
for($i=0; $i < $duration; $i++){
    $date = date("Y-m-d",strtotime("+$i days"));
    $str = date("m月d日 l",strtotime("+$i days"));
    echo "<option value='$date'>";
    echo $str;
    echo "</option>";
}


