<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "utilisateur".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $auth_token
 */
class Utilisateur extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE ='create';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilisateur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'auth_token'], 'required'],
            [['username'], 'string', 'max' => 100],
            [['password_hash', 'auth_token'], 'string', 'max' => 250],
        ];
    }

    //Creation du scenario d'input
    public function scenarios()
    {
        $scenarios= parent::scenarios();
        $scenarios['create'] = ['username','password_hash','auth_token'];
        return $scenarios;
    }
  

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'auth_token' => 'Auth Token',
        ];
    }
}
