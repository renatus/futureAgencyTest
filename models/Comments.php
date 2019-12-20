<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $comment_id
 * @property string $time_created
 * @property string $user_name
 * @property string $comment_text
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // If attribute has no rules associated with it, you should mark it
            // as "safe" like this: [['time_created'], 'safe'],
            // otherwise it'll not be possible to set it from webform. Obvious security implications.
            // So, if you want to prevent user from setting / editing of this
            // attribute, just exclude it from this function.
            [['user_name', 'comment_text'], 'required'],
            [['comment_text'], 'string'],
            [['user_name'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => Yii::t('app', 'Comment ID'),
            'time_created' => Yii::t('app', 'Time Created'),
            'user_name' => Yii::t('app', 'User Name'),
            'comment_text' => Yii::t('app', 'Comment Text'),
        ];
    }
}