<?php
 include('./dbconfig.php');

 $targetDirectory = '../images/';
 $ImagedId  = $_GET['id'];

 if(!empty($ImagedId)){
  $sql = "SELECT `file_name` FROM `images` WHERE id = " . $ImagedId;
  $stml = $pdo->prepare($sql);
  $stml->execute();

  $getImageName = $stml->fetch();

  $deleteImage = unlink($targetDirectory . $getImageName['file_name']);//unlinkで指定したパスを削除する(trueとfaleseを返す)

  if($deleteImage){
   $deleteRecord = $pdo->query("DELETE FROM `images` WHERE id = " . $ImagedId);

   if($deleteRecord){
    header('Location: ./index.php');
    exit();
   }
  
  }
 }
?>