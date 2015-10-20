<?php
namespace frontend\controllers;

use frontend\modules\costs\models\CostsUsers;
use frontend\modules\debts\models\DebtsUsers;
use frontend\modules\income\models\IncomeUsers;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use frontend\models\ChangePasswordForm;


/**
 * User controller
 */
class UserController extends Controller
{
    public $layout = '/profile';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['profile', 'update','changePassword', 'logout'],
                'rules' => [
                    [
                        'actions' => ['profile', 'update', 'changePassword', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionProfile()
    {
        $id = Yii::$app->user->identity->id;
        $sumCosts = CostsUsers::sumAllCostsUser($id) . ' грн.';
        $sumDebts = DebtsUsers::sumAllDebtsUser($id) . ' грн.';
        $sumIncome = IncomeUsers::sumAllIncomeUser($id) . ' грн.';
        return $this->render('index', [
            'sumCosts' => $sumCosts,
            'sumDebts' => $sumDebts,
            'sumIncome' => $sumIncome,
        ]);
    }

    public function actionUpdate()
    {
        $model = $this->findModelUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->refresh();

        }
        return $this->render('update', [
            'model' => $model
        ]);
    }


    public function actionChangePassword()
    {

        $user = $this->findModelUser();
        $model = new ChangePasswordForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            return $this->redirect(['update']);
        } else {
            return $this->render('changePassword', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return User the loaded model
     */
    private function findModelUser()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


}