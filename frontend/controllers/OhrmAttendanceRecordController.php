<?php

namespace frontend\controllers;

use Yii;
use frontend\models\OhrmAttendanceRecord;
use frontend\models\OhrmAttendanceRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use frontend\models\Behavior\searchBehavior;
use vendor\codefire\cfusermgmt\models\User;
use vendor\codefire\cfusermgmt\models\UserDetail;

/**
 * OhrmAttendanceRecordController implements the CRUD actions for OhrmAttendanceRecord model.
 */

class OhrmAttendanceRecordController extends Controller
{
    /**
     * @inheritdoc
     */
	 

    /**
     * Lists all OhrmAttendanceRecord models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OhrmAttendanceRecordSearch();
		$queryparam = Yii::$app->request->queryParams;
		//echo"<pre>";
		//print_r(Yii::$app->request->queryParams);die;
        
		if (!in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))) {
            $queryparam['OhrmAttendanceRecordSearch']['employee_id'] = Yii::$app->user->getId();
        }
        $data = $searchModel->search($queryparam);
         $DefaultTime=$searchModel->getDefaultTime($queryparam);
		
		
		//print_r($data);exit;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'data' => $data,
            'DefaultTime'=>$DefaultTime,
        ]);
		
    }
	

    /**
     * Displays a single OhrmAttendanceRecord model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OhrmAttendanceRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   public function actionCreate()
    {
        $model = new OhrmAttendanceRecord();
		$model->scenario ='create';

        if ($model->load(Yii::$app->request->post())) {
			
			$model ->exfile=UploadedFile::getInstance($model,'exfile');
			if($model ->exfile){
					$model ->exfile ->saveAs('uploads/'.$model ->exfile);
					$year =	$model ->year; 
					$month= $model ->month; 
					//echo $year."-".$month;exit;
					$file = $model ->exfile;
					$objPHPExcel = \PHPExcel_IOFactory::load('uploads/'.$file);
					$sheetData = $objPHPExcel->getActiveSheet()->toArray();
					//print_r($sheetData);exit;
					$emp_filter_data=[];
					$flag = false;
					$id=0;
					$flag2=false;
					for($i=0;$i<sizeof($sheetData);$i++)
					{
						foreach($sheetData[$i] as $key => $value) 
						{
							if(isset($value))
							{
								if(trim($value) == "EMPLOYEE CODE") 
								{
									$flag = true;
								}
								elseif($flag == true)
								{
									$id=$value;
									$flag = false;
								} 
								else
								{
									if(trim($value) == "DATE") 
									{
										$flag2 = true;
									}		
									elseif($flag2 == true)
									{
										if($key == 0 && is_numeric(trim($value)))
										{
											if(strlen($sheetData[$i][$key+3])>1)
											{
												$arr2=explode(" ",$sheetData[$i][$key+3]);
												$arr3=[];
												$count=0;
												for($j=0;$j<count($arr2);$j++)
												{
													if($arr2[$j] != "")
													{
														$arr3[count($arr3)]=$arr2[$j];
														$count++;
													}
													if($count == 2)
														break;
												}
												$arr3[1]=$arr2[3];
												$emp_filter_data[$id][$value]=$arr3;
											}	
										}
									} 
								}
							}
						}
					}
					OhrmAttendanceRecord::toTable($emp_filter_data,$month,$year);
					$model -> msg = '* File Imported';
					return $this->render('create', [
                'model' => $model,
					]);
			}
            /*echo $model->month;
			echo $model->year;
			echo $model->exfile;exit;*/
        
		} else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    

    /**
     * Updates an existing OhrmAttendanceRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $punch_in_user_time= explode(' ',$model->punch_in_user_time);
        $punch_out_user_time= explode(' ',$model->punch_out_user_time);
        $model->punch_in_user_time=$punch_in_user_time[1];
        $model->punch_out_user_time=$punch_out_user_time[1];
		$model->scenario ='creater';
        if ($model->load(Yii::$app->request->post())) {
			$model->punch_in_user_time=$model->punch_in_date.' '.$model->punch_in_user_time;
			$model->punch_out_user_time=$model->punch_in_date.' '.$model->punch_out_user_time;
			if($model->save())
				return $this->redirect(['view', 'id' => $model->id]);
			else
				return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing OhrmAttendanceRecord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionReject($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['panding']);
    }

    /**
     * Finds the OhrmAttendanceRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return OhrmAttendanceRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OhrmAttendanceRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionCreater()
    {
        $model = new OhrmAttendanceRecord();
        $model->scenario ='creater';
        
		 if(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))){
			if ($model->load(Yii::$app->request->post()))
			{
				
				$model->punch_in_user_time=$model->punch_in_date.' '.$model->punch_in_user_time;
				$model->punch_out_user_time=$model->punch_in_date.' '.$model->punch_out_user_time;
				if($model->save())
					return $this->redirect(['view', 'id' => $model->id]);
				else
					return $this->render('creater', ['model' => $model, ]);
            } else {
				
                return $this->render('creater', ['model' => $model,  ]);
            }
        }else{
           $emp =Yii::$app->user->getId();
            $model->employee_id = $emp;
            $model->verify=0;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('creater', [
                    'model' => $model,
                ]);

            }
        }
    }

    public function actionPanding()
    {
        $searchModel = new OhrmAttendanceRecordSearch();
        $panding = $searchModel->getPandingAttendance();
        
    return $this->render('panding',['data'=>$panding]);
    }

    public function actionAccept($id)
    {   

       
        $model = $this->findModel($id);
        $model->verify=1;
        
        if($model->save())
            return $this->redirect(['panding']);


    } 


    public function actionJoining($id){
      $searchModel = new OhrmAttendanceRecordSearch();
      $Data=$searchModel->getJoiningDate($id);
      $joiningDate=$Data['joining_date'];
      return $joiningDate ;
    }
	////
	 public function actionReport()
    {
        $searchModel = new OhrmAttendanceRecordSearch();
		$queryparam = Yii::$app->request->queryParams;
        
		if (!in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))) {
            $queryparam['OhrmAttendanceRecordSearch']['employee_id'] = Yii::$app->user->getId();
        }
        $data = $searchModel->search($queryparam);
         $DefaultTime=$searchModel->getDefaultTime($queryparam);
		
		
		//print_r($data);exit;
        return $this->render('report', [
            'searchModel' => $searchModel,
            'data' => $data,
            'DefaultTime'=>$DefaultTime,
        ]);
		
    }

}
