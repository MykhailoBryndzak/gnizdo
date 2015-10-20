<?php

namespace frontend\modules\costs\models;

use Yii;

/**
 * This is the model class for table "categories_costs".
 *
 * @property integer $id
 * @property string $name
 */
class CategoriesCosts extends \yii\db\ActiveRecord
{
    public $createCategory;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories_costs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['static', 'user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['createCategory', 'safe']
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Категорія',
        ];
    }

    public static function addOrCreate($name, $userId)
    {
        if (is_numeric($name)) {
            $model = new CategoryCostsUsers();
            $model->user_id = $userId;
            $model->category_id = $name;
            return $model;
        } else {
            $nameStrToLower = mb_strtolower($name, 'UTF-8');
            $model = new self();
            $model->name = $nameStrToLower;
            $model->user_id = $userId;
            $model->static = 0;
            return $model;
        }

    }

    public static function getNameCategoryById($id)
    {
        return self::findOne($id)->name;
    }

}
