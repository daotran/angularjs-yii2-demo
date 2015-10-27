<?php
namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\Feedback;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;

/**
 * Site controller
 */
class ApiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['dashboard'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['dashboard'],
            'rules' => [
                [
                    'actions' => ['dashboard'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }

    public function actionDashboard()
    {
        $response = [
            'username' => Yii::$app->user->identity->username,
            'access_token' => Yii::$app->user->identity->getAuthKey(),
        ];

        return $response;
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                $response = [
                    'flash' => [
                        'class' => 'success',
                        'message' => 'Thank you for contacting us. We will respond to you as soon as possible.',
                    ]
                ];
            } else {
                $response = [
                    'flash' => [
                        'class' => 'error',
                        'message' => 'There was an error sending email.',
                    ]
                ];
            }
            return $response;
        } else {
            $model->validate();
            return $model;
        }
    }

    public function actionFeedback()
    {
        $model = new Feedback();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {

            // Getting posted data and decodeing json
            $_POST = json_decode(file_get_contents('php://input'), true);

            $model->name = $_POST['name'];
            $model->age = $_POST['age'];
            $model->sex = $_POST['sex'];
            $model->country = $_POST['country'];
            $model->state = $_POST['state'];
            $model->addr1 = $_POST['addr1'];
            $model->addr2 = $_POST['addr2'];
            $model->comment = $_POST['comment'];

            if ($model->save()) {
                $response = [
                    'flash' => [
                        'class' => 'success',
                        'message' => 'Thanks for your feedback.',
                    ]
                ];
            } else {
                $response = [
                    'flash' => [
                        'class' => 'error',
                        'message' => 'Model could not be save.',
                    ]                    
                ];
            }

            return $response;
        } else {
            $model->validate();
            return $model;
        }
    }
}
