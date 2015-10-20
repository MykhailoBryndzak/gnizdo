<?php

namespace frontend\modules\debts\controllers;

use Yii;
use frontend\modules\debts\models\DebtsUsers;
use yii\jui\Draggable;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                'only' => ['index', 'add', 'archive'],
                'rules' => [
                    [
                        'actions' => ['index', 'archive'],
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

    public function actionArchive()
    {
        $userId = Yii::$app->user->identity->getId();
        $debtsUser = DebtsUsers::findAll(['user_id' => $userId])->order('date DESC');
        return $this->render('index', [
            'debtsUser' => $debtsUser
        ]);
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->identity->getId();
        $model = new DebtsUsers();
        $date = (new \DateTime())->format('Y-m-d');
        $model->date_debts = $date;
        $model->user_id = $userId;
        $model->status = 0;

        $debtsUser = DebtsUsers::find()
            ->where(['user_id' => $userId])
            ->orderBy('date_debts DESC')
            ->all();;
        $sumDebts = DebtsUsers::sumAllDebtsUser($userId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        } else {
            return $this->render('index', [
                'model' => $model,
                'debtsUser' => $debtsUser,
                'sumDebts' => $sumDebts
            ]);
        }

    }

    public function actionDeleteDebt($id)
    {
        $model = DebtsUsers::findOne($id);
        if ($model->delete()) {
            return $this->redirect(['/debts']);
        }
    }


    public function actionUpdateDebt($id)
    {
        $userId = Yii::$app->user->identity->getId();

        $model = DebtsUsers::findOne($id);
        $date = (new \DateTime($model->date_debts))->format('Y-m-d');
        $model->date_debts = $date;
        $model->user_id = $userId;
        $model->debt = $model->debt / 100;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        } else {
            return $this->render('updateDebt' , [
                'model' => $model,
            ]);
        }
    }

    public function actionChangeStatus($id)
    {
//        $userId = Yii::$app->user->identity->getId();

        $model = DebtsUsers::findOne($id);
        $model->debt = $model->debt / 100;
        if ($model && $model->status == 1) {
            $model->status = 0;
        } else {
            $model->status = 1;
        }

        if ($model->update()) {
            return $this->redirect(['/debts']);
        } else {
            return $this->redirect(['/debts']);
        }

    }





}
