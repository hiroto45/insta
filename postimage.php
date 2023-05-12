<?php
  include('./dbconfig.php');
  
  $targetDirectory = '../images/';//画像の保存先はimagesフォルダである。
  $fileName = basename($_FILES["file"]["name"]);//basenameメソッドでファイル名のみを取得。
  $targetFilePath = $targetDirectory.$fileName;//保存先を決定する
  $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);//拡張子を取得

  
  //画像を受け取ったらimagesフォルダに保存する
    if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($fileName)) {
        $arrImageTypes = ['jpg','png' ,'jpeg', 'gif', 'pdf'];//拡張子が配列の各要素と符合するか確認する
        if(in_array($fileType,$arrImageTypes)){
         $postImageForserver = move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath);
        }

        //DBに保存する
        try{
          if($postImageForserver){
           $stmt = $pdo->prepare("INSERT INTO `images` (`file_name`) VALUES (:file_name)");
           $stmt->bindParam(':file_name', $fileName); 
           $stmt->execute();
          }
        }catch(PDOException $e){
          echo $e->getmessage();
        }
       }
  header('Location: ./index.php');
  exit();
  //$_FILES は、HTTP POST でアップロードされたファイル情報を保持するスーパーグローバル変数です。
?>