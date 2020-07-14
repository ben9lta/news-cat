<?php

namespace frontend\controllers;

use common\models\Rubric;
use Yii;
use yii\filters\Cors;
use yii\rest\ActiveController;

class RubricController extends ActiveController
{
    public $modelClass = Rubric::class;

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

        return $actions;
    }


    public function actionAll() {
        $rubric = Rubric::find()->orderBy(['rubric_id' => SORT_ASC])->all();
        $result = [];
        $level = Yii::$app->request->get('level');

        if(empty($level)) {
            foreach ($rubric as $r) {
                $result[] = ['id' => $r['id'], 'title' => $r['title'], 'rubric_id' => $r['rubric_id'], 'href' => '/rubric/' . $r['id']];
            }
        }
        else
        {
            $i = 0;
            $levelArr = [[0]];

            while($i < $level) {
                $next = $this->nextRubricLevel($rubric, $levelArr[$i]);
                $result = array_merge($result, $next[0]);
                $levelArr[] = $next[1];
                $i++;
            }
        }

        return $result;
    }

    private function nextRubricLevel($rubric, $levelArr) {
        $_levelArr = [];
        $result = [];
        foreach ($levelArr as $arr) {
            foreach ($rubric as $r) {
                if($r['rubric_id'] == $arr) {
                    $_levelArr[] = $r['id'];
                    $result[] = ['id' => $r['id'], 'title' => $r['title'], 'rubric_id' => $r['rubric_id'], 'href' => '/rubric/' . $r['id']];
                }
            }
        }
        return [$result, $_levelArr];
    }

}
