<?php
use yii\helpers\Url;
use yii\helpers\Html;
use vendor\codefire\cfusermgmt\models\user;
use frontend\models\Leave;



return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
   
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user.first_name',
    ],
     [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user.last_name',
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'from_date',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'to_date',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'value' => function($data){
           $gettypes = Leave::gettypes();
           return isset($gettypes[$data->type])?$gettypes[$data->type]:'';
        },
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'remark',
        
         'value' => function($data){
            $pos = strpos($data->remark, ' ', 6);
           return isset($data->remark)? substr($data->remark, 0, $pos )."...":'';
        },
    ],*/
     [
        'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'status',
          'value' => function($data){
            $getstatus = Leave::getstatus();
           return isset($getstatus[$data->status])?$getstatus[$data->status]:'';
        },
     ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'modify_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_date',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'modify_date',
    // ],
     
    [

        'class' => 'kartik\grid\ActionColumn',
        'header'=>(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS)))?'Action':'',
        'width' => (in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS)))?'100px':'',
        'dropdown' => false,
        'template' =>(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS)))?'{view}{update}{delete}':'',
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
       
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
      
    ],

];   
