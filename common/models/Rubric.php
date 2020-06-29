<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rubric".
 *
 * @property int $id
 * @property string|null $title
 * @property int $rubric_id
 *
 * @property mixed $rubrics
 * @property RubricNews[] $rubricNews
 */
class Rubric extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rubric';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rubric_id'], 'integer'],
            [['rubric_id'], 'default', 'value' => 0],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public static function buildTree($rubric, $count = 0) {
        self::renderOptions($rubric, $count);

        if($rubric['rubrics']) {
            $count++;
            foreach ($rubric['rubrics'] as $r) {
                self::buildTree($r, $count);
            }
        }
    }

    public static function renderOptions($rubric, $count) {
        $symbol = '';

        for ($i = 0; $i < $count; $i++)
            $symbol .= '-';

        echo $title = $count > 0 ? $symbol . ' ' . $rubric['title'] : $rubric['title'];
        echo '<option value="' . $rubric['id'] . '">' . $title . '</option>';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'rubric_id' => 'Rubric ID',
        ];
    }

    public static function find()
    {
        return new RubricQuery(get_called_class()); //Рекурсия
    }

    /**
     * Gets query for [[RubricNews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRubricNews()
    {
        return $this->hasMany(RubricNews::className(), ['rubric_id' => 'id']);
    }

    public function getRubrics()
    {
        return $this->hasMany(self::className(), ['rubric_id' => 'id']);
    }
}
