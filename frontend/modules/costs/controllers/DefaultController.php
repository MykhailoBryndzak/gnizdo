<?php

namespace frontend\modules\costs\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\modules\costs\models\CategoriesCosts;
use frontend\modules\costs\models\CategoryCostsUsers;
use frontend\modules\costs\models\CostsUsers;
use frontend\modules\costs\models\search\CostsUsersSearch;
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
                'only' => ['index', 'createCategory', 'createCost', 'updateCost', 'update'],
                'rules' => [
                    [
                        'actions' => ['index', 'createCategory', 'createCost', 'updateCost', 'update'],
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

        $costsUser = CostsUsers::find()->where(['user_id' => $userId]);
        $countQuery = clone $costsUser;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize'=>10]);
        $models = $costsUser->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $sumCosts = CostsUsers::sumAllCostsUser($userId);

        $searchModel  = new CostsUsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=5;


        return $this->render('index', [
            'costsUser' => $models,
            'sumCosts' => $sumCosts,
            'pages' => $pages,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionAdd()
    {
        $userId = Yii::$app->user->identity->getId();

        $request = Yii::$app->request;
        if ($request->isAjax) {

            $model = new CostsUsers();
            $date = (new \DateTime())->format('Y-m-d');
            $model->date = $date;
            $model->user_id = $userId;

            $categoriesUser = CategoryCostsUsers::categoriesOfUser($userId);

            echo $this->renderAjax('ajaxAdd', [
                'model' => $model,
                'categoriesUser' => $categoriesUser
            ]);
        }

        if ($request->isAjax && $post = $request->post('CostsUsers')) {

            $model = new CostsUsers();
            $model->user_id = $userId;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Запис додано.');
                return $this->redirect(['/costs']);
            } else {
                return $this->redirect(['/costs']);
            }
        }
    }


    public function actionArchive()
    {

    }

    public function actionCreateCategory()
    {
        $model = new CategoriesCosts();
        $userId = Yii::$app->user->identity->getId();
        $categories = CategoriesCosts::find()
            ->where(['static' => 1])
            ->all();

        if ($post = Yii::$app->request->post('CategoriesCosts')) {


            if (!empty($post['createCategory'])) {
                $post['name'] = $post['createCategory'];
            }


            $dataModel = CategoriesCosts::addOrCreate($post['name'], $userId);



            if ($dataModel->save()) {
                return $this->refresh();
            }

        }


        return $this->render('createCategory', [
            'model' => $model,
            'errors' => isset($dataModel) ? $dataModel : [],
            'categories' => $categories,
            'userCategories' => CategoryCostsUsers::categoriesOfUser($userId)
        ]);
    }


    public function actionUpdateCost($id)
    {
        $userId = Yii::$app->user->identity->getId();

        $model = CostsUsers::findOne($id);
        $date = (new \DateTime($model->date))->format('Y-m-d');
        $model->date = $date;
        $model->user_id = $userId;
        $model->cost = $model->cost / 100;

        $categoriesUser = CategoryCostsUsers::categoriesOfUser($userId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        } else {
            return $this->render('updateCost' , [
                'model' => $model,
                'categoriesUser' => $categoriesUser
            ]);
        }
    }

    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if ($request->isAjax && $id = $request->post('id')) {

            $userId = Yii::$app->user->identity->getId();
            $model = CostsUsers::findOne($id);
            $date = (new \DateTime($model->date))->format('Y-m-d');
            $model->date = $date;
            $model->user_id = $userId;
            $model->cost = $model->cost / 100;

            $categoriesUser = CategoryCostsUsers::categoriesOfUser($userId);

            echo $this->renderPartial('ajaxUpdate', [
                'model' => $model,
                'categoriesUser' => $categoriesUser
            ]);
        }

        if ($request->isPost && $post = $request->post('CostsUsers')) {
//            echo '<pre>';
//            var_dump($post);
//            die;
            $model = CostsUsers::findOne($post['id']);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                \Yii::$app->getSession()->setFlash('error', 'Your Text Here..');
                return $this->redirect(['/costs']);
            } else {
                return $this->redirect(['/costs']);
            }
        }
    }

    public function actionDeleteCost($id)
    {
        $model = CostsUsers::findOne($id);
        if ($model->delete()) {
            return $this->redirect(['/costs']);
        }

    }




}
