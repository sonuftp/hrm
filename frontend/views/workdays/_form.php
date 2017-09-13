<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Workdays;
use yii\web\JqueryAsset;
JqueryAsset::register($this);
/* @var $this yii\web\View */
/* @var $model frontend\app\models\Workdays */
/* @var $form yii\widgets\ActiveForm */
?>
<?php   $this->registerJs("jQuery('#checkAll').change(function(){jQuery('.sat').prop('checked',this.checked?'checked':'');})");?>
	<style>.form-group {margin-bottom: 8px;}</style>
	<div class="container">
	<div class="radius_box mobile-radius_box">
	<div class="modal-header">      
		<h4 class="modal-title"><?php echo $this->title; ?></h4>
	</div>
	<div class="modal-body">
	   <?php $form = ActiveForm::begin();?>
			<div class="row">
			<div class="form-group col-lg-6 col-md-6">
					<div class="col-xs-8">
						 <?= $form->field($model, 'month')->dropDownList(Workdays::findMonthsOptions(),['prompt'=>'Please Select','style' =>'width:200px'])->label($model->getAttributeLabel('Month'));?>
					</div>
				</div>
				<div class="form-group col-lg-6 col-md-6">
					<div class="col-xs-8">
						 <?= $form->field($model, 'year')->dropDownList(Workdays::findYearsOptions(),['prompt'=>'Please Select','style' =>'width:200px'])->label($model->getAttributeLabel('Year'));?>
					</div>
				</div>
			</div>
			<div class="row">
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-20">
							<?php echo$form->field($model, 'sun')->checkboxList(['1'=>'First', '2'=>'Second' , '3'=>'Third','4' =>'Fourth','5'=>'Fifth'])->label("Sunday");?>
					</div>
			</div>
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-5" style="padding-top:33px">
							<input type="checkbox" id="sun">All/None
					</div>
			</div>
			</div>
			<div class="row">
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-20">
							<?= $form->field($model, 'mon')->checkboxList(['1'=>'First', '2'=>'Second' , '3'=>'Third','4' =>'Fourth','5'=>'Fifth'])->label("Monday"); ?>
					</div>
			</div>
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-5" style="padding-top:33px">
							<input type="checkbox" id="mon">All/None
					</div>
			</div>
			</div>
			<div class="row">
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-20">
							<?= $form->field($model, 'tue')->checkboxList(['1'=>'First', '2'=>'Second' , '3'=>'Third','4' =>'Fourth','5'=>'Fifth'])->label("Tuesday"); ?>
					</div>
			</div>
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-5" style="padding-top:33px">
							<input type="checkbox" id="tues">All/None
					</div>
			</div>
			</div>
			<div class="row">
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-20">
							<?= $form->field($model, 'wed')->checkboxList(['1'=>'First', '2'=>'Second' , '3'=>'Third','4' =>'Fourth','5'=>'Fifth'])->label("Wednesday"); ?>
					</div>
			</div>
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-5" style="padding-top:33px">
							<input type="checkbox" id="wed">All/None
					</div>
			</div>
			</div>
			<div class="row">
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-20">
							<?= $form->field($model, 'thu')->checkboxList(['1'=>'First', '2'=>'Second' , '3'=>'Third','4' =>'Fourth','5'=>'Fifth'])->label("Thursday"); ?>
					</div>
			</div>
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-5" style="padding-top:33px">
							<input type="checkbox" id="thu">All/None
					</div>
			</div>
			</div>
			<div class="row">
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-20">
							<?= $form->field($model, 'fri')->checkboxList(['1'=>'First', '2'=>'Second' , '3'=>'Third','4' =>'Fourth','5'=>'Fifth'])->label("Friday"); ?> 
					</div>
			</div>
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-5" style="padding-top:33px">
							<input type="checkbox" id="fri">All/None
					</div>
			</div>
			</div>
			<div class="row">
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-20">
							<?= $form->field($model, 'sat')->checkboxList(['1'=>'First', '2'=>'Second' , '3'=>'Third','4' =>'Fourth','5'=>'Fifth'])->label("Saturday"); ?>
					</div>
			</div>
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-5" style="padding-top:33px">
							<input type="checkbox" id="sat">All/None
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

<?php
    $script = <<< JS
     
	$("#sun,#mon,#tues,#wed,#thu,#fri,#sat").click(function() {
	var sel="workdays-"+this.id;
    var selector = $(this).is(':checked') ? ':not(:checked)' : ':checked';
    $('#'+sel+' input[type="checkbox"]' + selector).each(function() {
        $(this).trigger('click');
    });
    });
JS;
$this->registerJs($script);
?>

