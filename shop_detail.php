<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <title>店舗詳細</title>
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/hammer.min.js"></script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-62034440-1', 'auto');
      ga('send', 'pageview');
    </script>
    <style>
        .countbtn {
             width: 100%;
             padding: 7px;
             border-radius: 5px;
             box-shadow: 0 4px 0 #0088cc;
             color: #fff;
             background: #00aaff;
             cursor: pointer;
             opacity: 1.0;
             text-align: center;
          }
     </style>
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

<?php

include('db_connect.php');

try {
if (!isset($_REQUEST['id']) || !is_string($id = $_REQUEST['id'])) { throw new RuntimeException('コードを指定 してください'); }

            $id=$_REQUEST['id'];

			//infosql
			$sql = 'select * from wasemeshi_list where id=?';
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			foreach ($stmt as $info){}

			//menussql
			$sql = 'select * from menu_list where id=?';
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			$menus = array();
			foreach ($stmt as $row){
				array_push($menus,$row['menu']);
			}

			//imgssql
			$sql = 'select * from img_list where id=?';
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			$imgs = array();
			foreach ($stmt as $row){
				array_push($imgs,$row['img']);
			}

} catch (Exception $e) {
die($e->getMessage());
}


//ヒアドキュメントここから
print<<<EOM
<div class="container">
    <div class="row">
    	<div class="col-xs-12">
			<div class="col-xs-12">
				<div class="thumbnail" >
					<h4 class="text-center"><span class="label label-info">{$info['place']}</span></h4>
                      <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="0">
EOM;
			    if(!empty($imgs)){print'<ol class="carousel-indicators">';
			        print'<li data-target="#carousel" data-slide-to="0" class="active"></li>';
			        if(!empty($imgs[1])){print'<li data-target="#carousel" data-slide-to="1"></li>';}
			        if(!empty($imgs[2])){print'<li data-target="#carousel" data-slide-to="2"></li>';}
		           print'</ol>';
                   }else{}
			     print'<div class="carousel-inner">';
                                 if(!empty($imgs)){
                                         print '<div class="item active">';
					 print '<img src="img/shop_img/';
					 print ($imgs[0]);
                                         print '.jpg" class="img-responsive">';
                                         print '</div>';
                            	if(!empty($imgs[1])){
                                         print '<div class="item">';
					 print '<img src="img/shop_img/';
					 print ($imgs[1]);
                                         print '.jpg" class="img-responsive">';
                                         print '</div>';
				}
				if(!empty($imgs[2])){
                                         print '<div class="item">';
					 print'<img src="img/shop_img/';
					 print ($imgs[2]);
                                         print '.jpg" class="img-responsive">';
                                         print '</div>';
                                }
				}else{ print '<img src="http://placehold.it/650x450&text=NO IMAGE" class="img-responsive">';}
print<<<EOM
                                            </div>

					    <a class="left carousel-control" href="#carousel-example" role="button" data-slide="prev">
					        <span class="glyphicon glyphicon-chevron-left"></span>
					    </a>
					    <a class="right carousel-control" href="#carousel-example" role="button" data-slide="next">
					        <span class="glyphicon glyphicon-chevron-right"></span>
					    </a>
                       </div>

					<div class="caption">
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<h3 class="text-center">{$info['name']}</h3>
							</div>
						</div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div type="button" class="countbtn"><span class="glyphicon glyphicon-heart"></span><div class="count"></div></div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<h5 class="text-center">{$info['comment']}</h5>
							</div>
						</div>
							<table class="table table-striped">
							 <tbody>
							   <tr>
							      <td width="35%">メニュー</td>
                                                                 <td width="65%">
EOM;

                                                    foreach($menus as $menu){
							 print $menu;
                                                         print '<br/>';}
print<<<EOM
                                                                 </td>
							   </tr>
							   <tr>
							      <td width="35%">門</td>
							      <td width="65%">{$info[gate]}</td>
							   </tr>
							   <tr>
							      <td width="35%">価格帯</td>
                  					      <td width="65%">{$info[price]}円～</td>
							   </tr>
							 </tbody>
							</table>
						<p> </p>
                                <div class="container">
                                      <p>{$info['address']}</p>
                                      <iframe width="100%" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?q={$info['address']}&z=16&output=embed&iwloc=J&t=m"></iframe></div>
				</div>
			</div>
        </div>
	</div>
</div>

EOM;
?>

     <div id="footer">
             <ul class="breadcrumb" style="margin-bottom: 5px;">
               <li class="active"><a href="http://www.wasemeshi.com">Home</a></li>
               <li><a href="http://www.wasemeshi.com/aboutus.html">Profile</a></li>
               <li><a href="http://www.wasemeshi.com/contact.html">contact</a></li>
               <li><a href="http://www.wasemeshi.com/blog_list.php">みにれぽ</a></li>
             </ul><br/>
              Copyrightc <a href="http://www.wasemeshi.com">ワセメシなび</a>, All rights reserved.<br>
     </div>

    <script>//スライドショー
             $(function()
              {
              var carousel = $('#carousel');
              var hammer = new Hammer(carousel[0]);
              hammer.on('swipeleft', function(){ carousel.carousel('next'); });
              hammer.on('swiperight', function(){ carousel.carousel('prev'); });
              });
    </script>

    <script>//ajax通信
            var id = <?php print $id; ?>;
            $(document).ready(function() {
                 ajaxstart('ready',id);
            });

            $(function(){
                jQuery(".countbtn").click(function() {
                        ajaxstart('countup',id);
                        console.log('countup'); 
                });
            });


            function ajaxstart(act,id){
                    $.ajax({
                        type: "POST",
                        url: "goodcount.php?action="+act+"&id="+id
                        })
                        .done(function(data){
                            if(data.length > 0){
                                $(".count").text("→ "+data);
                            }
                        });
            }
    </script>

</body>
</html>
