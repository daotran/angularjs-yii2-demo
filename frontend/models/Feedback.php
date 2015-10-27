<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property integer $id
 * @property string $name
 * @property integer $age
 * @property boolean $sex
 * @property string $country
 * @property string $state
 * @property string $addr1
 * @property string $addr2
 * @property string $comment
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'age', 'country', 'sex', 'state', 'addr1', 'addr2', 'comment'], 'required'],
            [['age'], 'integer'],
            [['sex'], 'boolean'],
            [['name', 'country', 'state', 'addr1', 'addr2', 'comment'], 'string', 'max' => 255]
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
            'age' => Yii::t('app', 'Age'),
            'sex' => Yii::t('app', 'Sex'),
            'country' => Yii::t('app', 'Country'),
            'state' => Yii::t('app', 'State'),
            'addr1' => Yii::t('app', 'Addr1'),
            'addr2' => Yii::t('app', 'Addr2'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }
}
