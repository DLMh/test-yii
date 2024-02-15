<?php

namespace app\modules\v1\controllers;

use app\models\Utilisateur;

class UtilisateurController extends \yii\web\Controller
{
    public function behaviors()
    {
        $behaviors=parent::behaviors();
        $behaviors['authentificator']=[
            'class' => \yii\filters\auth\HttpBearerAuth::class
        ];
        return $behaviors;
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionUtilisateurs()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON; //retour reponse en json
        $u=Utilisateur::find()->all();
        if(count($u)>0){
            return array('status'=>true,'data'=>$u);
        }else{
            return array('status'=>false,'data'=>'0 utilisateur');
        }
    }
}
