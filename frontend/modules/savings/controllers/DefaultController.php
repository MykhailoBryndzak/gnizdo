<?php

namespace frontend\modules\savings\controllers;

use frontend\modules\savings\models\GoalsUsers;
use frontend\modules\savings\models\SavingsUsers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;


class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->identity->getId();


        $model = new SavingsUsers();
        $date = (new \DateTime())->format('Y-m-d');
        $model->date = $date;
        $model->user_id = $userId;

        $goalsUser = GoalsUsers::goalsOfUser($userId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        } else {
            return $this->render('index' , [
                'model' => $model,
                'goalsUser' => $goalsUser,
                'lastRecordSavings' => SavingsUsers::getLastRecordSavings($userId),
                'sumCosts' => SavingsUsers::sumAllSavingsUser($userId)
            ]);
        }
    }


    public function actionUpdate($id)
    {
        $userId = Yii::$app->user->identity->getId();

        $model = SavingsUsers::findOne($id);
        $date = (new \DateTime())->format('Y-m-d');
        $model->date = $date;
        $model->user_id = $userId;
        $model->saving = $model->saving / 100;

        $goalsUser = GoalsUsers::goalsOfUser($userId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        } else {
            return $this->render('update' , [
                'model' => $model,
                'goalsUser' => $goalsUser
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = SavingsUsers::findOne($id);
        if ($model->delete()) {
            return $this->redirect(['/savings']);
        }

    }
}