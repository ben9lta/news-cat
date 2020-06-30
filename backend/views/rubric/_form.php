<?php

use common\models\Rubric;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Rubric */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="rubric-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <label for="rubric-rubric_id">Rubric</label>
        <select name="Rubric[rubric_id]" id="rubric-rubric_id" class="form-control">
        <option value="0">-- Родительская категория --</option>
            <?php
                foreach ($rubric as $r)
                    Rubric::buildTree($r);
            ?>
        </select>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
