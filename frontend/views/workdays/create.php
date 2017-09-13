<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\app\models\Workdays */

$this->title = 'Add Workdays';
$this->params['breadcrumbs'][] = ['label' => 'Workdays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workdays-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
