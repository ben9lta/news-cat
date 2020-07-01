<?php

namespace frontend\controllers;

use common\models\Rubric;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\rest\ActiveController;

class RubricController extends ActiveController
{
    public $modelClass = Rubric::class;

    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }



    public function actionAll() {
        $rubric = Rubric::find()->all();
        $result = [];
        foreach ($rubric as $r) {
            $result[] = ['item' => ['title' => $r['title'], 'href' => '/rubric/' . $r['id']]];
        }
        return $result;
//        return Rubric::find()->select('title')->all();
    }

}
