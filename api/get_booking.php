<?php include_once "base.php";
$ords = $Ord->all(['movie'=>$_GET['movie'],'date'=>$_GET['date'],'session'=>$_GET['session']]);
//找出同場次
$bookings = [];
foreach($ords as $ord){
    $seats = unserialize($ord['seats']);
    $bookings = array_merge($bookings,$seats);
}
?>
<style>
    #block {
        width: 540px;
        height: 370px;
        background-image: url(./icon/03D04.png);
        margin: auto;
        /** 在index.php?do=orderj中 */
        /*以下可以不用  */
        padding-top: 36px;
    }

    #block,
    .null-seat,
    .booking-seat {
        background-position: center;
        background-repeat: no-repeat;
    }

    #seats {
        width: 316px;
        height: 340px;
        margin: auto;
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-gap: 2px;
        justify-items: center;
    }

    .null-seat {
        text-align: center;
        font-size: 14px;
        background-image: url(./icon/03D02.png);
        position: relative;
    }

    .null-seat input[type='checkbox'] {
        position: absolute;
        right: -5px;
        bottom: 0;
    }

    .booking-seat {

        background-image: url(./icon/03D03.png);
    }
</style>
<div id="block">
    <div id="seats">

        <?php //圖案點選

        for ($i = 0; $i < 20; $i++) {
            if (in_array($i, $bookings)) {
                echo "<div class='booking-seat'>";
            } else {
                echo "<div class='null-seat'>";
            }
            echo "<div>";
            echo (floor($i / 5) + 1) . "排" . (($i % 5) + 1) . "號";
            echo "</div>";
            if (!in_array($i, $bookings)) {
                // 如果不在點選內。開放點選
                echo "<input type='checkbox' class='chk' value='$i'>";
            }
            echo "</div>";
        }

        ?>

    </div>
</div>
<div class="infro">
    <div>你選擇的電影是 : <span id='selectMovie'></span> </div>
    <div>你選擇的時刻是 : <span id='selectDate'> </span> &nbsp; <span id='selectSession'></span> </div>
    <div>你已經勾選<span id='tickets'></span> 張，最多可以購買4張票 : </div>

    <div class="ct">
        <button onclick="$('#orderForm,#booking').toggle(); $('#booking').html(''); ">上一步</button>
        <button onclick="checkout()">確定</button>
    </div>
</div>
<script>
    //畫位
    //只能畫四個
    let seats = [];
    // $('input[type="checkbox"]').eq(0).prop('checked',true)

    //要先判斷 在push
    $('.chk').on("change", function() {
        if ($(this).prop('checked')) { //髓時間聽 prop 被點選
            //劃位 :
            //prop('checked') 用於獲取 HTML 元素的選擇狀態，
            //如果元素被選中，則返回 true，否則返回 false。
            console.log($(this).val());
            if (seats.length >= 4) {
                alert("最多只能購買四張票");
                //prop('checked', false) 用於設置 HTML 元素的選擇狀態，
                //將元素設置為未選中。
                $(this).prop('checked', false) //其他選項不給打勾
            } else {
                seats.push($(this).val())
            }
            console.log(seats);

        } else {
            //取消劃位
            $(this).val(); //先抓取哪一個會被取消
            //在 JavaScript 中，array.splice(array.indexOf(val),1) 是在刪除陣列中第一個值等於 val 的元素。
            //其中，array.indexOf(val) 用於獲取 val 在陣列中的索引位置，而後面的 1 表示要刪除的元素數量，即只刪除一個元素。
            //四張以選中，其他被選的，沒出現checkbox 所以只能從被選中選取
            //splice 有的話  刪除  沒有的話 增加 以index方式
            // seats.splice(seats.indexOf($(this).val()), 1)
            seats.splice(seats.indexOf($(this).val()), 1); 
            //一定要選取陣列中的方式，不燃 無法進入條件，會把所有的checkbox 都納入計算
            //某個元素 在陣列中的哪個key
            console.log(seats);
        }
        $('#tickets').text(seats.length)//Html 輸出  勾選 " N " 張...
    })


    function checkout() {
        $.post("./api/order.php", {
                seats,
                movie: $('#movies option:selected').text(),
                date: $('#day').val(),
                session: $('#session').val(),
            },
            (res) => {
                $('#booking').html(res);
            })
    }
</script>