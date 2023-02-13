<?php include_once "base.php";
// dd($_POST);
if(!empty($_POST['seats'])){
$max_id = $Ord->max('id')+1;
$_POST['num']=date("Ymd").sprintf("%04d",$max_id);
$_POST['qt'] = count($_POST['seats']);
sort($_POST['seats']);
$_POST['seats']=serialize($_POST['seats']);
$Ord->save($_POST);
?>
<div class="ct">
<p>感謝您的訂購，您的訂單編號是 : <?=$_POST['num']?></p>
<p>電影名稱 : <?=$_POST['movie']?></p>
<p>日期 : <?=$_POST['date']?></p>
<p>場次時間 : <?=$_POST['session']?></p>
<p>座位 :
    <br>
    <?php
    $seats=unserialize($_POST['seats']);
    foreach($seats as $seat){
    echo floor(($seat/5)+1)."排".($seat%5+1)."號";
    echo "<br>";
    }
    ?>
    <br>
    <p>共 <?=$_POST['qt']?> 張電影票</p>
    <button onclick="location.href='index.php'">確認</button>
</div>



<?php }else{ ?>
<div class="ct">
    <h3>請選擇座位</h3>
    <button onclick="getBooking()">選擇座位</button>
</div>

<?php } ?>