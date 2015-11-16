<?php

namespace frontend\modules\savings\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goals_savings".
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 */
class GoalsUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goals_savings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'user_id' => 'User ID',
        ];
    }


    public static function goalsOfUser($id)
    {
        if ($id && is_int($id)) {
            return ArrayHelper::map(self::find()
                ->where(['user_id' => $id])
                ->all(), 'id', 'name');
        }
        return false;

    }


}
