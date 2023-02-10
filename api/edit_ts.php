<?php include_once "base.php";
foreach($_POST['id'] as $k => $id){
    if(isset($_POST['del']) && in_array($id,$_POST['del'])){
        $Tp->del($id);
    }else{
      $row = $Tp->find($id);//找出每一筆
      //片名 name  顯示 sh  動畫方式 ani   img不需要  rank(排序)也不需要
      //name img sh rank ani
      $row['name']=$_POST['name'][$k];
      $row['sh']=(isset($_POST['sh']) && in_array($id,$_POST['sh']))?1:0;
      $row['ani']=$_POST['ani'][$k];
      $Tp->save($row);
    }
}
to("../back.php?do=tp");