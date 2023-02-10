<style>
.head,.item {
    width: 95%;
    display: grid;
    grid-template-columns: 2fr 2fr 2fr 3fr;
    justify-items: center;
    align-items: center;
}
.set{
    height: 210px;
    overflow: auto;
    display: grid;
    grid-auto-rows: 100px;
}
.item{
    border-radius: 5px;
    margin: 5px auto;
    border: 1px solid #333;
}
</style>
<h3 class="ct">預告片清單</h3>
<div class="head">
    <div>預告片海報</div>
    <div>預告片片名</div>
    <div>預告片排序</div>
    <div>操作</div>
</div>
<form action="api/edit_ts.php" method="post">
<div class="set">
    <?php
    $rows = $Tp->all(" order by rank");
    foreach($rows as $k => $row){
        $prev = ($k==0)?$row['id']:$rows[$k-1]['id'];
        $next = ($k+1==count($rows))?$row['id']:$rows[$k+1]['id'];
        $sel = ($row['sh']==1)?"checked":'';
    ?>
    <div class="item">
        <div>
            <img src="upload/<?=$row['img']?>" style="width:80px">
        </div>
        <div>
            <input type="text" name="name[]" value="<?=$row['name']?>">
        </div>
        <div>
            <button type="button" onclick="sw('<?=$do?>',<?=$row['id']?>,<?=$prev?>)">往上</button>
            <button type="button" onclick="sw('<?=$do?>',<?=$row['id']?>,<?=$next?>)">往下</button>
        </div>
        <div>
            <input type="checkbox" name="sh[]" value="<?=$row['id']?>" <?=$sel?> > 顯示 
            <input type="checkbox" name="del[]" value="<?=$row['id']?>"> 刪除 &nbsp;&nbsp;
            <select name="ani[]" id="">
                <option value="1" <?=($row['ani']==1)?"selected":'';?>>淡入淡出</option>
                <option value="2" <?=($row['ani']==2)?"selected":'';?>>滑入滑出</option>
                <option value="3" <?=($row['ani']==3)?"selected":'';?>>縮放</option>
            </select>
            <input type="hidden" name="id[]" value="<?=$row['id']?>">
        </div>
    </div>
    <?php } ?>
</div>
<div class="ct">
        <input type="submit" value="確定編輯">
        <input type="reset" value="重置">
    </div>
</form>
<hr>
<div class="ct">預告片清單</div>

<form action="api/add_ts.php" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>預告片海報 : <input type="file" name="img" id=""></td>
            <td><input type="text" name="name" id=""></td>
        </tr>
    </table>
    <div class="ct">
        <input type="submit" value="新增">
        <input type="reset" value="重置">
    </div>
</form>
