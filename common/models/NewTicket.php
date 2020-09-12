<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "new_ticket".
 *
 * @property int $id
 * @property string $department
 * @property string $category
 * @property string $subject
 * @property string $description
 */
class NewTicket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'new_ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department', 'category', 'subject', 'description'], 'required'],
            [['subject', 'description'], 'string'],
            [['department', 'category'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'department' => 'Department',
            'category' => 'Category',
            'subject' => 'Subject',
            'description' => 'Description',
        ];
    }
}
