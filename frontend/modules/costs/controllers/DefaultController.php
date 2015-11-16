<?php

namespace frontend\modules\costs\controllers;

use frontend\assets\AppAsset;
use Yii;
use yii\bootstrap\ActiveForm;
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
use yii\web\Response;


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
                'only' => [
                    'index',
                    'createCategory',
                    'createCost',
                    'updateCost',
                    'update',
//                    'add-view',
                    'add',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'createCategory',
                            'createCost',
                            'updateCost',
                            'update',
//                            'add-view',
                            'add',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['post'],
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

        $model = new CostsUsers();
        $categoriesUser = CategoryCostsUsers::categoriesOfUser($userId);



        return $this->render('index', [
            'costsUser' => $models,
            'sumCosts' => $sumCosts,
            'pages' => $pages,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model' => $model,
            'categoriesUser' => $categoriesUser
        ]);
    }

    public function actionAdd()
    {
        $userId = Yii::$app->user->identity->getId();
        $request = Yii::$app->request;

        if ($request->post('CostsUsers')) {
            $model = new CostsUsers();
            $model->user_id = $userId;

            if ($model->load($request->post()) && $model->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Запис додано.');
                return $this->redirect(['/costs']);
            } else {
                \Yii::$app->getSession()->setFlash('error', 'Error');
                return $this->redirect(['/costs']);
            }
        }

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


    public function actionUpdate($id)
    {
            $userId = Yii::$app->user->identity->getId();

            $model = CostsUsers::findOne($id);
            $date = (new \DateTime($model->date))->format('Y-m-d');
            $model->date = $date;
            $model->user_id = $userId;
            $model->cost = $model->cost / 100;

            $categoriesUser = CategoryCostsUsers::categoriesOfUser($userId);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                \Yii::$app->getSession()->setFlash('info', 'Запис оновлено.');
                return $this->redirect(['/costs']);
            } else {
                return $this->renderAjax('ajaxUpdate', [
                    'model' => $model,
                    'categoriesUser' => $categoriesUser
                ]);
            }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/costs']);

    }

    /**
     * Finds the CostsUsers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CostsUsers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CostsUsers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }




}
