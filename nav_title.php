<?php
$title_set=array(
  "メニュー"=>array("らーめん","つけ麺","油そば","うどん","そば","カレー","パスタ","丼","定食","洋食","軽食",
  "ハンバーガー","サンドウィッチ","カフェ飯","デザート","肉","中華料理","アジア料理","韓国料理","海鮮","テイクアウト"),
  "場所"=>array("メトロ早稲田駅周辺","南門通り周辺","大隈通り周辺","正門通り周辺","都電早稲田駅周辺","西門周辺"),
  "門"=>array("南門","正門","北門","西門","文キャン正門"),
  "価格"=>array("500円","800円","1000円"),
  "シーン"=>array("一人で気軽に入れる","4人テーブルのある","カップルで行きたい"),
);
/*
$title_s_set=array(
  "メニュー"=>"menu",
  "場所"=>"place",
  "門"=>"gate",
  "価格"=>"plice",
  "シーン"=>"scene",
)
*/

$title=$_GET["title"];
//$title_s=$title_s_set[$title];
 ?>


<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<title><?php print $title; ?>からお店を探す</title>
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


<div class="container">
  <div class="common-header">
          <div class="row">
            <div>
              <span class="small">早大生のための昼食情報サイト</span>
              <h2>ワセメシなび <span class="glyphicon glyphicon-cutlery"></span></h2>
            </div>
          </div>
        </div>
  </div>
</div>
<HR>
<div class="list-group">
 <div class="list-title">
 <h2 class="small">　<?php print $title; ?>からお店を探す</h2>
 </div>
<?php
    foreach($title_set[$title] as $value){
    print '
    <div class="list-group-item">
        <div class="row-action-primary">
            <i class="mdi-file-folder"></i>
        </div>
        <div class="row-content">
            <div class="action-secondary"><i class="mdi-material-info"></i></div>
            <h4 class="list-group-item-heading"><span class="glyphicon glyphicon-chevron-right"></span><a href="nav_tag.php?';
    print "title";
    print '=';
    print $title;
    print "&";
    print "tag";
    print '=';
    print $value;
    print '">';
        //ex. nav_shop.php?title=メニュー&tag=らーめん

    print $value;

    print
    'のお店を探す</a></h4>
        </div>
    </div>
    <div class="list-group-separator"></div>';
  }
?>


<!--フッターここから-->
     <div id="footer">

     <ul class="breadcrumb" style="margin-bottom: 5px;">
       <li class="active"><a href="http://www.wasemeshi.com">Home</a></li>
       <li><a href="http://www.wasemeshi.com/aboutus.html">Profile</a></li>
       <li ><a href="http://www.wasemeshi.com/contact.html">contact</a></li>
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
