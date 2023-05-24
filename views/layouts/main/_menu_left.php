
<?php 
  $key = "jG23zxcmsEKs**aS431";
  $user=Yii::$app->user->identity; 
?>
  <div class="menu_left__list">
    <div class="menu_left__list_element">
      <ul>
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
        <li>
          <a href="/questions/voting">
            <?=\Yii::t('app', 'Voting questions');?>
          </a>
        </li>
        <?php
          if($user && $user->read == 1){
        ?>
            <?php
              if($user->moderation == 1 && $user->key == $key){
            ?>
              <li>
                <a href="/questions/moderation">
                  <?=\Yii::t('app', 'Moderation');?>
                </a>
              </li>
              <li>
                <a href="/complaints/moderation">
                  <?=\Yii::t('app', 'Complaint');?>
                </a>
              </li>
              <li>
                <a href="/list_chat">
                  <?=\Yii::t('app', 'Go to the chat');?>
                </a>
              </li>
              <li>
                <a href="/user">
                  <?=\Yii::t('app', 'List users');?>
                </a>
              </li>
              <li>
                <a href="/price">
                  <?=\Yii::t('app', 'Price change');?>
                </a>
              </li>
            <?php
              } else {
            ?>
              <li>
                <a href="/chat">
                  <?=\Yii::t('app', 'Go to the chat');?>
                </a>
              </li>
            <?php
              }
            ?>
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
              <a href="/questions/myvoiting">
                <?=\Yii::t('app', 'My voiting');?>
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
      </ul>
    </div>
  </div>
