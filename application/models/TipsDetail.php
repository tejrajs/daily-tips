<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tips_detail}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $tips
 * @property integer $active
 */
class TipsDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tips_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'tips', 'active'], 'required'],
            [['category_id', 'active'], 'integer'],
            [['tips'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'tips' => Yii::t('app', 'Tips'),
            'active' => Yii::t('app', 'Active'),
        ];
    }
}
