<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<title></title>
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

<!--ヘッダーここから--!>
<div class="container">
<div class="common-header">
        <div class="row">
          <div>
            <a href="http://www.wasemeshi.com"><span class="small" style="color:black;">早大生のための昼食情報サイト</span>
            <h2 style="color:black;">ワセメシなび <span class="glyphicon glyphicon-cutlery"></span></h2></a>
          </div>
        </div>
      </div>
</div>
</div>
<!--ヘッダーここまで--!>
<br/>
<div class="panel panel-warning">
 <div class="panel-heading">
   <div classs="panel-title">
  　<a href="blog_list.php"><span class="glyphicon glyphicon-file" style="color:black;"></span><strong style="color:black;">ワセメシみにれぽ記事一覧へ→→</strong></a>
   </div>
 </div>
</div>

<?php
$id = $_REQUEST['id'];
include('db_connect.php');
$sql = 'SELECT * FROM blog_list WHERE id = ?';
$stmt = $pdo->prepare($sql);
$stmt -> bindValue(1,$id,PDO::PARAM_INT);
$stmt ->execute();
foreach($stmt as $row){}

print<<<EOF
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">{$row['title']}<br/><small>{$row['date']}</small></h3>
    </div>
    <div class="panel-body">
{$row['article']}
    </div>
</div>

EOF;
?>







<!--フッターここから-->
     <div id="footer">

     <ul class="breadcrumb" style="margin-bottom: 5px;">
       <li class="active"><a href="http://www.wasemeshi.com">Home</a></li>
       <li><a href="http://www.wasemeshi.com/aboutus.html">Profile</a></li>
       <li ><a href="http://www.wasemeshi.com/contact.html">contact</a></li>
       <li><a href="blog_list.php">ミニレポ</a></li>
     </ul>
<br/>
      Copyrightc <a href="http://www.wasemeshi.com">ワセメシなび</a>, All rights reserved.<br>

     </div>
<!--フッターここまで-->



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
