<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\app\models\Hollyday */
/* @var $form yii\widgets\ActiveForm */
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
					<?= $form->field($model, 'date')->widget(\yii\jui\DatePicker :: classname(),['dateFormat' => 'yyyy-MM-dd',]) ?>
				</div>
			</div>
			<div class="form-group col-lg-5 col-md-6">
				
				<div class="col-xs-8">
					<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="modal-footer">
		<div class="row">             
		   <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		   </div>
		   
		</div>
   </div>
<?php ActiveForm::end(); ?>
<div class="clearfix"></div> 
	</div>

