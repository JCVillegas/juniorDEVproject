<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Documents */

$this->title = 'Update Documents: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documents-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'key_values')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'url')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'created')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'updated')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'exported')->textInput(['readonly' => true]) ?>

    <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>
</div>


