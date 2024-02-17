<?PHP 

  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  ?>
<?PHP 
  $user=Yii::$app->user->identity;

?>
<header>
  <div class="menu">
    <div class="menu__list">
      <div class="menu__list_element">
            <a href="/" class="menu__list_element_logo"></a>
            <div class="menu__list_element_search">
              <form action="/questions/search" method="get">
                <?php if(!empty($_GET['text'])){ ?>
                  <input type="text" name="text" id="search-text" placeholder="Поиск" value="<?=$_GET['text']?>">
                <?php } else { ?>
                  <input type="text" name="text" id="search-text" placeholder="Поиск">
                <?php } ?>
                <button></button>
              </form>

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
                <a class="menu__list_element_user_avatar">
                    <button onclick="FormImgSubmit()" class="menu__list_element_user_avatar_img" style="background:url(/img/users/<?=$user->image?>)"></button>
                    <p><?=$user->username?></p>
                </a>
              <?php
                }
              ?>
              <div class="menu__list_element_user_logout">
                  
                  <?php
                    if(!$user){
                  ?>
                    <a href="/login"> <?=\Yii::t('app', 'Login');?></a>
                    <a href="/registration"><?=\Yii::t('app', 'Registration');?></a>
                  <?php
                    } else {
                  ?>
                    <a href="/logout"><?=\Yii::t('app', 'Logout');?></a>
                  <?php
                    }
                  ?>
              </div>
            </div>
    </div>
  </div>
  
  <!-- mobile_menu -->
  <div class="menu_mobile">
    <div class="menu_mobile__list">
      <div class="menu_mobile__list_element">
          <div class="menu_mobile__list_element_control">
            <div class="menu_mobile__list_element_control_burger" onclick="OpenMobileMenu(this)"></div>

          </div>

         
      </div>
    </div>
  </div>
  <!-- /mobile_menu -->


</header>
<?php
  if($user){
?>
  <div class="form_img">
      <div class="form_img_back" onclick="FormImgClose()"></div>
      <?= \app\widgets\ImgUser::widget() ?>
  </div>
<?php
  }
?>