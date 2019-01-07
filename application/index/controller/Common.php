<?php
namespace app\index\controller;
class Common{
	const MERCHANT_CONFIG_PATH = APP_PATH.'../merchant/';
	const MERCHANT = '/merchant/';

    protected $statusCode = 200;

	protected function getConfig($merchantName)
	{
		return include_once self::MERCHANT_CONFIG_PATH.$merchantName.'/config.php';
	}

	public function setStatusCode($statusCode){
        $this->statusCode = $statusCode;
        return $this;
    }

    public function message($msg,$statusCode = null){
        if($statusCode){
            $this->setStatusCode($statusCode);
        }

        if(is_array($msg)){
        	$msg = json($msg);
        }

        $message = array(
            'code' => $this->statusCode,
            'msg' => $msg
        );

        return $message;
    }

    public function success($data,$msg = '',$statusCode = null){

        $result = $this->message($msg,$statusCode);
        $result['data'] = $data;
        return $result;
    }

    public function fail($msg,$statusCode = 400){
        return $this->message($msg,$statusCode);
    }

    public function auth($msg){
        return $this->message($msg,401);
    }
	
	public function checkSuccess($info,$successMsg,$failMsg)
	{
		if($info['err_code_des'] == 'ok'){
            return $this->success($info,$successMsg);
        }else{
            return $this->fail($failMsg);
        }
	}
}

?>