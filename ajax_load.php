<?php
	
	require_once('include/Config.php');
	$DB = new Database;
	
	
	$limit = isset($_GET['limit'])?$_GET['limit']:10;
	$page = isset($_GET['page'])?$_GET['page']:1;
	$offset = $limit * ($page -1 );
	
	$data = $DB->getData(array(
					'limit' => $limit,
					'offset' => $offset
				));
	
	if(!empty($data)) {
		foreach($data as $key => $item) {
			$data[$key]['create_date'] = $DB->human_time(strtotime($item['created']));
		}
		$json['status'] = 'ok';
		$json['message'] = $data;
		
	} else 
		$json['status'] = 'empty';
	echo json_encode($json);

?>