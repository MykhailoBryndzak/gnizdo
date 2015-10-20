<?php

namespace frontend\modules\savings\models;

use Yii;

/**
 * This is the model class for table "savings_users".
 *
 * @property integer $id
 * @property integer $goal_id
 * @property integer $user_id
 * @property integer $saving
 * @property string $description
 * @property string $date
 */
class SavingsUsers extends \yii\db\ActiveRecord
{
    public $createGoal;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'savings_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goal_id', 'user_id', 'saving', 'description'], 'required'],
            [['saving'], 'validateCurrency'],
            [['goal_id', 'user_id', 'saving'], 'integer'],
            [['description'], 'string'],
            [['date', 'createGoal'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goal_id' => 'Goal ID',
            'user_id' => 'User ID',
            'saving' => 'Saving',
            'description' => 'Description',
            'date' => 'Date',
        ];
    }

    public static function getLastRecordSavings($id)
    {
        return self::find()
            ->where(['user_id' => $id])
            ->orderBy('date DESC')
            ->limit(3)
            ->all();
    }

    public function beforeValidate()
    {
        if (empty($this->createGoal) && empty($this->goal_id)) {
            $this->addError('goal_id', 'Ціль не може бути пустою!');
        } else if (!empty($this->goal_id)) {
            return true;
        } else {
            $modelGoal = new GoalsUsers();
            $modelGoal->user_id = Yii::$app->user->identity->getId();
            $modelGoal->name = $this->createGoal;
            if ($modelGoal->save(false)) {
                $this->goal_id = $modelGoal->id;
                return true;
            }
        }

        parent::beforeValidate();
    }

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            $this->saving = (int) self::multiplyOn100($this->saving);
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

    public static function sumAllSavingsUser($id)
    {
        $data = self::find()
            ->select('saving')
            ->where(['user_id' => $id])
            ->all();
        $sumCosts = 0;
        foreach ($data as $item) {
            $sumCosts += $item->saving;
        }

        return ($sumCosts / 100);

    }
}
