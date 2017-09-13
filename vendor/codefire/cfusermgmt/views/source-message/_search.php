<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SourceMessageSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
<div class="source-message-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
	<div style="display:inline-block" class="col-sm-3 col-xs-12 search-frm-topspc">
    <?= $form->field($model, 'id') ?>
    </div>
	<div style="display:inline-block" class="col-sm-3 col-xs-12 search-frm-topspc">
    <?= $form->field($model, 'category') ?>
	</div>
	<div style="display:inline-block" class="col-sm-3 col-xs-12 search-frm-topspc">
    <?= $form->field($model, 'message') ?>
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
