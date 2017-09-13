<?php

namespace frontend\models;

use Yii;


use vendor\codefire\cfusermgmt\models\User;

/**
 * This is the model class for table "leave".
 *
 * @property int $id
 * @property string $user_id
 * @property string $from_date
 * @property string $to_date
 * @property int $type 1=> Full day, 2=> First half, 3=> second half
 * @property string $remark
 * @property string $status
 * @property string $created_id
 * @property string $modify_id
 * @property string $created_date
 * @property string $modify_date
 */
class Leave extends \yii\db\ActiveRecord
{
    

	public $edit_leave_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'from_date', 'to_date', 'type', 'remark'], 'required'],
            [[ 'created_date', 'modify_date'], 'safe'],
            ['from_date','formDateVarification','on'=>'create'],
            ['from_date','adminUpadateLeave','on'=>'admin-update-leave'],
            [['created_id', 'modify_id'], 'string', 'max' => 20],
            [['remark'], 'string', 'max' => 200],
            [['user_id', 'status','edit_leave_id'], 'integer'],
        ];
    }
    public function formDateVarification($attribute,$param)
    {
		$start_date= $this->from_date;
		$end_date= $this->to_date;
		$userId = \Yii::$app->user->identity->id;
		$all_applied_leaves = $this->find()->where(['user_id'=>$userId])->asArray()->all(); 
		foreach($all_applied_leaves as $applied_leave)
		{
			 if( $start_date <= $applied_leave['to_date'] && $end_date >= $applied_leave['from_date'] )
			 {
				 $this->addError('from_date','you have allready applied leave for this date');
					return false;
			 }
			
		}
	}
    public function adminUpadateLeave($attribute,$param)
    {
		
		$start_date= $this->from_date;
		$end_date= $this->to_date;
		$userId	= $this->user_id;
		$all_applied_leaves = $this->find()->where(['user_id'=>$userId])->andWhere(['NOT IN','id',[$this->id]])->orderBy(['(from_date)' => SORT_DESC])->asArray()->all(); 
		foreach($all_applied_leaves as $applied_leave)
		{
			//~ if( $start_date > $applied_leave['from_date'] && $start_date < $applied_leave['to_date'] )
			//~ {
					//~ $this->addError('from_date','you have allready applied leave for this date');
					//~ return false;
			//~ }
			//~ elseif($end_date > $applied_leave['from_date'] && $end_date < $applied_leave['to_date'])
			//~ {
					//~ $this->addError('from_date','you have allready applied leave for this date');
					//~ return false;
			//~ }
			//~ else if($start_date < $applied_leave['from_date'] && $end_date > $applied_leave['to_date'])
			//~ {
					//~ $this->addError('from_date','you have allready applied leave for this date');
					//~ return false;
			//~ }
			//~ else if {
				//~ $this->addError('to_date','you have allready apply leave for this date');
				//~ return false;
			//~ }
			 if( $start_date <= $applied_leave['to_date'] && $end_date >= $applied_leave['from_date'] )
			 {
				 $this->addError('from_date','you have allready applied leave for this date');
					return false;
			 }
			
		}
	}
	
	public function scenario()
	{
		$scenarios = parent::scenarios();
		$scenarios['create'] = ['from_date'];
		$scenarios['admin-update-leave'] = ['from_date'];
		return $scenarios;
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'FIRST NAME',
            'last_name' => 'LAST NAME',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'type' => 'Type',
            'remark' => 'Remark',
            'status' => 'Status',
            'created_id' => 'Created ID',
            'modify_id' => 'Modify ID',
            'created_date' => 'Created Date',
            'modify_date' => 'Modify Date',
        ];
    }

    public function getUser() 
    {
        return $this->hasOne(user::className(), ['id'=>'user_id']);
    }

    public static function gettypes()
    {
        $typelist = array( '1' => 'Full Day', '2' => 'First Half', '3' => 'Second Half' );
        return $typelist;
    }

    public static function getstatus()
    {
        $statuslist = array ( '1' => 'Pending', '2' => 'Rejected', '3' => 'Accepted');
        return $statuslist;
    }


    public static function getLeave($id,$from_date,$to_date)
    {
        $leave = Leave::find()->andwhere(['user_id'=>$id])->andWhere(['between','from_date',$from_date,$to_date] )->orWhere(['between','to_date',$from_date,$to_date] )->asArray()->all();
        
        $arr = [];
       
       foreach($leave as $key => $value)
        {
            // $arr[$value['from_date']]=[$value['id'],$value['from_date'],$value['to_date']];
            // $arr[$value['to_date']]=[$value['id'],$value['from_date'],$value['to_date']];

            
            for($i=strtotime($value['from_date']);$i <= strtotime($value['to_date']);$i+=86400)
            {
              
               $arr[date("Y-m-d", $i)] = date("d/m/Y", $i);
            }    
        }
       
     //   print_r($arr);
     // exit;
        return $arr;
    }


}

