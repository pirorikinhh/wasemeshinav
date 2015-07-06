<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<title>検索結果一覧</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62034440-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>

<!--ヘッダーここから-->
<div class="container">
<div class="common-header">
        <div class="row">
          <div>
            <span class="small">早大生のための昼食情報サイト</span>
            <a href="http://wasemeshi.com/"><h2>ワセメシなび <span class="glyphicon glyphicon-cutlery"></span></h2></a>
          </div>
        </div>
      </div>
</div>
</div>
<!--ヘッダーここまで-->

<HR>

<!--検索結果一覧ここから-->
<?php 
include('db_connect.php');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$usersearch="%$_GET[usersearch]%";
$sql = 'SELECT DISTINCT id,name FROM wasemeshi_list NATURAL JOIN menu_list WHERE name LIKE :NAME OR menu LIKE :MENU';
$stmt = $pdo->prepare($sql);
$stmt -> bindValue(':NAME', $usersearch, PDO::PARAM_STR);
$stmt -> bindValue(':MENU', $usersearch, PDO::PARAM_STR);


if (!$stmt) {
    $err = $pdo->errorInfo();
    die('SELECT 失敗：' . $err[2]);
             }





//件数表示
$stmt->execute();
$resultset = $stmt->fetchAll();
$resultNum = count($resultset);
if(0 < $resultNum){
   print $resultNum;
   print "件見つかりました";
}else{
   print "見つかりませんでした";
}


$stmt->execute();
		print '<table class="table table-striped">';
		    print '<tbody>';
foreach($stmt as $row){
print<<<EOF
		        <tr>
		            <td><span class="glyphicon glyphicon-chevron-right"></span></td>
		            <td>{$row['name']}<a href="shop_detail.php?id={$row['id']}">　詳細</a></td>
		        </tr>
EOF;
}
		    print '</tbody>';
		print '</table>';
$pdo = null;
?>
<!--検索結果一覧ここまで-->


<!--フッターここから-->
     <div id="footer">

     <ul class="breadcrumb" style="margin-bottom: 5px;">
       <li class="active"><a href="http://www.wasemeshi.com">Home</a></li>
       <li><a href="http://www.wasemeshi.com/aboutus.html">Profile</a></li>
       <li><a href="http://www.wasemeshi.com/contact.html">contact</a></li>
       <li><a href="http://www.wasemeshi.com/blog_list.php">みにれぽ</a></li>
     </ul>
<br/>
      Copyrightc <a href="http://www.wasemeshi.com">ワセメシなび</a>, All rights reserved.<br>

     </div>
<!--フッターここまで-->



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
