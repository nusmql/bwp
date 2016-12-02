<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;




class RfqController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$data = [
    		2 => [
    			'token' => "YgsVqc7hBNQqY8AGcIzoFCRZGczDRB/kXxZccXH0Fd/zckBmENvQBHiw6Cjsvt8p9z3b6MUfGWTTa2Bc1fADYg=="
    		],
    		3 => [
    			'token' => ''
    		]
    	];

    	$user = Yii::$app->user->getIdentity();
    	$appKey = 'e5t4ouvpersva';
		$appSecret = 'PW1wGN3FR6';
		$token = $data[$user->id]['token'];
		// $jsonPath = "jsonsource/";

		$portraitUri = "http://rongcloud-web.qiniudn.com/docs_demo_rongcloud_logo.png";

		if(empty($token)) {

			include(Yii::getAlias("@vendor/server-sdk-php-master/API/rongcloud.php"));

			$RongCloud = new \RongCloud($appKey, $appSecret);
			$token = $RongCloud->user()->getToken($user->id, $user->name, $portraitUri);

		} else {
			$token = json_encode([
				'token' => $token,
				'userId' => $user->id
			]);
		}

        return $this->render('index', ['rongConfig' => $token ]);
    }

}
