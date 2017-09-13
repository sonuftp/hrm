<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use frontend\models\Leave;
use vendor\codefire\cfusermgmt\models\user;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model frontend\models\leave */
/* @var $form yii\widgets\ActiveForm */

$gettypes = Leave::gettypes();
$getstatus = Leave::getstatus();
$model->edit_leave_id = $model->id;
//~ $model->edit_leave_id = 11;

?>

<div class="leave-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(
            ArrayHelper::map(User::find()->all(),'id','email'), array('disabled' => 'disabled')
    ) ?>


    <?= $form->field($model, 'from_date')->widget(\yii\jui\DatePicker::classname(), [

    //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'clientOptions' => [
        //'minDate' => 0,
       // 'disabled'=>'true'
        ]
    ]); ?>

    <?= $form->field($model, 'to_date')->widget(\yii\jui\DatePicker::classname(), [
        
    //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'clientOptions' => [
        //'minDate' => 0,
        //'disabled'=>'true'
        ]
    ]); ?>

    <?= $form->field($model, 'type')->dropDownList($gettypes); ?>

    <?= $form->field($model, 'remark')->textArea(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($getstatus); ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<?php

    $script = <<< JS
    $(document).ready(function(){
            
        $("#leave-from_date").change(function(){
             
            $("#leave-to_date").val($(this).val());

        });
      
      $("#leave-to_date").change(function(){
        var d1 = Date.parse(document.getElementById('leave-from_date').value);
        var d2 = Date.parse(document.getElementById('leave-to_date').value);

        if( d1 == d2)
        {
             $("select option:contains('First Half')").attr("disabled",false);
            $("select option:contains('Second Half')").attr("disabled",false);
              
        }

         if(d1 != d2)
        {
            $("select option:contains('First Half')").attr("disabled","disabled");
            $("select option:contains('Second Half')").attr("disabled","disabled");
            
        }


         if(d1 > d2)
        {
            alert("Please Select Correct date in To Date");
            document.getElementById('leave-to_date').value = '';
            return false;
        }
        else
        {
            return true;
        }
      });


    });

JS;
$this->registerJs($script);
?>
