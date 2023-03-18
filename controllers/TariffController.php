<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\Queue;
use app\models\User;
use app\models\Pay;

// AJAX
use yii\widgets\ActiveForm;
class TariffController extends Controller
{
    private $login="writers.online";
    private $pass1="K78LuJ6k1lsOGUIkY8mf";//"MGny994QSg6h2EhqARiw";
    private $pass2="mp5h8iad2Ji9qGgXo2bt";//"N56sLSZlSi96xTtHpd7C";
    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','result','success','fail'],
                'rules' => [
                    [
                        'actions' => ['result','success','fail'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','result','success','fail','pay'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            
        ];
    }

   
    //Главный экран
    public function actionIndex()
    {
        $request = \Yii::$app->getRequest();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isPost) {
            $user = Yii::$app->user->identity;
            return [
                'form' =>  $this->renderAjax('_form_update', [
                                "model"=>$user,
                ]),
                "success"=>1,
            ];
        }
        return [
            "success"=>0
        ];
    }

    public function actionPay(){
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $user = Yii::$app->user->identity;
            $value=$request->post();
            $Pay=new Pay();
            $Pay->user_id=$user->id;
            $Pay->coast=$value["coast"];
            $Pay->status=1;
            $Pay->date=strtotime('now');
            $Pay->count_day=$value["count_day"];
            if($Pay->save()){
                $out_sum = trim(htmlspecialchars(strip_tags($Pay->coast)));
                $inv_id = $Pay->id;
                $receipt = urlencode("Оплата за предоставление консультации");
                $receipt_urlencode = urlencode($receipt);
                $inv_desc = "Заказ №".$Pay->id;
                $crc = md5("$this->login:$out_sum:$inv_id:$receipt:$this->pass1");
    
                return [
                    "success"=>1,
                    "url"=>"https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$this->login&".
                    "OutSum=$out_sum&InvId=$inv_id&Receipt=$receipt_urlencode&Desc=$inv_desc&".
                    "SignatureValue=$crc"
                ];
            }

        }
        return [
            "success"=>0
        ];
    }

    //Ещё один экшн который будет редиректить или таск для проверки
    public function actionResult(){
        if(!isset($_REQUEST["InvId"])) return ;
        $out_summ = $_REQUEST["OutSum"];
        $inv_id = $_REQUEST["InvId"];
        $crc = strtoupper($_REQUEST["SignatureValue"]);
 
        $my_crc = strtoupper(md5("$out_summ:$inv_id:$$this->pass2"));
        
        if ($my_crc != $crc)
        {
            return $this->render("error",['name'=>"Ошибка оплаты",'message'=>"Произошла непредвиденная ошибка, попробуйте чуть позже"]);
        }
      
        
    }

    public function actionSuccess(){
        if(!isset($_REQUEST["InvId"])) return ;

        $out_summ = $_REQUEST["OutSum"];
        $inv_id = $_REQUEST["InvId"];
        $crc = $_REQUEST["SignatureValue"];

        $crc = strtoupper($crc);  

        // build own CRC
        $my_crc = strtoupper(md5("$out_summ:$inv_id:$$this->pass1"));

        if ($my_crc != $crc)
        {
            return $this->render("error",['name'=>"Ошибка оплаты",'message'=>"Произошла непредвиденная ошибка, попробуйте чуть позже"]);
        }
        $Pay=Pay::findOne($inv_id);
        $Pay->status=0;
        if($Pay->save()){
            $user=User::findOne($Pay->user_id);
            $user->end_at=strtotime($user->end_at.'+ '.$Pay->count_day." days");
            $user->status=1;
            if($user->save()){
                return $this->render("error",['name'=>"Спасибо за оплат!",'message'=>"Ваша оплата принята"]);
            }
        }
        return $this->render("error",['name'=>"Ошибка оплаты",'message'=>"Произошла непредвиденная ошибка, попробуйте чуть позже"]);
    }

    public function actionFail(){
        return $this->render("error",['name'=>"Ошибка оплаты",'message'=>"Произошла непредвиденная ошибка, попробуйте чуть позже"]);
    }
  
}
