<?php
session_start();
if(!empty($_SESSION['menu'])){
unset ($_SESSION['menu']);}else{}
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<title>食べたいものからお店を探す</title>
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

<?php
$menu= $_GET['menu'];
?>
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          絞り込む<span class="glyphicon glyphicon-chevron-down"></span>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="panel-body">
		<div id="more_search">
		<form action="more_nav_menu.php" method="get">
		<select name="place" size="">
		<option value="">場所を選択</option>
		<option value="メトロ早稲田駅周辺">メトロ早稲田駅周辺</option>
		<option value="南門通り周辺">南門通り周辺</option>
		<option value="大隈通り周辺">大隈通り周辺</option>
		<option value="都電早稲田駅周辺">都電早稲田駅周辺</option>
		<option value="正門通り周辺">正門通り周辺</option>
		<option value="馬塲歩き">馬塲歩き</option>
		<option value="正門周辺">正門周辺</option>
		</select><br/><br/>
		<select name="gate" size="">
		<option value="">門を選択</option>
		<option value="南門">南門</option>
		<option value="正門">西門</option>
		<option value="北門">北門</option>
		<option value="正門">正門</option>
		</select><br/><br/>
		<select name="price" size="">
		<option value="">価格帯を選択</option>
		<option value="500">～500円</option>
		<option value="800">～800円</option>
		<option value="1000">～1000円</option>
		</select><br/><br/>
		<select name="scene" size="">
		<option value="">シーンを選択</option>
		<option value="for1">一人で</option>
		<option value="for4">4人で</option>
		<option value="for_date">デートで</option>
		</select><br/><br/>
		<input type="hidden" name="menu" value="<?php print $menu; ?>">
		<input type="submit" name="submit" value="検索"/><br/>
		</form>
		</div>
      </div>
    </div>
  </div>
</div>



<!--検索結果一覧ここから-->
<?php 
include('db_connect.php');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$menu = $_REQUEST['menu'];
$sql = 'SELECT * FROM wasemeshi_list WHERE id IN (SELECT id FROM menu_list WHERE menu = :MENU)';
$stmt = $pdo->prepare($sql);
$stmt -> bindParam(':MENU', $menu, PDO::PARAM_STR);

if (!$stmt) {
    $err = $pdo->errorInfo();
    die('SELECT 失敗：' . $err[2]);
             }


//件数表示
$stmt->execute();
$resultset = $stmt->fetchAll();
$resultNum = count($resultset);
if(0 < $resultNum){
   print '「';
   print $menu;
   print '」';
   print 'があるお店が';
   print $resultNum;
   print "件見つかりました。";
}else{
   print "見つかりませんでした。";
}


$stmt->execute();
		print '<table class="table table-striped">';
		    print '<tbody>';
foreach($stmt as $row){
print<<<EOF
		        <tr>
		            <td><span class="glyphicon glyphicon-chevron-right"></span></td>
		            <td><a href="shop_detail.php?id={$row['id']}">{$row['name']}</a><br/><small>{$row['comment']}</small></td>
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
