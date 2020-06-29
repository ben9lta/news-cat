<?php

namespace frontend\controllers;

use yii\rest\ActiveController;

class NewsController extends ActiveController
{
    public $modelClass = 'common\models\News';
//    public $serializer = [
//        'class' => 'yii\rest\Serializer',
//        'collectionEnvelope' => 'items',
//    ];

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
}
