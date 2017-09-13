<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Workdays;

/* @var $this yii\web\View */
/* @var $model app\models\WorkdaysSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="workdays-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

	   		<div class="row">
			<div class="form-group col-lg-6 col-md-8">
				<label class="control-label col-xs-4 rgi_txt_lbl">Month</label>
				<div class="col-xs-8">
					  <?= $form->field($model, 'month')->dropDownList(Workdays::findMonthsOptions(),['prompt'=>'Please Select Month','style' =>'width:200px'])->label(false);?>
				</div>
			</div>
			<div class="form-group col-lg-6 col-md-8">
				<label class="col-sm-4 control-label">Year</label>
				<div class="col-xs-8">
				  <?= $form->field($model, 'year')->dropDownList(Workdays::findYearsOptions(),['prompt'=>'Please Select Year','style' =>'width:200px'])->label(false);?>
				</div>				
		</div>
		</div>
		<div class="row" style="padding-left:40%">
			<div class="form-group col-lg-6 col-md-8">
				<div class="col-xs-8">
					     <div class="form-group">
						<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
						<?= Html::button('Reset', [ 'class' => 'btn btn-danger', 'onclick' => 'reset_filter()']);?>
 				</div>
			</div>			
		</div>
		</div>

    <?php ActiveForm::end(); ?>

</div>
<script>
function reset_filter(){ 
						
            window.location.href = "<?php echo Yii::$app->request->baseUrl; ?>/workdays/";
			 
			 }
</script>