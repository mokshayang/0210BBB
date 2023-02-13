<div id="orderForm">
    <h3 class="ct">線上訂票</h3>
    <!-- div 要給寬度 才能使用 margin:auto; div的預設寬度 滿版 只能用text-align:center -->
    <table style="width:50%;margin:auto;text-align:center">
        <tr>
            <td>電影 : </td>
            <td><select name="" id="movies">


                </select>
            </td>
        </tr>
        <tr>
            <td>日期 : </td>
            <td>
                <select name="" id="day">

                </select>
            </td>
        </tr>
        <tr>
            <td>場次 : </td>
            <td>
                <select name="" id="session">

                </select>
            </td>
        </tr>
    </table>
    <br>
    <div class="ct">
  
        <button onclick="$('#orderForm,#booking').toggle(); getBooking() ">確定</button>
        <button onclick="reset()">重置</button>
    </div>

</div>
<!-- #orserFrom && #booling 互換顯示切換-->
<!-- 視覺上的確定 ，上一步傳述好像帶回之前的data -->
<div id="booking" style="display:none">

    <br>
    <!-- 上一步 順便清空  $('#booking').html('') -->
    <!-- <div class="ct">
        <button onclick="$('#orderForm,#booking').toggle(); $('#booking').html(''); ">上一步</button>
        <button>確定</button>
    </div> -->
</div>



<script>
    getMovies();

    // function reset() {
    //     $('#movies').val("");
    // }
    //電影有變動 改變日期
    $('#movies').on('change', function() {
        getDays($('#movies').val());
    })
    $('#day').on('change', function() {
        getSessions($('#movies').val(), $('#day').val());
    })

    //確定的時候 
    function getBooking() { //選好電影時確定 orderFrom.click==>booking
        $.get("./api/get_booking.php", {}, (res) => {
            $('#booking').html(res);
            $('#selectMovie').text($('#movies option:selected').text());
            $('#selectDate').text($('#day option:selected').val());
            $('#selectSession').text($('#session option:selected').val());
        })

    }


    //進入時，去抓電影跟日期 :
    function getMovies() { //ajax 去撈 電影 id 與名稱

        let params = {}; //先宣告一個物件
        //解析往解析往
        
        location.href.split("?")[1].split("&").forEach(item => {
            params[item.split("=")[0]] = item.split("=")[1]
        })
        // console.log(location.href);//http://localhost/index.php?do=order&id=74
        // console.log(location.href.split("?")[1]);//do=order&id=74
        // console.log(location.href.split("?")[1].split("&"));
        // let u_d = location.href.split("?")[1].split("&");
        // u_d.forEach((item)=>{
        //     console.log('u_d.item',item);
        // })
        console.log('params', params);
        $.get("api/get_movies.php", (movies) => {
            $('#movies').html(movies);
            if (params.id) { //如果網址有 id(別葉傳過來的) 電影為當ID的電影
                //只有#movie option 底下是抓取 url.id的 所以$(#movies 不需要)
                $(`option[value=${params.id}]`).attr("selected", true);
                // getDays($("#movie").val());
            }
            getDays($("#movies").val());
        })

    }

    function getDays(id) {
        $.get("./api/get_days.php", {
            id
        }, (days) => {
            $('#day').html(days);
            getSessions(id, $("#day").val());
        })
    }

    function getSessions(id, date) {
        $.get("./api/get_sessions.php", {
            id,
            date
        }, (sessions) => {
            $('#session').html(sessions);
        })
    }
</script>