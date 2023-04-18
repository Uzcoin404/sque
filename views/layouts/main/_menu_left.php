
<?php 
  $key = "jG23zxcmsEKs**aS431";
  $user=Yii::$app->user->identity; 
?>
  <div class="menu_left__list">
    <div class="menu_left__list_element">
      <ul>
        <li>
          <a href="/">
            <?=\Yii::t('app', 'Read rules');?>
          </a>
        </li>
        <li>
          <a href="/">
            <?=\Yii::t('app', 'Go to the chat');?>
          </a>
        </li>
        <li>
          <a href="/">
            <?=\Yii::t('app', 'Questions list');?>
          </a>
        </li>
        <li>
          <a href="/questions/close">
            <?=\Yii::t('app', 'Close questions');?>
          </a>
        </li>
        <?php
          if($user){
        ?>
            <?php
              if($user->moderation == 1 && $user->key == $key){
            ?>
              <li>
                <a href="/questions/moderation">
                  <?=\Yii::t('app', 'Moderation');?>
                </a>
              </li>
            <?php
              }
            ?>
            <li>
              <a href="/questions/voting">
                <?=\Yii::t('app', 'Voting questions');?>
              </a>
            </li>
            <li>
              <a href="/questions/myquestions">
                <?=\Yii::t('app', 'My questions');?>
              </a>
            </li>
            <li>
              <a href="/answer/myanswers">
                <?=\Yii::t('app', 'My voting');?>
              </a>
            </li>
            <li>
              <a href="/favourit">
                <?=\Yii::t('app', 'My favourites');?>
              </a>
            </li>
            <li>
              <a href="/question/create">
                <?=\Yii::t('app', 'Create new question');?>
              </a>
            </li>
        <?php
          }
        ?>
        <li>
          <a href="/">
            <?=\Yii::t('app', 'Privacy policy');?>
          </a>
        </li>
      </ul>
    </div>
  </div>
