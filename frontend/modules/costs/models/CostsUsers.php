<?php

namespace frontend\modules\costs\models;

use Faker\Provider\cs_CZ\DateTime;
use Yii;

/**
 * This is the model class for table "costs_users".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $user_id
 * @property integer $cost
 * @property string $description
 * @property string $date
 */
class CostsUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'costs_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'cost', 'category_id'], 'required'],
            [['user_id'], 'integer'],
            [['cost'], 'validateCurrency'],
            [['description'], 'string'],
            [['date' , 'description'], 'safe']
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
            'cost' => 'Витрата',
            'description' => 'Опис',
            'date' => 'Date',
        ];
    }




//    public function beforeValidate()
//    {
//        if (empty($this->category_id) || empty($this->createCategory)) {
//            $this->addError('category_id' , 'Категорія не може пустою!');
//        }
//
//        if (is_numeric($this->createCategory)) {
//            $this->addError('category_id' , 'Категорія не може містити тільки цифри!');
//        } else if (!empty($this->createCategory)) {
//            $this->category_id = $this->createCategory;
//            return true;
//        } else {
//            $this->category_id = $this->createCategory;
//            return true;
//        }
//
//        parent::beforeValidate();
//    }


    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
//            if (!is_numeric($this->category_id)) {
//                $id = Yii::$app->user->identity->id;
//                $model = new CategoriesCosts();
//                $model->name = $this->category_id;
//                $model->user_id = $id;
//                $model->static = 0;
//                if ($model->save(false)) {
//                    $categoryId = $model->id;
//                }
//            } else {
//                $categoryId = $this->category_id;
//            }
//
//            $this->category_id = $categoryId;
            $this->cost = (int) self::multiplyOn100($this->cost);

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

    public static function sumAllCostsUser($id)
    {
        $data = self::find()
                ->select('cost')
                ->where(['user_id' => $id])
                ->all();
        $sumCosts = 0;
        foreach ($data as $item) {
            $sumCosts += $item->cost;
        }

        return ($sumCosts / 100);

    }

    public static function getLastRecordCosts($id)
    {
        return self::find()
        ->where(['user_id' => $id])
        ->orderBy('date DESC')
        ->limit(3)
        ->all();
    }




}
