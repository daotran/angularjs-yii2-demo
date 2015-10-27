<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * User model
 *
 * @property integer $id
 * @property string $name
 * @property string $age
 * @property string $sex
 * @property string $country
 * @property string $state
 * @property integer $addr1
 * @property integer $addr2
 * @property integer $comment
 */

class Feedback extends Model
{
    public $name;
    public $age;
    public $sex;
    public $country;
    public $state;
    public $addr1;
    public $addr2;    
    public $comment;

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
            // name, age, sex, country, state, addr1, addr2 and comment are required
            [['name', 'age', 'sex', 'country', 'state', 'addr1' ,'addr2', 'comment'], 'required']
        ];
    }

}