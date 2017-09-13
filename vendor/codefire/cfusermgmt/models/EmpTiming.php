<?php

namespace vendor\codefire\cfusermgmt\models;

use Yii;
use yii\db\ActiveRecord;
use vendor\codefire\cfusermgmt\models\UserDetail;
use frontend\models\OhrmAttendanceRecord;

class EmpTiming extends \yii\db\ActiveRecord
{
    
    public static function tableName(){
        return '{{%emp_timing}}';
    }
	 public function behaviors() {
		 return [
            'timestamp'=>[
                'class' =>'yii\behaviors\TimestampBehavior',
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>['created_date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE=>['modified_date']
                ],
                'value'=> function (){
                        return date('Y-m-d H:i:s');
                }
            ],
            [
                'class' => 'yii\behaviors\BlameableBehavior',
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>['created_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE=>['modified_by']
                ]
            ]
        ];
    }
	public function getOhrmAttendanceRecord()
    {
        return $this->hasMany(OhrmAttendanceRecord::className(), ['employee_id' => 'emp_id']);
    }
}





