<?php include_once "base.php";
if(!empty($_FILES['img']['tmp_name'])){
    move_uploaded_file($_FILES['img']['tmp_name'],"../upload/".$_FILES['img']['name']);
    $Tp->save([
        'img'=>$_FILES['img']['name'],
        'name'=>$_POST['name'],
        'sh'=>1,
        'rank'=>$Tp->max('rank')+1,
        'ani'=>rand(1,3)
    ]);
}
to("../back.php?do=tp");