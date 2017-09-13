<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\OhrmAttendanceRecordSearch;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\OhrmAttendanceRecord */

$this->title = 'Create Ohrm Attendance Record';
$this->params['breadcrumbs'][] = ['label' => 'Ohrm Attendance Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ohrm-attendance-record-create">

    

    <?= $this->render('__form', [
        'model' => $model,
    ]) ?>

</div>
