<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HollydaySearcha */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Holidays';
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
                    </h2>
                </div>
            </div>
			<?php echo $this->render('_search', ['model' => $searchModel]); ?>
            <div class="padding5">	
                <div class="col-md-12" id="updateIndex">
											<div class="hollyday-index">
																		
											
											

											<p>
												<?php // echo Html::a('Create Holiday', ['create'], ['class' => 'btn btn-success']) ?>
											</p>
											<?= GridView::widget([
												'dataProvider' => $dataProvider,
												
												//'filterModel' => $searchModel,
												'columns' => [
													['class' => 'yii\grid\SerialColumn'],

												   
													'date',
													'description',
													

													['class' => 'yii\grid\ActionColumn'],
												],
											]); ?>
							</div>
                    </div>
                </div>
		</div>
    </div>

