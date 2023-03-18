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
            <div class="menu__list_element_logo"></div>
            <div class="menu__list_element_search">
              <input type="text" name="" id="" placeholder="<?=\Yii::t('app', 'Search');?>">
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
</header>