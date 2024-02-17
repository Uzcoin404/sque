
<?php 
 use app\models\Chat;
  $key = "jG23zxcmsEKs**aS431";
  $user=Yii::$app->user->identity; 
?>
  <div class="menu_left__list">
    <div class="menu_left__list_element">
      <div class="menu_mobile__list_element_control_close" onclick="CloseMobileMenu(this)"></div>
      <ul>
      <?php
          if($user && $user->read == 1){
        ?>

      <?php } ?>
            <li>
              <a href="/question/create">
                <?=\Yii::t('app', 'Create new question');?>
              </a>
              <div class="block_btn_info_text_status" data-status="1">
                <div class="btn_info_text" onclick="SubmitInfo(this)" data-status="1">
                  <div class="block_btn_info_text_status_text">
                  
                  </div>
                </div>

              </div>
            </li>
            <li>
              <a href="/">
                <?=\Yii::t('app', 'Here to answer questions');?>
              </a>
              <div class="block_btn_info_text_status" data-status="4">
                <div class="btn_info_text" onclick="SubmitInfo(this)" data-status="4">
                  <div class="block_btn_info_text_status_text">
                  
                  </div>
                </div>

              </div>
            </li>
            <li>
              <a href="/questions/voting">
                <?=\Yii::t('app', 'Vote here for the answers');?>
              </a>
              <div class="block_btn_info_text_status" data-status="5">
                <div class="btn_info_text" onclick="SubmitInfo(this)" data-status="5">
                  <div class="block_btn_info_text_status_text">
                  
                  </div>
                </div>

              </div>
            </li>
            <li>
              <a href="/questions/close">
                <?=\Yii::t('app', 'Archive of questions and answers');?>
              </a>
            </li>
        <?php
          if($user && $user->read == 1){
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
              <?PHP if($user->moderation != 1):?>
                <li>
                  <a href="/chat">
                    <?=\Yii::t('app', 'Go to the chat');?>
                  </a>
                </li>
              <?PHP ENDIF;?>
              <?php
              if($user->moderation == 1 && $user->key == $key){
            ?>
              <li>
                <a href="/table">
                  <?=\Yii::t('app', 'Tables');?>
                </a>
              </li>
              <li>
                <a href="/info_list">
                  <?=\Yii::t('app', 'Que');?>
                </a>
              </li>
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
                  <?=\Yii::t('app', 'Chat list');?>
                  <?PHP IF(Chat::GetAllNoRead()):?>
                    <span class="all_no_read_count"><?=Chat::GetAllNoRead();?></span>
                  <?PHP ENDIF;?>
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
              }
            ?>
        <?php
          }
        ?>
      </ul>
    
    </div>
  </div>
