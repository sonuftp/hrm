<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TableEmp */

$this->title = 'Create Table Emp';
$this->params['breadcrumbs'][] = ['label' => 'Table Emps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-emp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
