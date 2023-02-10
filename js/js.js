function sw(table, id1, id2) {
    $.post("api/sw.php", { table, id1, id2 }, () => {
        location.reload();
    })
}

function del(table, id) {
    let chk = confirm("確定刪除嗎 ?")
    if (chk) {
        $.post("api/del.php", { table, id }, () => {
            location.reload();
        })
    }
}

function show(id){
    $.post("api/show.php", { id }, () => {
        location.reload();
    })
}   