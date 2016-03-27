<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user_posts}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $message
 * @property integer $font_size
 * @property string $font_color
 * @property string $outline_color
 * @property string $font_name
 * @property integer $border_thickness
 * @property string $shadow_color
 * @property integer $border_options
 * @property integer $shadow
 * @property integer $shadow_offset
 * @property integer $save_to_file
 */
class UserPosts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_posts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'message', 'font_size', 'font_color', 'outline_color', 'font_name', 'border_thickness', 'shadow_color', 'border_options', 'shadow', 'shadow_offset', 'save_to_file'], 'required'],
            [['user_id', 'font_size', 'border_thickness', 'border_options', 'shadow', 'shadow_offset', 'save_to_file'], 'integer'],
            [['message'], 'string'],
            [['font_color', 'outline_color', 'shadow_color'], 'string', 'max' => 25],
            [['font_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'message' => Yii::t('app', 'Message'),
            'font_size' => Yii::t('app', 'Font Size'),
            'font_color' => Yii::t('app', 'Font Color'),
            'outline_color' => Yii::t('app', 'Outline Color'),
            'font_name' => Yii::t('app', 'Font Name'),
            'border_thickness' => Yii::t('app', 'Border Thickness'),
            'shadow_color' => Yii::t('app', 'Shadow Color'),
            'border_options' => Yii::t('app', 'Border Options'),
            'shadow' => Yii::t('app', 'Shadow'),
            'shadow_offset' => Yii::t('app', 'Shadow Offset'),
            'save_to_file' => Yii::t('app', 'Save To File'),
        ];
    }
}
