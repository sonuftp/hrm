<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\OhrmAttendanceRecord;
/* @var $this yii\web\View */
/* @var $model frontend\models\OhrmAttendanceRecord */
/* @var $form yii\widgets\ActiveForm */

/* @var $this yii\web\View */
/* @var $model frontend\models\OhrmAttendanceRecord */

$this->title = 'Excel Ohrm Attendance Record';
$this->params['breadcrumbs'][] = ['label' => 'Ohrm Attendance Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>.form-group {margin-bottom: 8px;}</style>
<div class="container">
<div class="radius_box mobile-radius_box">
<div class="modal-header">      
    <h4 class="modal-title"><?php echo $this->title; ?></h4>
</div>

<div class="modal-body">
   <?php $form = ActiveForm::begin();?>
		<div class="row">
		<div class="form-group col-lg-3 col-md-6">
				
				<div class="col-xs-8">
					<?php echo $form->field($model, 'month')->dropDownList(OhrmAttendanceRecord::findMonthsOptions(),['class' =>'form-control','prompt'=>'Please Select'])->label($model->getAttributeLabel('Month'));?>
				</div>
			</div>
			<div class="form-group col-lg-3 col-md-6">
				
				<div class="col-xs-8">
					<?php echo $form->field($model, 'year')->dropDownList(OhrmAttendanceRecord::findYearsOptions(),['class' =>'form-control','prompt'=>'Please Select'])->label($model->getAttributeLabel('Year'));?>
				</div>
			</div>
			<div class="form-group col-lg-5 col-md-6">
			
				<div class="col-xs-8">
					<?= $form->field($model, 'exfile')->fileInput(['class' => 'form-control'])->label($model->getAttributeLabel('Excel File')) ?>
				</div>
			</div>
		</div>
	<div class="clearfix"></div>
	</div>
	<div class="modal-footer">
		<div class="row">
		<div class="col-sm-12 text-center" ><?=$model->msg?></div>
				
		  <div class="col-sm-12 text-center"><?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?></div>
		</div>
   </div>
<?php ActiveForm::end(); ?>
<div class="clearfix"></div> 
</div>
</div>
