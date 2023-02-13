<?php include_once "base.php";
$movie=$Movie->find($_GET['id']);
$date = $_GET['date'];

//大寫 不補0 拿來計算用 :
$hr = date("G");



if($date == date("Y-m-d") && $hr>=14 ){
    $start=floor($hr/2)-5;
}else{
    $start = 1;
}
for($i=$start;$i<=5;$i++){
/** 
 * 1.先找出該場次的所有訂位紀錄(電影，日期，場次) 
 * $Order->all(['movie'=>$movie,....])
 * 2.算出所有訂位紀錄的座位總數(一個場次、可能有多個定位)
 * foreach($orders as ..){ $deats = $ofer[''seats'] }
 * 3.計算20-總數 = 剩餘總數  20 = $seats
*/
//value='{$Movie->session[$i]}' => 是option.val()
//$Movie->session[$i] => 是option.text()
//當有資料愈與座位的時候:
$sum = $Ord->sum('qt',['movie'=>$movie['name'],'date'=>$date,'session'=>$Movie->session[$i]]);
    echo "<option value='{$Movie->session[$i]}'>";     
    echo $Movie->session[$i];
    echo "剩餘座位". (20-$sum);//20-已被訂走的座位數
    echo "</option>";
}
