<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\MessageSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
<div class="message-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
	<div style="display:inline-block" class="col-sm-3 col-xs-12 search-frm-topspc">
    <?= $form->field($model, 'id')->dropDownList(vendor\codefire\cfusermgmt\models\SourceMessage::getlabels(),['prompt'=>'Please Select']); ?>
	</div>
	<div style="display:inline-block" class="col-sm-3 col-xs-12 search-frm-topspc">
    <?= $form->field($model, 'language') ?>
	</div>
	<div style="display:inline-block" class="col-sm-3 col-xs-12 search-frm-topspc">
    <?= $form->field($model, 'translation') ?>
	</div>
	<div class="search_submit col-sm-12" style="text-align:center;">
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>
	</div>
    <?php ActiveForm::end(); ?>

</div>
</div>
