<?php

use yii\widgets\DetailView;
use vendor\codefire\cfusermgmt\models\user;
use frontend\models\Leave;

/* @var $this yii\web\View */
/* @var $model frontend\models\leave */
?>
<div class="leave-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'user.first_name',
            'user.last_name',
            'from_date',
            'to_date',
            [
                 'attribute'=>'type',
        'value' => function($model){
           $gettypes = Leave::gettypes();
           return isset($gettypes[$model->type])?$gettypes[$model->type]:'';
        },
            ],
            'remark',
            [
            'attribute'=>'status',
          'value' => function($model){
            $getstatus = Leave::getstatus();
           return isset($getstatus[$model->status])?$getstatus[$model->status]:'';
        },
            ],
            
        ],
    ]) ?>

</div>
