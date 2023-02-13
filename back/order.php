<h3 class="ct">訂單清單</h3>
<div>
    快速刪除 : 
    依日期 <input type="radio" name="type" value="date" >
    <input type="text" id="date">
    依電影 <input type="radio" name="type" value="movie" checked>
    <select id="movie">
        <?php
        $ms=$Ord->all(" group by movie");
        foreach($ms as $m){
            echo "<option value='{$m['movie']}'>{$m['movie']}</option>";
        }
        ?>
    </select>
    &nbsp;&nbsp;
    <button onclick="qDel()">刪除</button>
</div>
<br>
<style>
    .head,.items{
        display: grid;
        grid-template-columns: repeat(4,3fr) 2fr 3fr 2fr;
        text-align: center;
        align-items: center;
        justify-items: center;
    }
    .head{
        width: 98%;
        grid-gap: 5px;
        background: #ccc;
    }
    .heas div{
        background-color: #ccc;
    }
    .allh{
        height: 360px;
        overflow: auto;
    }
    .items{
        height: 90px;
        border: 1px solid #ccc;
        border-radius: 10px;
        margin-top: 5px;
    }
    </style>
<div class="head">
    <div>訂單標號</div>
    <div>電影名稱</div>
    <div>日期</div>
    <div>場次時間</div>
    <div>訂單數量</div>
    <div>訂購位置</div>
    <div>操作</div>
</div>
<div class="allh">
    <?php
    $ords = $Ord->all(" order by num desc");
    foreach($ords as $ord){
    ?>
    <div class="items">
        <div><?=$ord['num']?></div>
        <div><?=$ord['movie']?></div>
        <div><?=$ord['date']?></div>
        <div><?=$ord['session']?></div>
        <div><?=$ord['qt']?></div>
        <div>
            <?php
               $seats=unserialize($ord['seats']);
               foreach($seats as $seat){
               echo floor(($seat/5)+1)."排".($seat%5+1)."號";
               echo "<br>";
               }
            ?>
        </div>
        <div>
            <button onclick="del('ord',<?=$ord['id']?>)">刪除</button>
        </div>
    </div>
    <?php } ?>
</div>
<script>
    function qDel(){
        let type = $("input[name='type']:checked").val();
        let val;
        switch(type){
            case 'date':
                val = $('#date').val();
                break;
            case 'movie':
                val = $('#movie').val();
                break;
        }
        let chk = confirm(`確定要刪除 ${val} 的所有資料嗎 ?`)
        if(chk){
            $.post("api/qDel.php",{type,val},()=>{
                location.reload();
            })
        }



    }
</script>