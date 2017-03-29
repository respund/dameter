<?php

use yii\db\Migration;

class m170329_113323_initial_populate_base extends Migration
{
    public function safeUp()
    {
        $this->createTable('survey', [
            'survey_id' => $this->primaryKey()->comment('ID'),
            'template_id' => $this->integer()->notNull()->comment('Survey template'),
        ]);

        $this->createTable('question_group', [
            'question_group_id' => $this->primaryKey()->comment('ID'),
            'survey_id' => $this->integer()->notNull()->comment('Survey'),
            'code' => $this->string(128)->notNull()->comment('Group code'),
            'language_id' => $this->integer()->notNull()->comment('Language'),
            'description' => $this->text()->comment('Group pubic description'),
        ]);

        $this->createTable('question_type_group', [
            'question_type_group_id' => $this->primaryKey()->comment('ID'),
            'name' => $this->string(255)->notNull()->comment('Name'),
            'order' => $this->integer()->notNull()->comment('Order'),
            'description' => $this->text()->comment('Description'),
        ]);

        $this->createTable('question_type', [
            'question_type_id' => $this->primaryKey()->comment('ID'),
            'question_type_group_id' => $this->integer()->notNull()->comment('Group'),
            'name' => $this->integer()->notNull()->comment('Name'),
            'description' => $this->text()->comment('Description'),
            'image' => $this->text()->comment('Image URI'),
            'order' => $this->integer()->notNull()->comment('Order'),
        ]);

        $this->createTable('question', [
            'question_id' => $this->primaryKey()->comment('ID'),
            'question_type_id' => $this->integer()->notNull()->comment('Question type'),
            'survey_id' => $this->integer()->notNull()->comment('Survey'),
            'question_group_id' => $this->integer()->notNull()->comment('Question group'),
            'language_id' => $this->integer()->notNull()->comment('Language'),
            'code' => $this->string(128)->notNull()->comment('Question code'),
            'text' => $this->text()->notNull()->comment('Question text'),
            'help' => $this->text()->null()->comment('Help text'),
            'order' => $this->integer()->notNull()->comment('Order'),
            'mandatory' => $this->boolean()->notNull()->comment('Mandatory'),
        ]);

        $this->createTable('answer', [
            'answer_id' => $this->primaryKey()->comment('ID'),
            'question_id' => $this->integer()->notNull()->comment('Question'),
            'text' => $this->text()->notNull()->comment('Answer text'),
            'code' => $this->string(128)->notNull()->comment('Answer code'),
            'help' => $this->text()->null()->comment('Help text'),
            'order' => $this->integer()->notNull()->comment('Order'),
        ]);

        $this->createTable('language', [
            'language_id' => $this->primaryKey()->comment('ID'),
            'code' => $this->string(16)->notNull()->comment('Language code'),
            'name' => $this->string(255)->notNull()->comment('Language'),
            'active' => $this->boolean()->notNull()->comment('Active'),
        ]);

        $this->createTable('template', [
            'template_id' => $this->primaryKey()->comment('ID'),
            'name' => $this->string(255)->notNull()->comment('Language'),
            'description' => $this->text()->comment('Description'),
        ]);

        $this->createTable('question_attribute', [
            'question_attribute_id' => $this->primaryKey()->comment('ID'),
            'name' => $this->string(255)->notNull()->comment('Language'),
            'value' => $this->text()->comment('Value'),
        ]);


        //Describes the default attributes for question types
        $this->createTable('question_type_has_attribute', [
            'question_type_has_attribute_id' => $this->primaryKey()->comment('ID'),
            'question_type_id' => $this->integer()->notNull()->comment('Question type'),
            'question_attribute_id' => $this->integer()->notNull()->comment('Attribute'),
        ]);

        $this->createTable('question_has_attribute', [
            'question_has_attribute_id' => $this->primaryKey()->comment('ID'),
            'question_id' => $this->integer()->notNull()->comment('Question'),
            'question_attribute_id' => $this->integer()->notNull()->comment('Attribute'),
        ]);




        $this->createTable('survey_has_language', [
            'survey_has_language_id' => $this->primaryKey()->comment('ID'),
            'survey_id' => $this->integer()->notNull()->comment('Survey'),
            'language_id' => $this->integer()->notNull()->comment('Language'),
        ]);

        $this->createTable('languagesetting', [
            'languagesetting_id' => $this->primaryKey()->comment('ID'),
            'entity' => $this->string(255)->notNull()->comment('Entity name'),
            'code' => $this->string(128)->notNull()->unique()->comment('Code'),
            'name' => $this->string(255)->notNull()->comment('Name'),
            'description' => $this->text()->comment('Description'),
        ]);




        // create foreign keys, relations
        $this->addForeignKey('fk_answer_question','answer','question_id','question','question_id');

        $this->addForeignKey('fk_question_question_type','question','question_type_id','question_type','question_type_id');
        $this->addForeignKey('fk_question_survey','question','survey_id','survey','survey_id');
        $this->addForeignKey('fk_question_language','question','language_id','language','language_id');
        $this->addForeignKey('fk_question_question_group','question','question_group_id','question_group','question_group_id');

        $this->addForeignKey('fk_question_type_group','question_type','question_type_group_id','question_type_group','question_type_group_id');
        $this->addForeignKey('fk_question_group_survey','question_group','survey_id','survey','survey_id');
        $this->addForeignKey('fk_survey_template','survey','template_id','template','template_id');

        $this->addForeignKey('fk_qtha_type','question_type_has_attribute','question_type_id','question_type','question_type_id');
        $this->addForeignKey('fk_qtha_attribute','question_type_has_attribute','question_attribute_id','question_attribute','question_attribute_id');
        $this->addForeignKey('fk_qha_question','question_has_attribute','question_id','question','question_id');
        $this->addForeignKey('fk_qta_attribute','question_has_attribute','question_attribute_id','question_attribute','question_attribute_id');

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_answer_question','answer');

        $this->dropForeignKey('fk_question_question_type','question');
        $this->dropForeignKey('fk_question_survey','question');
        $this->dropForeignKey('fk_question_language','question');
        $this->dropForeignKey('fk_question_question_group','question');

        $this->dropForeignKey('fk_question_type_group','question_type');
        $this->dropForeignKey('fk_question_group_survey','question_group');
        $this->dropForeignKey('fk_survey_template','survey');

        $this->dropForeignKey('fk_qtha_type','question_type_has_attribute');
        $this->dropForeignKey('fk_qtha_attribute','question_type_has_attribute');
        $this->dropForeignKey('fk_qha_question','question_has_attribute');
        $this->dropForeignKey('fk_qta_attribute','question_has_attribute');

        $this->dropTable('question_has_attribute');
        $this->dropTable('question_type_has_attribute');
        $this->dropTable('question_attribute');
        $this->dropTable('template');
        $this->dropTable('language');
        $this->dropTable('answer');
        $this->dropTable('question');
        $this->dropTable('question_type');
        $this->dropTable('question_type_group');
        $this->dropTable('question_group');
        $this->dropTable('survey');
    }
}
