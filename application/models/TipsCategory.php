<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tips_category}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $category
 */
class TipsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tips_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'category'], 'required'],
            [['slug', 'category'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', 'Slug'),
            'category' => Yii::t('app', 'Category'),
        ];
    }
}
