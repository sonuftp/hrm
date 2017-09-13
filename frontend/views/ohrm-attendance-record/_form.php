<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\OhrmAttendanceRecord;
/* @var $this yii\web\View */
/* @var $model frontend\models\OhrmAttendanceRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ohrm-attendance-record-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'month')->dropDownList(OhrmAttendanceRecord::findMonthsOptions(),['class' =>'form-control','prompt'=>'Please Select'])->label(false);?>
	
	<?= $form->field($model, 'year')->textInput() ?>
	
    <?= $form->field($model, 'exfile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Insert' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
