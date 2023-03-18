<?PHP 
  use app\modules\books\models\Books;
  use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use kartik\select2\Select2
  ?>
<?PHP 
  $user=Yii::$app->user->identity;
  
  if($user){
    $active_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one();
  }
  
?>

<div class="menu">
  <div class="menu__list">
    <div class="menu__list_element">
          <div class="menu__list_element_logo"></div>
          <div class="menu__list_element_search">
            <input type="text" name="" id="" placeholder="Поиск">
          </div>
          <?php
            if($user){
          ?>
            <div class="menu__list_element_user">
              <div class="menu__list_element_user_money">
                  <div class="menu__list_element_user_money_logo"></div>
                  <?php
                    if(!$user->money){
                  ?>
                    <a href="">0</a>
                  <?php
                    } else {
                  ?>
                    <a href=""><?=$user->money?></a>
                  <?php
                    }
                  ?>
              </div>
              <div class="menu__list_element_user_avatar">
                  <a href=""><?=$user->username?></a>
              </div>
            <?php
              }
            ?>
            <div class="menu__list_element_user_logout">
                
                <?php
                  if(!$user){
                ?>
                  <a href="/login">Войти</a>
                  <a href="/registration">Регистрации</a>
                <?php
                  } else {
                ?>
                  <a href="/logout">Выйти</a>
                <?php
                  }
                ?>
            </div>
          </div>
    </div>
  </div>
</div>
<div class="menu_left">
  <div class="menu_left__list">
    <div class="menu_left__list_element">
      <ul>
        <li><a href="">Правила</a></li>
        <li><a href="">Чат</a></li>
        <li><a href="">Вопросы</a></li>
        <li><a href="">Аватар</a></li>
      </ul>
    </div>
  </div>
</div>