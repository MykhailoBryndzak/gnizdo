<?php

namespace frontend\modules\income\models;

use Yii;

/**
 * This is the model class for table "income_users".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $user_id
 * @property integer $income
 * @property string $description
 * @property string $date
 */
class IncomeUsers extends \yii\db\ActiveRecord
{
    public $createCategory;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'income_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id' , 'user_id', 'income'], 'required'],
            [['user_id'], 'integer'],
            [['income'], 'validateCurrency'],
            [['description'], 'string'],
            [['date' , 'description', 'createCategory'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категорія',
            'user_id' => 'User ID',
            'income' => 'Заробіток',
            'description' => 'Опис',
            'date' => 'Date',
        ];
    }

    public function beforeValidate()
    {
        if (is_numeric($this->createCategory)) {
            $this->addError('category_id' , 'Категорія не може містити тільки цифри!');
        } else if (!empty($this->createCategory)) {
            $this->category_id = $this->createCategory;
            return true;
        } else {
            return true;
        }

        parent::beforeValidate();
    }

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            if (!is_numeric($this->category_id)) {
                $id = Yii::$app->user->identity->id;
                $model = new CategoriesIncome();
                $model->name = $this->category_id;
                $model->user_id = $id;
                $model->static = 0;
                if ($model->save(false)) {
                    $categoryId = $model->id;
                }
            } else {
                $categoryId = $this->category_id;
            }

            $this->category_id = $categoryId;
            $this->income = (int) self::multiplyOn100($this->income);

            return true;
        } else {
            return false;
        }
    }



    public function validateCurrency($attribute, $params)
    {
        $value = self::multiplyOn100($this->$attribute);

        if ((int)$value != $value) {
            $this->addError($attribute, 'Максимально 2 символи після розділювача.');
        }

    }

    private static function multiplyOn100($number)
    {
        return $number * 100;
    }

    public static function sumAllIncomeUser($id)
    {
        $data = self::find()
            ->select('income')
            ->where(['user_id' => $id])
            ->all();
        $sumIncome = 0;
        foreach ($data as $item) {
            $sumIncome += $item->income;
        }

        return ($sumIncome / 100);

    }

    public static function getLastRecordIncome($id)
    {
        return self::find()
            ->where(['user_id' => $id])
            ->orderBy('date DESC')
            ->limit(3)
            ->all();
    }
}
