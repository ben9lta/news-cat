<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

use yii\helpers\Url; ?>
<div class="site-index">

    <ul class="nav nav-pills" role="tablist">
        <li role="presentation"><a href="<?= Url::to(['rubric/index']) ?>">Rubric <span class="badge"><?= \common\models\Rubric::find()->count() ?></span></a></li>
        <li role="presentation"><a href="<?= Url::to(['news/index']) ?>">News <span class="badge"><?= \common\models\News::find()->count() ?></span></a></li>
    </ul>
</div>
