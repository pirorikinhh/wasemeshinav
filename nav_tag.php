<?php
  $title_set=array(
    "メニュー"=>array("らーめん","つけ麺","油そば","うどん","そば","カレー","パスタ","丼","定食","洋食","軽食",
    "ハンバーガー","サンドウィッチ","カフェ飯","デザート","肉","中華料理","アジア料理","韓国料理","海鮮","テイクアウト"),
    "場所"=>array("メトロ早稲田駅周辺","南門通り周辺","大隈通り周辺","正門通り周辺","都電早稲田駅周辺","西門周辺"),
    "門"=>array("南門","正門","北門","西門","文キャン正門"),
    "価格"=>array("500","800","1000"),
    "シーン"=>array("一人で気軽に入れる","4人テーブルのある","カップルで行きたい")
  );
  $title_s_set=array(
    "メニュー"=>"menu",
    "場所"=>"place",
    "門"=>"gate",
    "価格"=>"price",
    "シーン"=>"scene"
  );
  $title = $_GET['title'];
  // ex.$title="メニュー";
  $tag = $_GET['tag'];
  // ex.$tag="らーめん";
  
  //検索結果取得
  include('db_connect.php');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if($tag=="文キャン正門"){$tag="南門";}

  switch($title){
  case "門":
        $sql = 'SELECT * FROM wasemeshi_list WHERE gate LIKE :GATE';
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':GATE', $tag, PDO::PARAM_STR);
        break;
  case "メニュー":
        $sql = 'SELECT * FROM wasemeshi_list WHERE id IN (SELECT id FROM menu_list WHERE menu = :MENU)';
        $stmt = $pdo->prepare($sql);
        $stmt -> bindParam(':MENU', $tag, PDO::PARAM_STR);
        break;
  case "場所":
        $sql = 'SELECT * FROM wasemeshi_list WHERE place = :PLACE';
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(':PLACE', $tag , PDO::PARAM_STR);
        break;
  case "シーン":
        $scene = $tag;
        $sql = 'SELECT * FROM wasemeshi_list WHERE id ';
        if($scene=="一人で気軽に入れる"){
            $sql = $sql." IN (SELECT id FROM scene_list WHERE for1 = 'T')";
        }elseif($scene=="4人テーブルのある"){
            $sql = $sql." IN (SELECT id FROM scene_list WHERE for4 = 'T')";
        }elseif($scene=="カップルで行きたい"){
            $sql = $sql." IN (SELECT id FROM scene_list WHERE for_date = 'T')";
        }else{
            print "検索エラーです。もう一度ホームからやり直してください。";
            $sql = 'SELECT * FROM wasemeshi_list WHERE id = 0';
        }
        $stmt = $pdo->prepare($sql);
        break;
  case "価格":
        if($tag=="500円"){
          $price = 500;
          $price2 = 101;
        }else if($tag=="800円"){
          $price = 800;
          $price2 = 501;
        }else if($tag=="1000円"){
          $price = 1000;
          $price2 = 801;
        }else{}

        $sql = 'SELECT * FROM wasemeshi_list WHERE price BETWEEN :PRICE2 AND :PRICE';
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(':PRICE', $price , PDO::PARAM_INT);
        $stmt -> bindValue(':PRICE2', $price2, PDO::PARAM_INT);
        break;
  default:
        print "error";
        break;
  }

  if (!$stmt) {
      $err = $pdo->errorInfo();
      die('SELECT 失敗：' . $err[2]);
               }

  //件数表示
  $stmt->execute();
  $resultset = $stmt->fetchAll();
  $resultNum = count($resultset);

  $stmt->execute();
  $pdo = null;
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
              <a href="http://wasemeshi.com/"><h2>ワセメシなび <span class="glyphicon glyphicon-cutlery"></span></h2></a>
            </div>
          </div>
        </div>
  </div>
</div>


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

    <?php foreach($title_set as $key=>$value):
          if(strcmp($key,$title)==0){continue;}?>
        	<select name="<?php print $title_s_set[$key];?>" size="">
        		  <option value=""><?php print $key;?>を選択</option>
                 <?php foreach($title_set[$key] as $value2):?>
        		    <option value="<?php print $value2;?>"><?php print $value2;?></option>
                 <?php endforeach;?>
            </select><br/><br/>
    <?php endforeach;?>
        <input type="hidden" name="title" value="<?php print $title; ?>">
        <input type="hidden" name="tag" value="<?php print $tag; ?>">
    		<input type="submit" name="submit" value="検索"/><br/>
    		</form>
    		</div>
          </div>
        </div>
      </div>
    </div>

    <div> 「<?php print $_GET[tag];?>」のお店が<?php print $resultNum;?>件見つかりました </div>
    
    <table class="table table-striped">
        <tbody>
        <?php foreach($stmt as $row):?>
            <tr>
                <td><span class="glyphicon glyphicon-chevron-right"></span></td>
                <td><a href="shop_detail.php?id={$row['id']}"><?php print $row['name']; ?></a><br/><small><?php print $row['comment'];?></small></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

       <div id="footer">
           <ul class="breadcrumb" style="margin-bottom: 5px;">
             <li class="active"><a href="http://www.wasemeshi.com">Home</a></li>
             <li><a href="http://www.wasemeshi.com/aboutus.html">Profile</a></li>
             <li ><a href="http://www.wasemeshi.com/contact.html">contact</a></li>
             <li><a href="http://www.wasemeshi.com/blog_list.php">みにれぽ</a></li>
           </ul><br/>
            Copyrightc <a href="http://www.wasemeshi.com">ワセメシなび</a>, All rights reserved.<br>
       </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
  </body>
  </html>
