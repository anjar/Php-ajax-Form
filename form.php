<?php
require_once('include/Config.php');

$valid = validate_data($_POST);


$db = new Database;


if($valid['status']) {
	
	$n_id = $db->add($_POST);
	
	if($n_id) {
		$data = $db->getOne($n_id);
		
		if(!empty($data)) {
			$json['status'] = 'ok';
				
				$data['create_date'] = $db->human_time(strtotime($data['created']));

			$json['message'] = $data;
		} else
			$json['status'] = 'empty';
		
		echo json_encode($json);
	}
	
} else {
	
}

/*
 *
 * function validate_data
 * @params data of post form
 * @return array of status & message
 *
 */
function validate_data($data = array()) {


	if(!empty($data)) {
		//validate email
		if(!empty($data['name'])) {
			//name is valid
			$err['status'] = TRUE;
			
		} else {
			//name invalid
			$err['msg']['name'] = 'Name cannot be empty';
			$err['status'] = FALSE;
		}
		
		//validate email
		if(!empty($data['email'])) {
			
			if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				//email is valid
				$err['status'] = TRUE;
			} else {
				//email not balid
				$err['msg']['email'] = 'Email is invalid';
				$err['status'] = FALSE;
			}	
		} else {
			//empty email
			$err['msg']['email'] = 'email cannot be empty';
			$err['status'] = FALSE;
		}
		
		//validate message
		if(!empty($data['message'])) {
			$_POST['message'] = strip_tags($_POST['message']);
			$err['status'] = TRUE;
		} else {
			$err['msg']['message'] = 'message cannot be empty';
			$err['status'] = FALSE;
		}
	
	} else {
		$err['msg']['name'] = 'name, email and message cannot be empty';
		$err['status'] = FALSE;
	}
	
	return $err;
}

?>