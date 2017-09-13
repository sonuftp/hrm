<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\OhrmAttendanceRecord;
use frontend\models\Holiday;
use frontend\models\Workdays;
use frontend\models\Leave;
use vendor\codefire\cfusermgmt\models\User;
use yii\helpers\ArrayHelper;
use vendor\codefire\cfusermgmt\controllers\UserController;
use vendor\codefire\cfusermgmt\models\EmpTiming;
use vendor\codefire\cfusermgmt\models\UserDetail;
/**
 * OhrmAttendanceRecordSearch represents the model behind the search form about `frontend\models\OhrmAttendanceRecord`.
 */
class OhrmAttendanceRecordSearch extends OhrmAttendanceRecord
{
	public $from_date;
	public $to_date;
	public $year;
	public $month;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'employee_id'], 'integer'],
            [['punch_in_date', 'punch_in_note', 'punch_in_user_time',  'punch_out_note', 'punch_out_user_time', 'state'], 'safe'],
			[['employee_id','from_date','to_date'],'required'],
			[['from_date','to_date'],'safe'],
			[['month','year'],'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
     
      public function getJoiningDate($empid) {
      $joiningDate=UserDetail::find()->andWhere(['user_id'=>$empid])->asArray()->one();
      return $joiningDate;
      }
      public function getDefaultTime($param){
		$month=$this->month;
        $year=$this->year;
        if(!empty($year) && !empty($month))
        {
			$this->from_date=$year.'-'.$month.'-01';
			
			if($month == 12)
			{
				$year=$year+1;
				//$this->to_date=datedate('Y-m-01', strtotime($year.'-01-01'));
			}
			else
			{
				$to_month=$year.'-'.($month+1).'-01';
				//$this->to_date=date('Y-m-01', strtotime($to_month));
			}
		}
      $Defaulttime=self::getTime($this->employee_id,$this->from_date,$this->to_date);
      return $Defaulttime;
    }
    
    public function search($params)
    {
		$this->load($params);
        $month=$this->month;
        $year=$this->year;
        if(!empty($year) && !empty($month))
        {
			$this->from_date=$year.'-'.$month.'-01';
			
			if($month == 12)
			{
				$year=$year+1;
				$this->to_date=date('Y-m-01', strtotime($year.'-01-01'));
			}
			else
			{
				$to_month=$year.'-'.($month+1).'-01';
				$this->to_date=date('Y-m-01', strtotime($to_month));
			}
		}
		$f_date = new \DateTime($this->from_date);
		$l_date = new \DateTime($this->to_date);
		
		if (!$this->validate() || $f_date > $l_date) {
            return array();
        }
		//$panding = self::getPandingAttendance();

		$attend = self::getAttendance($this->employee_id,$this->from_date,$this->to_date);
		
		$holiday = Holiday::getHolidays($this->from_date,$this->to_date);
		
		$workday = Workdays::getWorkdays($this->from_date,$this->to_date);
		
		$leave = Leave::getLeave($this->employee_id,$this->from_date,$this->to_date);
		
		
		$arr = self::getFinalData($f_date,$l_date,$attend,$holiday,$workday,$leave);
		
		return $arr;
    }
	public function getAttendance($id,$fromdate,$todate)
	{

		
		$data = OhrmAttendanceRecord::find()->andwhere(['employee_id'=>$id])->andWhere(['between','punch_in_date',$fromdate,$todate])->andwhere(['verify'=>1])->asArray()->all();
		$arr =[];
		foreach($data as $key => $value)
		{
			$arr[$value['punch_in_date']]=[$value['id'],$value['punch_in_user_time'],$value['punch_out_user_time']];
		}	
		return $arr;	
	}
	// for panding attendance
	public function getPandingAttendance()
	{
		
		$data = OhrmAttendanceRecord::find()->andwhere(['verify'=>0])->asArray()->all();	
		return $data;
	}


	public function getFinalData($f_date,$l_date,$attend,$holiday,$workday,$leave)
	{
		$i=0;
		
		do
		{

			$date = $f_date ->format('Y-m-d');
			$arr[$i]['date'] = $date;
			$arr[$i]['day'] = $f_date ->format('D');
			$lower_day = strtolower($f_date ->format('D'));
			if(isset($attend[$date]))
			{
				$arr[$i]['id'] = $attend[$date][0];
				$arr[$i]['in_time'] = $attend[$date][1];
				$arr[$i]['out_time'] = $attend[$date][2];
				$arr[$i]['status'] = '';
				
			}
			elseif(isset($holiday[$date]))
			{
				$arr[$i]['id'] = $holiday[$date]['id'];
				$arr[$i]['in_time'] = '-';
				$arr[$i]['out_time'] = '-';
				$arr[$i]['status'] = $holiday[$date]['description'];
			}
			elseif(isset($leave[$date]))
			{
				$arr[$i]['id'] = $leave[$date][0];
				$arr[$i]['in_time'] = '-';
				$arr[$i]['out_time'] = '-';
				$arr[$i]['status'] = 'leave';
			}
			
			
			if(count($workday) != count($workday, COUNT_RECURSIVE))
			{
				
				foreach($workday as $key => $value)
				{
					
					$week = self::getWeeks($f_date ->format('Y-m-d'),$f_date ->format('l'))-1;
					
					if(in_array($f_date ->format('M'),$value) && in_array($f_date ->format('Y'),$value))
					{
						
						if($value[$lower_day] == '1,2,3,4,5' || in_array($week,explode(',',$value[$lower_day])) )
						{
							if(!isset($arr[$i]['id']))
							{
								$arr[$i]['id'] = $value['id'];
								$arr[$i]['in_time'] = '-';
								$arr[$i]['out_time'] = '-';
								$arr[$i]['status'] = 'Absent';
							}
						}
						break;
					}
					elseif(in_array($f_date ->format('Y'),$value) && in_array(null,$value))
					{
						
						if($value[$lower_day] == '1,2,3,4,5' || in_array($week,explode(',',$value[$lower_day])))
						{
							if(!isset($arr[$i]['id']))
							{
								$arr[$i]['id'] = $value['id'];
								$arr[$i]['in_time'] = '-';
								$arr[$i]['out_time'] = '-';
								$arr[$i]['status'] = 'Absent';
							}
						}
						break;
					}
					else
					{
						
						if($value[$lower_day] == '1,2,3,4,5' || in_array($week,explode(',',$value[$lower_day])))
						{
							if(!isset($arr[$i]['id']))
							{
								$arr[$i]['id'] = $value['id'];
								$arr[$i]['in_time'] = '-';
								$arr[$i]['out_time'] = '-';
								$arr[$i]['status'] = 'Absent';
							}
						}
						break;
					}
					
				}		
			}
			else
			{
				if($workday[$lower_day] == '1,2,3,4,5' || in_array($f_date ->format('w')+1,explode(',',$workday[$lower_day])))
				{
					if(!isset($arr[$i]['id']))
					{
						$arr[$i]['id'] = $workday['id'];
						$arr[$i]['in_time'] = '-';
						$arr[$i]['out_time'] = '-';
						$arr[$i]['status'] = 'Absent';
					}
				}
			}
			if(!isset($arr[$i]['id']))
			{
				$arr[$i]['id'] = 'leave' ;
				$arr[$i]['in_time'] = '-';
				$arr[$i]['out_time'] = '-';
				$arr[$i]['status'] = 'Not Working';
			}
			
			$i++;
			if($f_date != $l_date)
				$f_date->modify('+1 day');
			
		}while(date_diff($f_date,$l_date)->format("%a")!=0);
		
		return $arr;
	}
	public function getFinalDatabkp($f_date,$l_date,$attend,$holiday,$workday,$leave)
	{
		//echo"<pre>";
		//~ echo "date : ".$f_date ->format('Y-m-d');
		//~ echo "<br>Lower day : ".$f_date ->format('D');
		//~ echo "<br>L day : ".$f_date ->format('l');
		//~ echo "<br>".$cut = substr($f_date ->format('Y-m-d'), 0, 8);
		//~ echo"<pre>";
		//~ echo"----leave-----";
		//~ print_r($leave);
		//echo"----workday-----";
		//print_r($workday);
		//~ echo"----holiday-----";
		//~ print_r($holiday);
		//~ echo"----Attendance-----";
		//~ ksort($attend);
		//~ print_r($attend);
		$i=0;
		
		do
		{

			$date = $f_date ->format('Y-m-d');
			$arr[$i]['date'] = $date;
			$arr[$i]['day'] = $f_date ->format('D');
			$lower_day = strtolower($f_date ->format('D'));
			if(isset($attend[$date]))
			{
				$arr[$i]['id'] = $attend[$date][0];
				$arr[$i]['in_time'] = $attend[$date][1];
				$arr[$i]['out_time'] = $attend[$date][2];
				$arr[$i]['status'] = '';
				//~ print_r($arr);//die;
				
			}
			elseif(isset($holiday[$date]))
			{
				$arr[$i]['id'] = $holiday[$date]['id'];
				$arr[$i]['in_time'] = "0000-00-00 00:00:00";
				$arr[$i]['out_time'] = "0000-00-00 00:00:00";
				$arr[$i]['status'] = $holiday[$date]['description'];
			}
			elseif(isset($leave[$date]))
			{
				$arr[$i]['id'] = $leave[$date][0];
				$arr[$i]['in_time'] = "0000-00-00 00:00:00";
				$arr[$i]['out_time'] = "0000-00-00 00:00:00";
				$arr[$i]['status'] = 'leave';
			}
			
			
			if(count($workday) != count($workday, COUNT_RECURSIVE))
			{
				
				foreach($workday as $key => $value)
				{
					
					$week = self::getWeeks($f_date ->format('Y-m-d'),$f_date ->format('l'))-1;
					
					
					if(in_array($f_date ->format('M'),$value) && in_array($f_date ->format('Y'),$value))
					{
						
						if($value[$lower_day] == '1,2,3,4,5' || in_array($week,explode(',',$value[$lower_day])) )
						{
							if(!isset($arr[$i]['id']))
							{
								$arr[$i]['id'] = $value['id'];
								$arr[$i]['in_time'] = "0000-00-00 00:00:00";
								$arr[$i]['out_time'] = "0000-00-00 00:00:00";
								$arr[$i]['status'] = 'Absent';
							}
						}
						break;
					}
					elseif(in_array($f_date ->format('Y'),$value) && in_array(null,$value))
					{
						
						if($value[$lower_day] == '1,2,3,4,5' || in_array($week,explode(',',$value[$lower_day])))
						{
							if(!isset($arr[$i]['id']))
							{
								$arr[$i]['id'] = $value['id'];
								$arr[$i]['in_time'] = "0000-00-00 00:00:00";
								$arr[$i]['out_time'] = "0000-00-00 00:00:00";
								$arr[$i]['status'] = 'Absent';
							}
						}
						break;
					}
					else
					{
						
						if($value[$lower_day] == '1,2,3,4,5' || in_array($week,explode(',',$value[$lower_day])))
						{
							if(!isset($arr[$i]['id']))
							{
								$arr[$i]['id'] = $value['id'];
								$arr[$i]['in_time'] = "0000-00-00 00:00:00";
								$arr[$i]['out_time'] = "0000-00-00 00:00:00";
								$arr[$i]['status'] = 'Absent';
							}
						}
						break;
					}
					
				}		
			}
			else
			{
				if($workday[$lower_day] == '1,2,3,4,5' || in_array($f_date ->format('w')+1,explode(',',$workday[$lower_day])))
				{
					if(!isset($arr[$i]['id']))
					{
						$arr[$i]['id'] = $workday['id'];
						$arr[$i]['in_time'] = "0000-00-00 00:00:00";
						$arr[$i]['out_time'] = "0000-00-00 00:00:00";
						$arr[$i]['status'] = 'Absent';
					}
				}
			}
			if(!isset($arr[$i]['id']))
			{
				$arr[$i]['id'] = 'leave' ;
				$arr[$i]['in_time'] = "0000-00-00 00:00:00";
				$arr[$i]['out_time'] = "0000-00-00 00:00:00";
				$arr[$i]['status'] = 'Not Working';
			}
			
			$i++;
			if($f_date != $l_date)
				$f_date->modify('+1 day');
			
		}while(date_diff($f_date,$l_date)->format("%a")!=0);
		
		return $arr;
	}
	public static function getUserList()
	{
		$idies=user::find()->all();
					
		$listData=ArrayHelper::map($idies,'id','first_name');
		
		return $listData;
	}
	public function getWeeks($date, $rollover)
    {
        $cut = substr($date, 0, 8);
        $daylen = 86400;

        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = ($timestamp - $first) / $daylen;

        $weeks = 1;

        for ($i = 1; $i <= $elapsed; $i++)
        {
            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);

            $day = strtolower(date("l", $daytimestamp));

            if($day == strtolower($rollover))  $weeks ++;
        }

        return $weeks;
    }

    public function getTime($user_id,$start_date,$end_date)
    {
		//~ echo $start_date;
		//~ echo $end_date;
    		//$emp_time=EmpTiming::find()->orderBy('date ASC')->andWhere(['emp_id'=>$user_id])->asArray()->all();
    		$emp_time=EmpTiming::find()->orderBy('date ASC')->andWhere(['emp_id'=>$user_id])->asArray()->all();
			//~ echo"<pre>";
			//~ print_r($emp_time);die;
			return $emp_time;
			
    }
   
}


  
