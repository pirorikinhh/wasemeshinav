<?php
$dsn = 'mysql:dbname=pirorikinh_list;host=mysql478.db.sakura.ne.jp';
$user = 'pirorikinh';
$password = 'wasemeshi311';

try{
    $pdo = new PDO($dsn, $user, $password,
       array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`"
             )
                   );

    print('<br>');

    if ($pdo == null){
        print('接続に失敗しました。<br>');
                     }else{
                           }

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

?>
