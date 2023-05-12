<?php
include('./dbconfig.php');

$uri = $_SERVER['REQUEST_URI'];//サーバーへのリクエストuriを取得
if(strpos($uri,'imageDetail.php') !== false){
  $imageId = $_GET['id'];
  $sql = "SELECT * FROM images WHERE id = " . $imageId;
  
  $stml = $pdo->prepare($sql);
  $stml->execute();
  $data['image'] = $stml->fetch();
}else{
  $sql = "SELECT * FROM images ORDER BY `date` DESC ";//imageカラムを降順で取得する。
  $stml = $pdo->query($sql);
  $stml->execute();
  $data = $stml->fetchAll();//取得した行を配列に格納する
  return $data;  
}

//$_GETは、HTTPリクエストのクエリパラメータを取得するためのスーパーグローバル変数です。クエリパラメータは、URLの末尾に「?」を付けて、パラメータ名と値のセットをキーとバリューの形式で記述したもので、複数のパラメータは「&」で区切ります。
//例えば、以下のようなURLがあるとします。
//http://example.com/search.php?q=keyword&page=2
//この場合、$_GET['q']は「keyword」、$_GET['page']は「2」という値を持ちます。$_GETは主に、Webアプリケーションの検索フォームやページネーションなどで利用され、クエリパラメータを受け取って処理を行うことができます。ただし、入力値の検証やエスケープ処理を行う必要があります。


?>