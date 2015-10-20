<?php

namespace frontend\modules\income\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category_income_users".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $user_id
 */
class CategoryIncomeUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_income_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'user_id'], 'required'],
            [['category_id', 'user_id'], 'integer'],
            [['category_id'], 'existInUser'],
        ];
    }

    public function existInUser($attribute)
    {
        $searchCategory = self::find()
            ->where([
                'user_id' => Yii::$app->user->identity->id,
                'category_id' => $this->category_id
            ])
            ->one();
        if ($searchCategory !== NULL) {
            $this->addError($attribute,'Категорія вже існує');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
        ];
    }

    public static function categoriesOfUser($id)
    {
        if ($id && is_int($id)) {
            $categoriesUser = [];
            foreach(self::findAll(['user_id' => $id]) as $category) {
                $categoriesIncome = CategoriesIncome::findOne($category->category_id);
                $categoriesUser[$categoriesIncome->id] = $categoriesIncome ? $categoriesIncome->name : '';
            }

            $createdUserCategory = ArrayHelper::map(CategoriesIncome::find()
                ->where(['user_id' => $id])
                ->all(), 'id', 'name');
            $allCategoriesUser = ArrayHelper::merge($categoriesUser, $createdUserCategory);
            return $allCategoriesUser;
        }

        return false;

    }

    public static function findCategoryInUser($userId)
    {
        $findStaticCategory = self::find()
            ->where(['user_id' => $userId])
            ->one();
        $findCreatedCategory = CategoriesIncome::find()
            ->where(['user_id' => $userId])
            ->one();
        if ($findStaticCategory !== NULL || $findCreatedCategory !== NULL) {
            return true;
        } else {
            return false;
        }
    }
}
