<button onclick="location.href='?do=add_movie'">新增電影</button>
<style>
    .set {
        width: 98%;
        height: 390px;
        margin: 5px auto;
        overflow: auto;
    }

    .itit {
        width: 96%;
        margin: auto;
        display: grid;
        grid-auto-rows: 96px;
        grid-gap: 5px;
    }

    .ss {
        background: #eef;
        width: 95%;
        display: grid;
        grid-template-columns: 3fr 3fr 14fr;
        border: 1px solid #333;
        border-radius: 5px;
        align-items: center;
        justify-items: center;
    }

    .right,
    .top,
    .middle {
        display: grid;
    }

  

    .top {
        grid-template-columns: repeat(3, 1fr);
    }

    .middle {
        grid-template-columns: repeat(5, 1fr);
        grid-gap: 5px;
    }
</style>
<div class="set">
    <div class="itit">
        <?php
        $rows = $Movie->all(" order by rank");
        foreach ($rows as $k => $row) {
            $prev = ($k == 0) ? $row['id'] : $rows[$k - 1]['id'];
            $next = ($k + 1 == count($rows)) ? $row['id'] : $rows[$k + 1]['id'];
            $sel = ($row['sh'] == 1) ? "checked" : '';
        ?>
            <div class="ss">
                <div>
                    <img src="upload/<?= $row['poster'] ?>" style="width:80px">
                </div>
                <div>
                    分級 : <img src="./icon/03C0<?= $row['level'] ?>.png" style="vertical-align:middle;">
                </div>
                <div calss="right">
                    <div class="top">
                        <div>片名 : <?=$row['name']?></div>
                        <div>片長 : <?=$row['length']?></div>
                        <div>上映時間 : <?=$row['ondate']?></div>
                    </div>
                    <div class="mid">
                        <button onclick="show(<?= $row['id'] ?>)"> <?= ($row['sh'] == 1) ? '顯示' : '隱藏'; ?></button>
                        <button type="button" onclick="sw('<?= $do ?>',<?= $row['id'] ?>,<?= $prev ?>)">往上</button>
                        <button type="button" onclick="sw('<?= $do ?>',<?= $row['id'] ?>,<?= $next ?>)">往下</button>
                        <button onclick="location.href='?do=edit_movie&id=<?=$row['id']?>'">編輯電影</button>
                        <button onclick="del('<?= $do ?>',<?= $row['id'] ?>)">刪除</button>
                    </div>
                    <div>
                        <?= $row['intro'] ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>