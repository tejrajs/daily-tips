<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $description
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value', 'description'], 'required'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 200],
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
            'value' => Yii::t('app', 'Value'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
    
    public static function getValue($name=''){
    	if($name != ''){
    		$model = self::findOne(['name' => $name]);
    		if(!empty($model)){
    			return $model->value;
    		}else{
    			return ;
    		}
    	}
    }
}
