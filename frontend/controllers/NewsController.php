<?php

namespace frontend\controllers;

use common\models\News;
use common\models\RubricNews;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class NewsController extends ActiveController
{
    public $modelClass = 'common\models\News';

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

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete'], $actions['create'], $actions['options'], $actions['update']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider() {
        $id = Yii::$app->request->get('id');

        if(empty($id))
        {
            $query = News::find()->orderBy(['id' => SORT_DESC]);
        }
        else
        {
            $query = News::find()
                ->select('news.id, title, body')
                ->leftJoin('rubric_news', 'news.id = news_id')->andWhere(['rubric_id' => Yii::$app->request->get('id')])
                ->orderBy(['id' => SORT_DESC]);;
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
    }

}
