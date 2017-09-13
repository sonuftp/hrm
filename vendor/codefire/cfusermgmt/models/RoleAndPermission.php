<?php

namespace vendor\codefire\cfusermgmt\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

use yii\data\Pagination;

/* User Role is totally different concept from User Groups, There should be no confusion regarding user roles with user groups */

class RoleAndPermission extends \yii\db\ActiveRecord{
	
	public static function tableName(){
        return '{{%auth_item}}';
    }
    
    public function rules(){
		
        return [
            [['name'], 'required', 'on'=>'saveRole'],
            ['name', 'unique', 'targetClass' => '\vendor\codefire\cfusermgmt\models\RoleAndPermission', 'message' => ROLEANDPERMISSION_NAME_UNIQUE],
            ['role_alias', 'required', 'on'=>'saveRole', 'message' => ROLEANDPERMISSION_ROLEALIAS_REQUIRED],
        ];
    }
    
    public function scenarios(){
        return [
            'saveRole'=> ['name', 'role_alias', 'allow_registration, created_at, updated_at'],
        ];
    }
    
    /**
     * To specify the behaviors to use for this model
     * @return : behaviors to use for this model 
     */
    public function behaviors() 
    {
        return [
            'timestamp'=>[
                'class' =>'yii\behaviors\TimestampBehavior',
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE=>['updated_at']
                ],
                'value'=> function (){
                        return date('Y-m-d H:i:s');
                }
            ],
        ];
    }
    
}





