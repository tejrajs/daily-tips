<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%fonts}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $font
 * @property string $example
 * @property integer $active
 */
class Fonts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%fonts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'font', 'example', 'active'], 'required'],
            [['active'], 'integer'],
            [['name', 'font', 'example'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'font' => Yii::t('app', 'Font'),
            'example' => Yii::t('app', 'Example'),
            'active' => Yii::t('app', 'Active'),
        ];
    }
}
