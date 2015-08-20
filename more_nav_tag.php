<?php
//session_start();

$title_set=array(
  "メニュー"=>array("らーめん","つけ麺","油そば","うどん","そば","カレー","パスタ","丼","定食","洋食","軽食",
  "ハンバーガー","サンドウィッチ","カフェ飯","デザート","肉","中華料理","アジア料理","韓国料理","海鮮","テイクアウト"),
  "場所"=>array("メトロ早稲田駅周辺","南門通り周辺","大隈通り周辺","正門通り周辺","都電早稲田駅周辺","西門周辺"),
  "門"=>array("南門","正門","北門","西門","文キャン正門"),
  "価格"=>array("500円","800円","1000円"),
  "シーン"=>array("一人で気軽に入れる","4人テーブルのある","カップルで行きたい")
);

$title_s_set=array(
  "メニュー"=>"menu",
  "場所"=>"place",
  "門"=>"gate",
  "価格"=>"price",
  "シーン"=>"scene"
);

$title=$_POST['title'];
$tag=$_POST['tag'];
if($tag=="文キャン正門"){$tag="南門";}


?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<title>お店一覧</title>
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
		<form action="more_nav_tag.php" method="POST">

<?php
    foreach($title_set as $key=>$value){
      if(strcmp($key,$title)==0){continue ;}
    		print '<select name="';
        print $title_s_set[$key];
        print '" size=""> <option value="">';
        print $key;
        print 'を選択</option>';
        foreach($title_set[$key] as $value2){
    	    print '<option value="';
            print $value2;
            print '">';
            print $value2;
            print '</option>';
        }
    	print '</select><br/><br/>';
    }
?>
    <input type="hidden" name="title" value="<?php print $title; ?>">
    <input type="hidden" name="tag" value="<?php print $tag; ?>">
		<input type="submit" name="submit" value="検索"/><br/>
		</form>
		</div>
      </div>
    </div>
  </div>
</div>

<?php
include('db_connect.php');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function price_set($price){
        if($price=="500円"){
        $price=500;
        $price2 = 101;
        }elseif($price=="800円"){
        $price=800;
        $price2 = 501;
        }elseif($price=="1000円"){
        $price = 500;
        $price2 = 801;
        }else{}
        $price_set=[$price,$price2];
        return $price_set;
}

//MAX５項目ゲット
$menu=$_POST['menu'];
$place = $_POST['place'];
$scene= $_POST['scene'];
$gate = $_POST['gate'];
  if($gate=="文キャン正門"){$gate="南門";}
$price = $_POST['price'];
  if(!empty($price)){
    $price_set=price_set($price);
    $price=$price_set[0];
    $price2=$price_set[1];}


function add_sql($sql,$menu,$place,$scene,$gate,$price){
  if(!empty($menu)){
      $sql = $sql." AND menu  = :MENU";}else{}
  if(!empty($gate)){
      $sql = $sql." AND gate = :GATE";}else{}
  if(!empty($place)){
      $sql = $sql." AND place = :PLACE";}else{}
  if(!empty($scene)){
      if($scene == "for1"){
          $sql = $sql." AND for1 = 'T'";
      }elseif($scene == "for4"){
          $sql = $sql." AND for4 = 'T'";
      }elseif($scene == "for_date"){
          $sql = $sql." AND for_date = 'T'";
      }else{}
  }else{}
  if(!empty($price)){
      $sql = $sql." AND price BETWEEN :PRICE2 AND :PRICE";}else{}
  return $sql;
}

function set_stmt($stmt,$menu,$place,$scene,$gate,$price){
  if(!empty($menu)){
  $stmt->bindValue(':MENU', $menu, PDO::PARAM_STR);}else{}
  if(!empty($place)){
  $stmt->bindValue(':PLACE', $place, PDO::PARAM_STR);}else{}
  if(!empty($price)){
  $stmt->bindValue(':PRICE', $price, PDO::PARAM_STR);
  $stmt->bindValue(':PRICE2', $price2, PDO::PARAM_STR);}else{}
  if(!empty($gate)){
  $stmt->bindValue(':GATE', $gate , PDO::PARAM_STR);}else{}
  return $stmt;
}

