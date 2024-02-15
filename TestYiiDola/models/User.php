<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
   
    public $password_hash;
    public $auth_token;

   
    const STATUS_DELETED =0;
    const STATUS_INACTIVE =9;
    const STATUS_ACTIVE =10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE,self::STATUS_INACTIVE,self::STATUS_DELETED]],
        ];
    }

    

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return[
            TimestampBehavior::class,
        ];
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_token'=>$token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
      
        return static::findOne(['username'=>$username,'status'=>self::STATUS_ACTIVE]);
    }

    public static function findByVerificationToken($token)
    {
      
        return static::findOne(['verification_token'=>$token,'status'=>self::STATUS_INACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if(!static::isPasswordResetTokenValid($token)){
            return null;
        }
       return static::findOne([
        'password_reset_token'=>$token,
        'status'=>self::STATUS_ACTIVE,
       ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if(empty($token)){
            return false;
        }
        $timestamp=(int) substr($token,strrpos($token,'_')+1);
        $expire= Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp+$expire>=time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_Key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_Key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password_hash)
    {
        return Yii::$app->security->validatePassword($password_hash,$this->password_hash);
    }

    public function setPassword($password_hash){
        $this->password_hash=Yii::$app->security->generatePasswordHash($password_hash);
    }

    public function generateAuthKey(){
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken(){
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    public function generateEmailVerificationToken(){
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();

    }
}
