<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rubric_news}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%rubric}}`
 * - `{{%news}}`
 */
class m200626_211053_create_rubric_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rubric_news}}', [
            'id' => $this->primaryKey()->unsigned(),
            'rubric_id' => $this->integer()->notNull()->unsigned(),
            'news_id' => $this->integer()->notNull()->unsigned(),
        ]);

        // creates index for column `rubric_id`
        $this->createIndex(
            '{{%idx-rubric_news-rubric_id}}',
            '{{%rubric_news}}',
            'rubric_id'
        );

        // add foreign key for table `{{%rubric}}`
        $this->addForeignKey(
            '{{%fk-rubric_news-rubric_id}}',
            '{{%rubric_news}}',
            'rubric_id',
            '{{%rubric}}',
            'id',
            'CASCADE'
        );

        // creates index for column `news_id`
        $this->createIndex(
            '{{%idx-rubric_news-news_id}}',
            '{{%rubric_news}}',
            'news_id'
        );

        // add foreign key for table `{{%news}}`
        $this->addForeignKey(
            '{{%fk-rubric_news-news_id}}',
            '{{%rubric_news}}',
            'news_id',
            '{{%news}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%rubric}}`
        $this->dropForeignKey(
            '{{%fk-rubric_news-rubric_id}}',
            '{{%rubric_news}}'
        );

        // drops index for column `rubric_id`
        $this->dropIndex(
            '{{%idx-rubric_news-rubric_id}}',
            '{{%rubric_news}}'
        );

        // drops foreign key for table `{{%news}}`
        $this->dropForeignKey(
            '{{%fk-rubric_news-news_id}}',
            '{{%rubric_news}}'
        );

        // drops index for column `news_id`
        $this->dropIndex(
            '{{%idx-rubric_news-news_id}}',
            '{{%rubric_news}}'
        );

        $this->dropTable('{{%rubric_news}}');
    }
}