switch ($title){
  case "メニュー":
      $sql = 'SELECT DISTINCT id,name,comment FROM wasemeshi_list NATURAL JOIN menu_list NATURAL JOIN scene_list WHERE menu = :MENU';
      $sql=add_sql($sql,$menu,$place,$scene,$gate,$price);
      $stmt = $pdo->prepare($sql);
      $stmt -> bindValue(':MENU', $tag , PDO::PARAM_STR);
      $stmt =set_stmt($stmt,$menu,$place,$scene,$gate,$price);
      break;
  case "門":
      $sql = 'SELECT DISTINCT id,name,comment FROM wasemeshi_list NATURAL JOIN menu_list NATURAL JOIN scene_list WHERE gate = :GATE';
      $sql=add_sql($sql,$menu,$place,$scene,$gate,$price);
      $stmt = $pdo->prepare($sql);
      $stmt -> bindValue(':GATE', $tag , PDO::PARAM_INT);
      $stmt =set_stmt($stmt,$menu,$place,$scene,$gate,$price);
      break;
  case "場所":
      $sql = 'SELECT DISTINCT id,name,comment FROM wasemeshi_list NATURAL JOIN menu_list NATURAL JOIN scene_list WHERE place = :PLACE';
      $sql=add_sql($sql,$menu,$place,$scene,$gate,$price);
      $stmt = $pdo->prepare($sql);
      $stmt -> bindValue(':PLACE', $tag , PDO::PARAM_STR);
      $stmt =set_stmt($stmt,$menu,$place,$scene,$gate,$price);
      break;
  case "価格":
      $sql = 'SELECT DISTINCT id,name,comment FROM wasemeshi_list NATURAL JOIN menu_list NATURAL JOIN scene_list WHERE price BETWEEN :PRICE2 AND :PRICE';
      $sql=add_sql($sql,$menu,$place,$scene,$gate,$price);
      $stmt = $pdo->prepare($sql);
      $price_set=price_set($tag);
      $priceX = $price_set[0];
      $priceX2 = $price_set[1];
      $stmt -> bindValue(':PRICE', $priceX , PDO::PARAM_INT);
      $stmt -> bindValue(':PRICE2', $priceX2 , PDO::PARAM_INT);
      $stmt =set_stmt($stmt,$menu,$place,$scene,$gate,$price);
      break;
  case "シーン":
      $sql = 'SELECT DISTINCT id,name,comment FROM wasemeshi_list NATURAL JOIN menu_list NATURAL JOIN scene_list WHERE ';
      $sql=add_sql($sql,$menu,$place,$scene,$gate,$price);
      $stmt = $pdo->prepare($sql);
      $stmt =set_stmt($stmt,$menu,$place,$scene,$gate,$price);
      break;
  default:
      print "error";
      break;
}


//件数表示
$stmt->execute();
$resultset = $stmt->fetchAll();
$resultNum = count($resultset);
if(0 < $resultNum){
   print '絞り込みによる「';
   print $_POST[tag];
   print '」';
   print 'があるお店が';
   print $resultNum;
   print "件見つかりました。";
}else{
   print "見つかりませんでした。";
}


$stmt->execute();
           print'<table class="table table-striped">';
	     print'<tbody>';
foreach($stmt as $row){
print<<<EOF
		        <tr>
		            <td><span class="glyphicon glyphicon-chevron-right"></span></td>
		            <td><a href="shop_detail.php?id={$row['id']}">{$row['name']}</a><br/><small>{$row['comment']}</small></td>
		        </tr>
EOF;
                       }
             print'</tbody>';
	 print'</table>';


$pdo = null;

?>
<!--検索結果一覧ここまで-->


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
