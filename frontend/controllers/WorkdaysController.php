<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Workdays;
use frontend\models\WorkdaysSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkdaysController implements the CRUD actions for Workdays model.
 */
class WorkdaysController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Workdays models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkdaysSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		if (!in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))) {
   
            $queryparam['user_id'] = Yii::$app->user->getId();
			$render = 'user_index';
        }
        else
			$render = 'index';
		
        return $this->render($render, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Workdays model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Workdays model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Workdays();
      
     if ($model->load(Yii::$app->request->post()))
     {
		   $mkr=['sun','mon','tues','wed','thu','fri','sat'];
			      
	     for($d=0;$d<count($mkr);$d++)
	      {
		    if(!empty($model->$mkr[$d]))
             $model->$mkr[$d]=implode(",",$model->$mkr[$d]);
          }
         if( $model->save())
          {
              return $this->redirect(['view', 'id' => $model->id]);
          }
        else 
         {
            return $this->render('create', [
                'model' => $model,
            ]);
	     }
        
     }
        else 
        {
            return $this->render('create', [
                'model' => $model,
            ]);
		}
 }

   


    /**
     * Updates an existing Workdays model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $mkr=['sun','mon','tues','wed','thu','fri','sat'];
			      
	    for($d=0;$d<count($mkr);$d++)
	   {
		 if(!empty($model->$mkr[$d]))
         $model->$mkr[$d]=explode(",",$model->$mkr[$d]);
        }
        if ($model->load(Yii::$app->request->post()))
        { 
		  //$mkr=['sun','mon','tues','wed','thu','fri','sat'];
			      
		for($d=0;$d<count($mkr);$d++)
	    {
		  if(!empty($model->$mkr[$d]))
          $model->$mkr[$d]=implode(",",$model->$mkr[$d]);
         }
         if( $model->save())
         {
           return $this->redirect(['view', 'id' => $model->id]);
         }
         else {
                return $this->render('create', [
                 'model' => $model,
                             ]);
	           }
        }
     else {
            return $this->render('update', [
                'model' => $model,
            ]);
		  }
    }

    /**
     * Deletes an existing Workdays model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Workdays model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Workdays the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Workdays::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
