<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\app\models\Workdays */

$this->title = 'Update Workdays: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Workdays', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="workdays-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
