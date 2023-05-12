<?php
 include('./dbconfig.php') ;

   
 $targetDirectory = '../images/';//画像の保存先はimagesフォルダである。
 $fileName = basename($_FILES["file"]["name"]);//basenameメソッドでファイル名のみを取得。
 $targetFilePath = $targetDirectory.$fileName;//保存先を決定する
 $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);//拡張子を取得
 $imagedId = $_GET['id'];

 if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($fileName)){
  $arrImageTypes = ['jpg','png' ,'jpeg', 'gif', 'pdf'];//拡張子が配列の各要素と符合するか確認する
  if(in_array($fileType,$arrImageTypes)){
    $sql = "SELECT `file_name` FROM `images` WHERE id = ?";
    $stml = $pdo->prepare($sql);
    $stml->execute(array($imagedId)); 
    $getImageName = $stml->fetch();

    $deleteImage = unlink($targetDirectory . $getImageName['file_name']);
     
    if($deleteImage){
      $UploadImageForserver = move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath);
    }
    if($UploadImageForserver){
      $update = $pdo->query("UPDATE `images` SET file_name = '" . $fileName . "' WHERE id = " . $imagedId);

      header('Location: ./index.php');
      exit();
    }

  }

 }
?>