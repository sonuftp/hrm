<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Holiday;
use  frontend\models\HolidaySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HollydayController implements the CRUD actions for Holiday model.
 */
class HolidayController extends Controller
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
     * Lists all Holiday models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HolidaySearch();
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
     * Displays a single Hollyday model.
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
     * Creates a new Hollyday model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Holiday();
         $model->scenario = 'create';
        
        if ($model->load(Yii::$app->request->post()) &&$model->save())
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

    /**
     * Updates an existing Hollyday model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Hollyday model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    { 
		
         $model=$this->findModel($id);
         $model ->deleted=1;
           $model ->save(); 
             
            Yii::$app->session->setFlash('success', 'Holidayhasbeen deleted');
           return $this->redirect(['index']);
    }

    /**
     * Finds the Hollyday model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hollyday the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Holiday::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
