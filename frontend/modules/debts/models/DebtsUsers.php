<?php

namespace frontend\modules\debts\models;

use Yii;

/**
 * This is the model class for table "debts_users".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $who_lent
 * @property integer $debt
 * @property string $description
 * @property string $date_debts
 * @property integer $status
 */
class DebtsUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debts_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'who_lent', 'debt', 'description', 'date_debts', 'status'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['debt'], 'validateCurrency'],
            [['description'], 'string'],
            [['date_debts'], 'safe'],
            [['who_lent'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'who_lent' => 'Who Lent',
            'debt' => 'Debt',
            'description' => 'Description',
            'date_debts' => 'Date Debts',
            'status' => 'Status',
        ];
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

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {

            $this->debt = (int) self::multiplyOn100($this->debt);

            return true;
        } else {
            return false;
        }
    }

    public static function sumAllDebtsUser($id)
    {
        $data = self::find()
            ->select('debt')
            ->where(['user_id' => $id , 'status' => 0])
            ->all();
        $sumDebts = 0;
        foreach ($data as $item) {
            $sumDebts += $item->debt;
        }

        return ($sumDebts / 100);

    }
}
