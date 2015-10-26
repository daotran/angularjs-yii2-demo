<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * FeedbackForm is the model behind the feedback form.
 */
class FeedbackForm extends Model
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
    public function rules()
    {
        return [
            // name, age, sex and body are required
            [['name', 'age', 'sex', 'country', 'state', 'addr1' ,'addr2', 'comment'], 'required']
        ];
    }

}
