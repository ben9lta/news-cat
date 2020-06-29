<?php


namespace common\models;


use yii\db\ActiveQuery;

class RubricQuery extends ActiveQuery
{
    public $with = ['rubrics']; //Получаем дочерние элементы родительской категории
}