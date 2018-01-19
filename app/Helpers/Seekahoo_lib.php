<?php

namespace App\Helpers;

use App\Model\Web_service_log;

class Seekahoo_lib 
{
	var $CI;
	function __construct() {
		$this->CI =& get_instance();
	}
  	
  	public static function demo()
  	{
  		return "demo check";
  	}

	public static function return_status($msg, $serviceName, $data, $ipJson) 
	{
		$status['status_code'] = '200';
		if ($msg != 'success') 
		{
			$status['status_code'] = '100';
		}
		$status['status'] = $msg;
		$status['service_name'] = $serviceName;
		$status['data'] = $data;

		$opJson = json_encode($status['data']);
		$data = array(
			'service_name' => $status['service_name'],
			'status' => $status['status'],
			'request' => $ipJson,
			'response' => $opJson,
		);

		$Web_service_log           = new Web_service_log();
		$Web_service_log->service_name     =  $status['service_name'];
		$Web_service_log->status = $status['status'];
		$Web_service_log->request = $ipJson;
		$Web_service_log->response = $opJson;
		$Web_service_log->save();

		//logs($status, $ipJson);
		return response()->json($status);
	}

	public static function logs($status, $ipJson) 
	{
		$opJson = json_encode($status['data']);
		$data = array(
			'service_name' => $status['service_name'],
			'status' => $status['status'],
			'request' => $ipJson,
			'response' => $opJson,
			'log_created_date' => date('Y-m-d H:i:s')
		);
		$this->CI->db->insert('web_service_logs', $data);
	}
	
	public static function format_json($data = array())
	{
		header('Content-type: application/json');
		return json_encode($data);
	}
	

}