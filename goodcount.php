<?php

	$id=$_GET['id'];

	$dataname='json/goodcount.json';
	$handle = fopen($dataname, 'r');
	$json = file_get_contents($dataname);
	$data_set = json_decode( $json , true );
	fclose($handle);


	$action="";
	if(isset($_GET['action'])){
		$action = $_GET['action'];
	}

	switch($action){
		case "ready":
            $i=0;
			foreach($data_set as $value){
		        if($value['id'] == $id){
					$cnt=$value['cnt'];
                    $match_i=$i;
				}else{}
                $i++;
		    }
            if(!isset($match_i)){$cnt=1;}else{}
			print $cnt;
			break;
		case "countup":
			$i=0;
			foreach($data_set as $value){
				if($value['id'] == $id){
					$value['cnt']+=1;
					$cnt=$value['cnt'];
					$match_i=$i;
				}else{}
				$i++;
			}
			print $cnt;
			$added=array(
				'id'=>$id,
				'cnt'=>$cnt
			);
			if(isset($match_i)){
				$data_set[$match_i]=$added;
			}else{
				array_push($data_set,$added);
			}

			$dataname='json/goodcount.json';
			$handle = fopen($dataname, 'w');
			fwrite($handle, json_encode($data_set));
			fclose($handle);
			break;
		default :
			break;
}

 ?>
