<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\OhrmAttendanceRecord */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Attendance view', 'url' => ['index']];
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
            <div class="padding5">	
                <div class="col-md-12" id="updateIndex">
				<div class="ohrm-attendance-record-index">
				<div class="ohrm-attendance-record-view">
				   <?php if(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))){ ?>
					<p><?= Html::a('update', ['update', 'id' => $model->id],['class'=>'btn btn-primary']); ?> </p>
					<p>
					<?= Html::a('Delete', ['delete', 'id' => $model->id], [
						'class' => 'btn btn-danger',
					'data' => [
							'confirm' => 'Are you sure you want to delete this item?',
							'method' => 'post',
							],
						]) ?>
					</p>
					<?php }?>

					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							'id',
							'employee_id',
							'punch_in_date',
							'punch_in_note',
							
							'punch_in_user_time',
							
							'punch_out_note',
							
							'punch_out_user_time',
							'state',
						],
					]) ?>
				</div>
				</div>
                </div>
            </div>
        </div>
    </div>

