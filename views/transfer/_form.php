<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transfer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username_recipient')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transfer_amount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Перевести', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
