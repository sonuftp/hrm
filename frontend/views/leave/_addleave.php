<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\leave */
/* @var $form ActiveForm */
?>
<div class="leave-_addleave">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_id') ?>
        <?= $form->field($model, 'from_date') ?>
        <?= $form->field($model, 'to_date') ?>
        <?= $form->field($model, 'type') ?>
        <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'modify_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'modify_date')->textInput() ?>

    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- leave-_addleave -->

<?php 

for column

 [
        'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'status',
          'value' => function($data){
            $status = $data->status;
            if($status == 0) {
                $data->status = "Pending";
            }
            if($status == 1) {
                $data->status = "Rejected";
            }
            if($status == 2) {
                $data->status = "Approved";
            }
            //$gettypes = Leave::gettypes();
            return Html::encode($data->status);
        },
     ],

?>

