<?php include_once "base.php";
$bookings = [2, 6, 18, 19]
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
        if($(this).prop('checked')){//髓時間聽 prop 被點選
            //劃位 :

            console.log($(this).val());
            if (seats.length >=4) {
                alert("最多只能購買四張票");
                $(this).prop('checked',false) //不給打勾
            } else {
                seats.push($(this).val())
            }
            console.log(seats);

        }else{
            //取消劃位
            $(this).val();//先抓取哪一個會被取消
            seats.splice(seats.indexOf($(this).val()),1);//某個元素 在陣列中的哪個key
            console.log(seats);
        }
        $('#tickets').text(seats.length)
    })
    

    function checkout(){
        $.post("./api/order.php",{seats,
                                  movie:$('#movies option:selected').text(),
                                  date:$('#day option:selected').text(),
                                  session:$('#session option:selected').text(),
                                },
                                (res)=>{
                                    console.log(res);
        })
    }

</script>