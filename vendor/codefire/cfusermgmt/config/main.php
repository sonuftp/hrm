<?php
return [
    'layoutPath' => dirname(__DIR__) . '/views/layouts/',
    'components' => [
		'user' => [
			'identityClass' => 'vendor\codefire\cfusermgmt\models\User',
			'enableAutoLogin' => true
		],
		'authManager'=> [
			'class'=>'yii\rbac\DbManager', 
			'defaultRoles' => [] 
		],
		'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'db' => 'db',
                    'sourceLanguage' => 'en', // Developer language
                    'sourceMessageTable' => '{{%source_message}}',
                    'messageTable' => '{{%message}}',
                    'cachingDuration' => 86400,
                    'enableCaching' => false,
                ],
            ],
        ],
    	'custom' => [
            'class' => 'vendor\codefire\cfusermgmt\components\Custom'
        ],
		
    ],
    'params'=>[
        'home_base_path' => __DIR__ . '/../../../../',
    ],
    'modules'=>[
		'usermgmt' => [
			'class' => 'vendor\codefire\cfusermgmt\Module',
		],
		'gridview' => [ 'class' => '\kartik\grid\Module' ]
	],
	'aliases' => [
		'@cfusermgmt' => '@app/../vendor/codefire/cfusermgmt',
        '@cfusermgmtView' => '@vendor/codefire/cfusermgmt/views',
		"@cfusermgmtWeb" => "vendor/codefire/cfusermgmt/web",
		//'@SITE_URL' => "http://192.168.1.209/hrm/", // application web path
		'@SITE_URL' => "http://192.168.1.99/hrm/", // application web path
    ],
    'on beforeAction'=>function ($event){ 
		vendor\codefire\cfusermgmt\models\UserActivity::actionSave($event);
        //check this for captch (by gajendra)
        if(isset($event->action->actionMethod))
		{
			$permission = \vendor\codefire\cfusermgmt\models\User::CheckPermission($event);
			//var_dump($permission);
			if(Yii::$app->user->isGuest && !$permission){
				Yii::$app->session->setFlash("danger", FLASH_1041, true);
				Yii::$app->session->set("currentUrl", yii\helpers\Url::current());
				header("location:". yii\helpers\Url::home(true) . 'usermgmt/user/login');
				exit;
				//return Yii::$app->controller->redirect(['/usermgmt/user/login']);
			}elseif(!$permission){
				header("location:". yii\helpers\Url::home(true) . 'usermgmt/user/permission-denied');
				exit;
			}
		}
        $userRoleData = \vendor\codefire\cfusermgmt\models\AuthAssignment::find()->where(['user_id'=>Yii::$app->user->getId()])->one();
        if(in_array(Yii::$app->controller->module->id, array('usermgmt', 'content'))){
            $setLayout = &Yii::$app->controller->module->module;
        }else{
            $setLayout = &Yii::$app->controller->module;
        }
        if(!empty($userRoleData)) {
            $userRoleName = $userRoleData->item_name;
            if(in_array($userRoleName, array(ADMIN_ROLE_ALIAS, SUPERADMIN_ROLE_ALIAS))) { 
				$setLayout->layout = ADMIN_LAYOUT;
            }elseif(in_array($userRoleName, array(DEFAULT_ROLE_ALIAS))) { 
				$setLayout->layout = USER_LAYOUT;
            }
			else{
				$setLayout->layout = DEFAULT_LAYOUT;
       		}
        }else{
           $setLayout->layout = DEFAULT_LAYOUT;
        }
    }
];
