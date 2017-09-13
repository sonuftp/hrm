<?php

namespace frontend\models;

use Yii;
use vendor\codefire\cfusermgmt\models\User;
use vendor\codefire\cfusermgmt\models\EmpTiming;

/**
 * This is the model class for table "ohrm_attendance_record".
 *
 * @property string $id
 * @property string $employee_id
 * @property string $punch_in_utc_time
 * @property string $punch_in_note
 * @property string $punch_in_time_offset
 * @property string $punch_in_user_time
 * @property string $punch_out_utc_time
 * @property string $punch_out_note
 * @property string $punch_out_time_offset
 * @property string $punch_out_user_time
 * @property string $state
 */

class OhrmAttendanceRecord extends \yii\db\ActiveRecord
{
	 public $exfile;
	 public $year;
	 public $month;
	 public $msg;
	 public $date;
	 public $name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ohrm_attendance_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['exfile','year','month'],'required', 'on'=>'create'],
			[['year','month'],'required'],
            [['year','month'],'string'],
            [['employee_id','punch_in_date','punch_in_user_time','punch_out_user_time'],'required', 'on'=>['creater','update']],
            ['punch_in_date', 'unique', 'targetAttribute' => ['punch_in_date', 'employee_id']],
            [['punch_in_date','punch_in_user_time','punch_out_user_time'],'safe'],
            //[['punch_in_note','punch_out_note'],'safe'],
            [['verify'],'integer'],
            [['state'],'string'],
            [['exfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, csv, xlsx'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [];
    }
   public function scenarios()
    {
		$scenarios = parent::scenarios();
        $scenarios['create'] = ['exfile','year','month'];//
        $scenarios['creater'] = ['employee_id','punch_in_date','punch_in_user_time','punch_out_user_time'];//
        return $scenarios;
	}
	
	public static function toTable($arr,$mon,$yr)
	{
		$count=0;
		foreach($arr as $attendance_id => $emp_data) 
		{
			foreach($emp_data as $emp_date => $emp_time)
			{
				if($emp_date<10)
					$date = $yr."-".$mon."-0".$emp_date;
				else
					$date = $yr."-".$mon."-0".$emp_date;
				$indate = $date." ".$emp_time[0];
				$outdate = $date." ".$emp_time[1];
				$model = User::find()->where(['attendance_id' => $attendance_id])->asArray()->one();
				if(!empty($model))
				{
					$emp_id = $model['id'];
					//echo $emp_id;exit;
					$model = OhrmAttendanceRecord::find()->where(['employee_id' => $emp_id,'punch_in_date' => $date])->all();
					//print_r($model);exit;
					if(empty($model))
					{
						$model = new OhrmAttendanceRecord();
						$model -> employee_id = $emp_id;
						$model -> punch_in_date = $date;
						$model -> punch_in_note = 'In';
						$model -> punch_in_user_time = $indate;
						$model -> punch_out_note = 'Out';
						$model -> punch_out_user_time = $outdate;
						$model -> state = 'PUNCHED OUT';
						if($model -> save(false))
							$count++;
					}
				}
			}
		}
	}
	public static function findMonthsOptions()
    {
        return [
            '01'=>'January',
			'02'=>'February',
			'03'=>'March',
			'04'=>'April',
			'05'=>'May',
			'06'=>'June',
			'07'=>'July',
			'08'=>'August',
			'09'=>'September',
			'10'=>'October',
			'11'=>'November',
			'12'=>'December'        
			];
    }
	
	public static function findYearsOptions()
    {
        $arr =[];
		for($i=2016;$i<=date("Y");$i++)
			$arr[$i]=$i;
		return $arr;
    }
	public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'employee_id']);
    }
	public function getEmpTiming()
    {
        return $this->hasMany(EmpTiming::className(), ['emp_id' => 'employee_id']);
    }
}
