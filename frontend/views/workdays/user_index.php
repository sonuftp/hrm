<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JqueryAsset;
use frontend\models\Workdays;
use vendor\codefire\cfusermgmt\helper\PageSize;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use frontend\widgets\Alert;
use vendor\codefire\cfusermgmt\helper\SearchHelper;


/* @var $this yii\web\View */
/* @var $searchModel app\models\WorkdaysSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Workdays';
$this->params['breadcrumbs'][] = $this->title;
?>
    <style>
        .glyphicon {font-size: 16px; margin-right: 3px;}
    </style>

    <div class="container">
        <div class="radius_box">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="dasbordTitle">
                        <?php echo $this->title; ?>
					<!--    <span class="pull-right"> <?php //echo Html::a('Add New', Url::to(['user/save']), ['class' => 'btn btn-primary']);  ?></span>-->
                    </h2>
                </div>
               
            </div>
            <div class="padding5">	
                <div class="col-md-12" id="updateIndex">
					
						<div class="workdays-index">
							<?php echo $this->render('_search', ['model' => $searchModel]); ?>

								<p>     
									<?php //echo Html::a('Create Workdays', ['create'], ['class' => 'btn btn-success']) ?>
								   
								</p>
								<?php echo GridView::widget([
									'dataProvider' => $dataProvider,
								   
									//'filterModel' => $searchModel,
									'columns' => [
										['class' => 'yii\grid\SerialColumn'],
										'month',
										'year',
										 [
										  'attribute'=>'sun',
										 'value' => function($data){return Workdays::conversion($data->sun);}
											  ],
										 [
										  'attribute'=>'mon',
										 'value' => function($data){return Workdays::conversion($data->mon);}

									   
										 ],
										 [
										  'attribute'=>'tue',
										 'value' => function($data){return Workdays::conversion($data->tue);}

									   
										 ],
									   [
										  'attribute'=>'wed',
										 'value' => function($data){return Workdays::conversion($data->wed);}

									   
										 ],
										[
										  'attribute'=>'thu',
										 'value' => function($data){return Workdays::conversion($data->thu);}

									   
										 ],
										[
										  'attribute'=>'fri',
										 'value' => function($data){return Workdays::conversion($data->fri);}

									   
										 ],
										[
										  'attribute'=>'sat',
										 'value' =>function($data){return Workdays::conversion($data->sat);}

									   
										 ],
										  

									],
									 
								]); 
							 
								
								?>
							</div>       
                                </div>
                            </div>
                    
                    </div>
                </div>