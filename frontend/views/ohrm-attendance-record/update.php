<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OhrmAttendanceRecord */

$this->title = 'Update : ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ohrm Attendance Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ohrm-attendance-record-update">

<!--
    <h1><?= Html::encode($this->title) ?></h1>
-->

    <?= $this->render('__form', [
        'model' => $model,
    ]) ?>

</div>
