<?php

namespace app\modules\v1\controllers;

use app\models\Product;
use PHPUnit\Framework\Constraint\IsTrue;
use Yii;

class ProductController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;
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
  
    // public function actionProducts()
    // {
    //     \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON; //retour reponse en json
    //     $product=Product::find()->all();
    //     if(count($product)>0){
    //         return array('status'=>true,'data'=>$product);
    //     }else{
    //         return array('status'=>false,'data'=>'0 produits');
    //     }
    // }


    //  lien api :http://localhost/TestYiiDola/web/index.php?r=v1/product/allproducts
    // authentification bearer token
    //pour l'user deja cree dans la base de donnees
    public function actionAllproducts()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON; //retour reponse en json
        $product = [
            ['id' => 1, 'name' => 'Electronic Device', 'reference' => 'ABC123', 'category' => 'Electronics', 'color' => 'Silver'],
            ['id' => 2, 'name' => 'Casual T-shirt', 'reference' => 'DEF456', 'category' => 'Clothing', 'color' => 'Blue'],
            ['id' => 3, 'name' => 'Running Shoes', 'reference' => 'GHI789', 'category' => 'Footwear', 'color' => 'Red'],
            ['id' => 4, 'name' => 'Coffee Maker', 'reference' => 'JKL012', 'category' => 'Electronics', 'color' => 'Black'],
            ['id' => 5, 'name' => 'Smart Watch', 'reference' => 'MNO345', 'category' => 'Electronics', 'color' => 'Black'],
            ['id' => 6, 'name' => 'Leather Wallet', 'reference' => 'PQR678', 'category' => 'Accessories', 'color' => 'Brown'],
            ['id' => 7, 'name' => 'Sunglasses', 'reference' => 'STU901', 'category' => 'Accessories', 'color' => 'Black'],
            ['id' => 8, 'name' => 'Electronic Device', 'reference' => 'ABC123', 'category' => 'Electronics', 'color' => 'Black'],
            ['id' => 9, 'name' => 'Casual T-shirt', 'reference' => 'DEF456', 'category' => 'Clothing', 'color' => 'Black'],
            ['id' => 10, 'name' => 'Running Shoes', 'reference' => 'GHI789', 'category' => 'Footwear', 'color' => 'White'],
            ['id' => 11, 'name' => 'Coffee Maker', 'reference' => 'JKL012', 'category' => 'Electronics', 'color' => 'Silver'],
            ['id' => 12, 'name' => 'Smart Watch', 'reference' => 'MNO345', 'category' => 'Electronics', 'color' => 'Silver'],
            ['id' => 13, 'name' => 'Leather Wallet', 'reference' => 'PQR678', 'category' => 'Accessories', 'color' => 'Black'],
            ['id' => 14, 'name' => 'Sunglasses', 'reference' => 'STU901', 'category' => 'Accessories', 'color' => 'Blue'],
            ['id' => 15, 'name' => 'Electronic Device', 'reference' => 'ABC123', 'category' => 'Electronics', 'color' => 'Red'],
            ['id' => 16, 'name' => 'Casual T-shirt', 'reference' => 'DEF456', 'category' => 'Clothing', 'color' => 'Gray'],
            ['id' => 17, 'name' => 'Running Shoes', 'reference' => 'GHI789', 'category' => 'Footwear', 'color' => 'Brown'],
            ['id' => 18, 'name' => 'Coffee Maker', 'reference' => 'JKL012', 'category' => 'Electronics', 'color' => 'White'],
            ['id' => 19, 'name' => 'Smart Watch', 'reference' => 'MNO345', 'category' => 'Electronics', 'color' => 'Gold'],
            ['id' => 20, 'name' => 'Leather Wallet', 'reference' => 'PQR678', 'category' => 'Accessories', 'color' => 'Tan'],
        ];
        
        if(count($product)>0){
            $resultat=array();
            $diffref=array();
            $occurence=array();
            for($i=0;$i<count($product);$i++){
                
                for($j=1;$j<count($product);$j++){
                   
                    if($i!=$j){
                        if($product[$i]['reference']==$product[$j]['reference']){
                            $product[$i]['color']=$product[$i]['color'].','.$product[$j]['color'];
                            
                        }
                        else{
                            $diffref[]=$product[$i]; 
                        }
                       
                    }
                
                } 
                
                    $occurence[]= $product[$i];
            }
            
            $resultat=$occurence;
            return array('status'=>true,'data'=>$resultat);
        }else{
            return array('status'=>false,'data'=>'0 product');
        }
    }
  
}
