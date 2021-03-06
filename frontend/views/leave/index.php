<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\LeaveSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leaves';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

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
					    <!-- <span class="pull-right"> <?php echo Html::a('Add New', Url::to(['user/save']), ['class' => 'btn btn-primary']);  ?></span> -->
                    </h2>
                </div>
               
            </div>
            <div class="padding5">	
                <div class="col-md-12" id="updateIndex">
					
											<div class="leave-index">
						<div id="ajaxCrudDatatable">
							<?php // echo $this->render('_search', ['model' => $searchModel]); ?>
						
							<?=GridView::widget([
								'id'=>'crud-datatable',
								'dataProvider' => $dataProvider,
								'filterModel' => $searchModel,
								'pjax'=>true,
								'columns' => require(__DIR__.'/_columns.php'),
								'toolbar'=> [
									['content'=>
										Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
										['role'=>'modal-remote','title'=> 'Create new Leaves','class'=>'btn btn-default']).
										Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
										['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
										//.
										//'{toggleData}'.
										'{export}'
									],
									
								],          
								'striped' => true,
								'condensed' => true,
								'responsive' => true,          
								'panel' => [
									'type' => 'primary', 
									'heading' => '<i class="glyphicon glyphicon-list"></i> Leaves listing',
									'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
									// 'after'=>BulkButtonWidget::widget([
									//             'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
									//                 ["bulkdelete"] ,
									//                 [
									//                     "class"=>"btn btn-danger btn-xs",
									//                     'role'=>'modal-remote-bulk',
									//                     'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
									//                     'data-request-method'=>'post',
									//                     'data-confirm-title'=>'Are you sure?',
									//                     'data-confirm-message'=>'Are you sure want to delete this item'
									//                 ]),
									//         ]).                        
											'<div class="clearfix"></div>',
								]
							])?>
						</div>
					</div>
					<?php Modal::begin([
						"id"=>"ajaxCrudModal",
						"footer"=>"",// always need it for jquery plugin
					])?>
					<?php Modal::end(); ?>      
                                </div>
                            </div>
                    
                    </div>
                </div>
