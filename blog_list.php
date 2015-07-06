<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<meta name="keywords" content="早稲田,昼飯,ランチ">
<meta name="description" content="早大生のためのグルメ情報サイトです。">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<title>ワセメシみにれぽ</title>
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

<div class="panel-warning">
  <div class="panel-heading">
    <div class="panel-title"><span class="glyphicon glyphicon-file"></span>ワセメシみにれぽ</div>
  </div>
  <div class="panel-body">
   <ul class="list-group">


<?php
include('db_connect.php');
$sql = 'SELECT * FROM blog_list ORDER BY id DESC';
$stmt = $pdo->prepare($sql);
$stmt ->execute();


foreach($stmt as $row){
print<<<EOF
      <li class="list-group-item">
		<div class="row">
		    <div class="col-xs-3"><img src="img/shop_img/{$row['img']}.jpg" width="60" height="60"></div>
		    <div class="col-xs-9"><h4><a href="blog_article.php?id={$row['id']}">{$row['title']}</a></h4><br/>
		       <small>{$row['date']}投稿</small></div>
		</div>
      </li>
EOF;
}
?>
    </ul>
   </div>
</div>


<!--フッターここから-->
     <div id="footer">

     <ul class="breadcrumb" style="margin-bottom: 5px;">
       <li class="active"><a href="http://www.wasemeshi.com">Home</a></li>
       <li><a href="http://www.wasemeshi.com/aboutus.html">Profile</a></li>
       <li ><a href="http://www.wasemeshi.com/contact.html">Contact</a></li>
       <li ><a href="http://www.wasemeshi.com/blog_list.php">ミニレポ</a></li>

     </ul>

<!--SNSshareここから-->
     <ul class="breadcrumb" style="margin-bottom: 5px;">
       <li>share me!</li>
       <li><a href="http://twitter.com/share?url=http://wasemeshi.com/"><img src="img/twitter_icon.jpg" alt="Twitterでシェア"></a></li>
       <li><a href="http://www.facebook.com/share.php?u=http://wasemeshi.com/" onclick="window.open(this.href, 'FBwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;"><img src="img/facebook_icon.jpg" alt="Facebookでシェア"></a></li>
       <li ><span>
<script type="text/javascript" src="//media.line.me/js/line-button.js?v=20140411" ></script>
<script type="text/javascript">
new media_line_me.LineButton({"pc":false,"lang":"ja","type":"d"});
</script>
</span></li>
     </ul>
<!--SNSshareここまで-->


     <hr>
      Copyrightc <a href="http://www.wasemeshi.com">ワセメシなび</a>, All rights reserved.<br>

     </div>
<!--フッターここまで-->

<!--JSここから-->

<!--bootstrapJS-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

<!--JSここまで-->

</body>
</html>
