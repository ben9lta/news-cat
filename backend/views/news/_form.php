<?php

use common\models\Rubric;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
/* @var $ids array */
/* @var $rubric Rubric */

function getID($ids) {
    $result = '';
    foreach ($ids as $i => $id)
        $result .= 'el.value == ' . $id['rubric_id'] . ($i == count($ids) - 1 ? '' : ' || ');
    return $result;
}

$js = $this->registerJs(
    "$('select#rubric-rubric_id option').map((i,el) => (" . getID($ids) . ") ? el.selected = true : '')
    $('select#rubric-rubric_id').focus();"
)
?>

<div class="news-form">

    <?= Yii::$app->session->getFlash('error'); ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <label for="rubric-rubric_id">Rubric</label>
        <select multiple=true name="Rubric[rubric_id][]" id="rubric-rubric_id" class="form-control">
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
