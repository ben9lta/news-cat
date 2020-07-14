<?php

namespace frontend\controllers;

use common\models\News;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\Cors;
use yii\rest\ActiveController;

class NewsController extends ActiveController
{
    public $modelClass = 'common\models\News';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method'  => ['GET'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Max-Age'         => 3600,
                'Access-Control-Expose-Headers'  => [
                    'X-Pagination-Current-Page',
                    'X-Pagination-Total-Count',
                    'X-Pagination-Page-Count',
                ],
//                'Access-Control-Allow-Credentials' => true,
            ],
        ];

//        $behaviors['authenticator'] = [
//            'class' =>  HttpBearerAuth::className(),
//            'except' => ['options','login'], // для гостей
//        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();


        unset($actions['delete'], $actions['create'], $actions['options'], $actions['update']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $id = Yii::$app->request->get('id');
        $pageSize = Yii::$app->request->get('limit') ?? 5;

        if (empty($id)) {
            $query = News::find()->orderBy(['id' => SORT_DESC]);
        } else {
            $query = News::find()
                ->select('news.id, title, body')
                ->leftJoin('rubric_news', 'news.id = news_id')->andWhere(['rubric_id' => Yii::$app->request->get('id')])
                ->orderBy(['id' => SORT_DESC]);;
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
    }

}
