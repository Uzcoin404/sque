
<?php $user=Yii::$app->user->identity; ?>
  <div class="menu_left__list">
    <div class="menu_left__list_element">
      <ul>
        <li>
          <a href="">
            <?=\Yii::t('app', 'Read rules');?>
          </a>
        </li>
        <li>
          <a href="">
            <?=\Yii::t('app', 'Go to the chat');?>
          </a>
        </li>
        <li>
          <a href="/">
            <?=\Yii::t('app', 'Questions list');?>
          </a>
        </li>
        <?php
              if($user){
        ?>
        <li>
          <a href="">
            <?=\Yii::t('app', 'User avatar');?>
          </a>
        </li>
        <li>
          <a href="/questions/myquestions">
            <?=\Yii::t('app', 'My questions');?>
          </a>
        </li>
        <?php
              }
        ?>
      </ul>
    </div>
  </div>
