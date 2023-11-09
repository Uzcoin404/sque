<?php
 
namespace app\models;
 
use Yii;
use yii\base\Model;
use app\models\User;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * Signup form
 */
class SignupForm extends Model
{
 
    public $username;
    public $email;
    public $password;
    public $repassword;
    public $grand;
    public $image;
    public $verifyCode;
    public $polit;
    
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такое имя пользователя уже используется.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            //['email', 'string', 'max' => 255],
           // ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такой Email уже используется.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['repassword', 'string', 'min'=>6],
            ['grand', 'string'],
            [['polit'], 'required', 'requiredValue' => 1],
            ['image', 'string'],
            ['verifyCode', 'required'],
            ['verifyCode', 'captcha','captchaAction'=>'/registration/captcha'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => ''.Yii::t('app','Enter Your Email').'',
            'username'=>''.Yii::t('app','Come up with a login').'',
            'password'=>''.Yii::t('app','Come up with a password').'',
            'repassword'=>''.Yii::t('app','Repeat the password').'',
            'grand'=>''.Yii::t('app','Citizenship').'',
            'image'=>''.Yii::t('app','Image').'',
            'verifyCode'=>''.Yii::t('app','VerifyCode').'',
            'polit'=>''.Yii::t('app','I accept the terms of the User Agreement and the Privacy Policy').''
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */

    public function changePassword($user){
        $password=$this->gen_password(8);
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->save();
        $this->SendMail(
            $user->email,
            "<h3>Ваш новый пароль: ".$password."</h3>",
            "Вы изменили пароль"
        );
    }
    public function signup()
    { 
 
        if (!$this->validatemain()) {
            return null;
        }
      
 
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $password=$this->password;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->status=0;
        $user->create_at=strtotime('now');
        $user->accessToken=MD5($user->create_at."".$user->username."".$user->email);
        $user->grand=$this->grand;
        $user->read = 1;
        $user->image= 'user.png';
        if( $this->SendMail(
            $user->email,
            "<h3>Добро пожаловать!</h3><br>Ваш аккаунт на сайте SQ был создан.<br>Чтобы подтвердить адрес электронной почты и войти в аккаунт, пожалуйста, перейдите по этой ссылке: <br> <a href='https://que.mrtruman.ru/activate/".$user->accessToken."'>https://que.mrtruman.ru/activate/".$user->accessToken."</a><br><br><h3>Ваш пароль для входа в аккаунт: ".$password."</h3><br>Если у Вас возникли трудности или есть вопросы, связанные с использованием сервиса SQ, пожалуйста, свяжитесь с нами по адресу <a href='mailto:support@mrtruman.ru'>support@mrtruman.ru</a><br>",
            "Регистрация на сайте SQ"
        )){
            
            if($user->save()){
                return $user;
            }
            
        }
        return null;
    }

    private function validatemain(){
        $user =User::find()->where(
            [
                'username'=>$this->username
            ]
        )->one();
       
        if(isset($user->id)) return 0;
        $user =User::find()->where(
            [
                'email'=>$this->email
            ]
        )->one();
    
        if(isset($user->id)) return 0;
        $EmailValidator = new yii\validators\EmailValidator();

        if (!$EmailValidator->validate($this->email, $error)) {
            return 0;
        } 
        return 1;
    }
    public function SendMail($to,$body,$subject)
    {

       
        Yii::$app->mailer->compose()
        ->setTo([$to])
        ->setFrom("zakaz@mrtruman.ru")
        ->setSubject($subject)
        ->setHtmlBody($body)
        ->send();
            return true;
 
   
    }

    private function gen_password($length = 6)
    {
        $password = '';
        $arr = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 
            'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
        );
    
        for ($i = 0; $i < $length; $i++) {
            $password .= $arr[random_int(0, count($arr) - 1)];
        }
        return $password;
    }

    public function getListGrand(){
        return ArrayHelper::map(Grand::find()->where(["status"=>1])->all(),'id','name');
    }
 
}