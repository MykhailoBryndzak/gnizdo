<?php

namespace frontend\modules\income\controllers;

use frontend\modules\income\models\CategoriesIncome;
use frontend\modules\income\models\CategoryIncomeUsers;
use frontend\modules\income\models\IncomeUsers;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
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
                'only' => ['index', 'createCategory', 'createIncome', 'archive'],
                'rules' => [
                    [
                        'actions' => ['index', 'createCategory', 'updateIncome', 'archive'],
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

        $userHaveCategory = CategoryIncomeUsers::findCategoryInUser($userId);

        if (!$userHaveCategory) {
            return $this->redirect(['/income/create-category']);
        }

        $model = new IncomeUsers();
        $date = (new \DateTime())->format('Y-m-d');
        $model->date = $date;
        $model->user_id = $userId;

        $categoriesUser = CategoryIncomeUsers::categoriesOfUser($userId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        } else {
            return $this->render('index' , [
                'model' => $model,
                'categoriesUser' => $categoriesUser,
                'lastRecordIncome' => IncomeUsers::getLastRecordIncome($userId),
                'sumIncome' => IncomeUsers::sumAllIncomeUser($userId)
            ]);
        }
    }

    public function actionArchive()
    {
        $userId = Yii::$app->user->identity->getId();
        $incomeUser = IncomeUsers::findAll(['user_id' => $userId]);
        $sumIncome = IncomeUsers::sumAllIncomeUser($userId);

        return $this->render('archive', [
            'incomeUser' => $incomeUser,
            'sumIncome' => $sumIncome
        ]);
    }

    public function actionCreateCategory()
    {
        $model = new CategoriesIncome();
        $userId = Yii::$app->user->identity->getId();
        $categories = CategoriesIncome::find()
            ->where(['static' => 1])
            ->all();

        if ($post = Yii::$app->request->post('CategoriesIncome')) {


            if (!empty($post['createCategory'])) {
                $post['name'] = $post['createCategory'];
            }


            $dataModel = CategoriesIncome::addOrCreate($post['name'], $userId);



            if ($dataModel->save()) {
                return $this->refresh();
            }

        }


        return $this->render('createCategory', [
            'model' => $model,
            'errors' => isset($dataModel) ? $dataModel : [],
            'categories' => $categories,
            'userCategories' => CategoryIncomeUsers::categoriesOfUser($userId)
        ]);
    }

    public function actionCreateIncome()
    {
        $userId = Yii::$app->user->identity->getId();

        $model = new IncomeUsers();
        $date = (new \DateTime())->format('Y-m-d');
        $model->date = $date;
        $model->user_id = $userId;

        $categoriesUser = CategoryIncomeUsers::categoriesOfUser($userId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        } else {
            return $this->render('createIncome' , [
                'model' => $model,
                'categoriesUser' => $categoriesUser
            ]);
        }


    }

    public function actionUpdateIncome($id)
    {
        $userId = Yii::$app->user->identity->getId();

        $model = IncomeUsers::findOne($id);
        $date = (new \DateTime($model->date))->format('Y-m-d');
        $model->date = $date;
        $model->user_id = $userId;
        $model->income = $model->income / 100;

        $categoriesUser = CategoryIncomeUsers::categoriesOfUser($userId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        } else {
            return $this->render('updateIncome' , [
                'model' => $model,
                'categoriesUser' => $categoriesUser
            ]);
        }
    }

    public function actionDeleteIncome($id)
    {
        $model = IncomeUsers::findOne($id);
        if ($model->delete()) {
            return $this->redirect(['/income']);
        }

    }

}
