<style>
    #poster {
        width: 420px;
        height: 400px;
        position: relative;
    }

    .lis {
        width: 210px;
        height: 280px;
        margin: auto;
        overflow: hidden;
        text-align: center;
    }

    .pos {
        position: absolute;
        display:none;
    }

    .pos img {
        width: 100%;
        height: 260px;
    }
</style>
<div class="half" style="vertical-align:top;">
    <h2>預告片介紹</h2>
    <div class="rb tab" style="width:95%;">
        <div id="poster">
            <div class="lis">
                <?php
                $pos = $Tp->all(['sh' => 1], " order by rank");
                foreach ($pos as $po) {
                ?>
                    <div class="pos" data-ani="<?= $po['ani'] ?>">
                        <img src="upload/<?= $po['img'] ?>" alt="">
                        <div><?= $po['name'] ?></div>
                    </div>
                <?php } ?>
            </div>

            <style>
                .con {
                    width: 420px;
                    height: 110px;
                    position: absolute;
                    bottom: 0;
                    display: grid;
                    grid-template-columns: 1fr 8fr 1fr;
                    justify-items: center;
                    align-items: center;
                }

                .bt,
                .lef,
                .rig {
                    cursor: pointer;
                }

                .lef,
                .rig {
                    border-bottom: 20px solid transparent;
                    border-top: 20px solid transparent;
                }

                .rig {
                    border-left: 20px solid blue;
                }

                .lef {
                    border-right: 20px solid blue;
                }

                .bts {
                    width: 320px;
                    height: 100px;
                    display: grid;
                    grid-auto-flow: column;
                    text-align: center;
                    overflow: hidden;
                    grid-gap: 8px;
                }

                .bt {
                    width: 72px;
                    position: relative;
                }

                .bt img {
                    width: 100%;
                    height: 80px;
                }
            </style>
            <div class="con">
                <div class="lef"></div>
                <div class="bts">
                    <?php
                    $pos = $Tp->all(['sh' => 1], " order by rank");
                    foreach ($pos as $po) {
                    ?>
                        <div class="bt">
                            <img src="upload/<?= $po['img'] ?>" alt="">
                            <div><?= $po['name'] ?></div>
                        </div>
                    <?php } ?>
                </div>
                <div class="rig"></div>

            </div>
        </div>
    </div>
</div>
<script>
    let num = $('.bt').length,
        p = 0;
    $('.lef,.rig').on('click', function() {
        // console.log("ok");
        if ($(this).hasClass('lef')) {
            p = (p > 0) ? p - 1 : p;
        } else {
            p = (p < num - 4) ? p + 1 : p;
        }
        $('.bt').animate({
            right: 80 * p
        })
    })

    //big
    let now = 0;
    let pp = $('.pos');
    pp.eq(0).show();

    $('.bt').on('click',function(){
        let ttt = $(this).index();
        ani(ttt)
        console.log('ok',ttt);
    })
    
    let counter = setInterval(() => {
        ani()
    },3000);
    

    function ani(next) {
        now = $('.pos:visible').index();
        if (typeof(next) == "undefined") {
            next = (now + 1 < pp.length) ? now + 1 : 0;
        }
        let type = pp.eq(next).data('ani');
        switch (type) {
            case 1:
                pp.eq(now).fadeOut(1000, () => {
                    pp.eq(next).fadeIn(1000)
                })
                break;
            case 2:
                pp.eq(now).slideUp(1000, () => {
                    pp.eq(next).slideDown(1000)
                })
                break;
            case 3:
                pp.eq(now).hide(1000, () => {
                    pp.eq(next).show(1000)
                })
                break;
        }
    }
    $('.bts').hover(
        function() {
            clearInterval(counter);
        },
        function() {
            counter = setInterval(() => {
                ani()
            },3000)
        },
    )
</script>






<style>
    .pic {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-auto-rows: 150px;
        grid-gap: 5px;

    }

    .ii {
        display: grid;
        grid-template-columns: 2fr 3fr;
        border: 1px solid #ccc;
        border-radius: 5px;
        justify-items: center;
        align-items: center;
    }

    .btn {
        grid-column: span 2;
    }
</style>
<div class="half">
    <h2>院線片清單</h2>
    <div class="rb tab" style="width:95%;">
        <div class="pic">
            <?php
            $day = date("Y-m-d");
            $startday = date("Y-m-d", strtotime("-2 days"));
            $tt = $Movie->count(['sh' => 1], " && ondate between '$startday' and '$day' order by rank ");
            $div = 4;
            $pages = ceil($tt / $div);
            $now = $_GET['p'] ?? 1;
            $start = ($now - 1) * $div;
            $rows = $Movie->all(['sh' => 1], " && ondate between '$startday' and '$day' order by rank limit $start,$div ");
            foreach ($rows as $row) {
            ?>
                <div class="ii">
                    <div>
                        <img src="upload/<?= $row['poster'] ?>" style='width:80px;cursor:pointer' onclick="location.href='?do=intro&id=<?= $row['id'] ?>'">
                    </div>
                    <div>
                        <div><?= $row['name'] ?></div>
                        <div> <span>分級</span> <img src="icon/03C0<?= $row['level'] ?>.png" style="vertical-align:middle;"></div>
                        <div>上映日期 :</div>
                        <div><?= $row['ondate'] ?></div>
                    </div>
                    <div class="btn">
                        <button onclick="location.href='?do=intro&id=<?= $row['id'] ?>'">院線片介紹</button>
                        <button onclick="location.href='?do=order&id=<?= $row['id'] ?>'">線上訂票</button>
                    </div>
                </div>
            <?php } ?>
        </div>

        <style>
            .ct a {
                text-decoration: none;
            }
        </style>
        <div class="ct">
            <?php
            for ($i = 1; $i <= $pages; $i++) {
                $size = ($now == $i) ? "20px" : '16px';
                echo "<a href='?p=$i' style='font-size:$size'> &nbsp; $i &nbsp; </a>";
            }
            ?>
        </div>
    </div>
</div>