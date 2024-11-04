<?PHP

use app\models\Docs;
?>

<style>
  .disclaimer .btn_questions,
  .minimized .btn_questions {
    /* position: absolute;
    top: 0;
    left: 0; */
    color: #fff;
    padding: 15px 25px;
    border: none;
    width: max-content;
    background: #116edd;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.5s ease-in-out;
    z-index: 10;
    height: max-content;
    font-size: 16px;

    &:hover {
      background: #5f5fce;
    }

    &:focus {
      border: none !important;
    }
  }

  .disclaimer .wrapp {
    position: static !important;
    transform: none !important;
    width: 100% !important;
    border-radius: 0 !important;
    max-height: 700px !important;
  }

  .cookies_wrapper {
    position: absolute;
    top: 10%;
    left: 50%;
    transform: translateX(-50%);
    max-width: 1200px;
    width: 80%;
    margin-bottom: 40px;
    display: none;

    &.active {
      display: block;
    }
  }

  .minimized {
    position: fixed;
    bottom: -100%;
    right: 30px;
    display: flex;
    gap: 15px;
    transition: .3s;
  }

  .minimized.active {
    bottom: 30px;
  }

  .form-modal__footer-btn {
    width: 100%;
    padding: 15px 40px;
    background: #ff0;
    color: #000;
    border: 1px solid #ff0;
    font-size: 16px;
    font-weight: 500;

    &:hover {
      color: #000;
      background-color: #ff0;
    }
  }
  .menu_mobile__list_element_control{
    z-index: 1;
  }
</style>
<footer>

  <div class="menu_left__list">
    <div class="menu_left__list_element">
      <ul>
        <li>
          <a href="/docs/term" target="_blank">
            <?= \Yii::t('app', 'Terms of Use'); ?>
          </a>
        </li>
        <li>
          <a href="/docs/privacy" target="_blank">
            <?= \Yii::t('app', 'Privacy policy'); ?>
          </a>
        </li>
        <li>
          <a href="/docs/register" target="_blank"><?= \Yii::t('app', 'Disclaimer for registered users'); ?></a>
        </li>
        <li>
          <a href="/docs/unregister" target="_blank"><?= \Yii::t('app', 'Disclaimer for Unregistered Users'); ?></a>
        </li>
        <li>
          <a href="/docs/cookie" target="_blank"><?= \Yii::t('app', 'Cookie Policy'); ?></a>
        </li>
      </ul>
    </div>
  </div>


</footer>


<div class="disclaimer ">
  <div class="bg"></div>
  <div class="cookies_wrapper active">
    <button class="btn_questions" onclick="HidePopup()">Minimize</button>
    <div class="wrapp">
      <div class="title -mt-4">
        <?PHP $title = Docs::find()->where(["href" => "popup_title", "status" => 1])->one(); ?>
        <?PHP if (isset($title->id)): ?>
          <h2><?= $title->text; ?></h2>
        <?PHP endif; ?>
      </div>
      <div class="body">
        <?PHP $text = Docs::find()->where(["href" => "popup_text", "status" => 1])->one(); ?>

        <?PHP if (isset($text->id)): ?>
          <?= $text->text; ?>
        <?PHP endif; ?>

      </div>
      <div class="disclaimer__list_list">
        <a href="/docs/term" target="_blank">
          <?= \Yii::t('app', 'Terms of Use'); ?>
        </a>
        <a href="/docs/privacy" target="_blank">
          <?= \Yii::t('app', 'Privacy policy'); ?>
        </a>

        <a href="/docs/unregister" target="_blank"><?= \Yii::t('app', 'Disclaimer for Unregistered Users'); ?></a>
        <a href="/docs/cookie" target="_blank"><?= \Yii::t('app', 'Cookie Policy'); ?></a>

      </div>
      <div class="footer">
        <button type="submit" class="btn form-modal__footer-btn" onClick="AccptCookie();">
          <i class="bi bi-arrow-right-square"></i><?= \Yii::t('app', 'Accept and continue'); ?>
        </button>
      </div>
    </div>
  </div>
  <div class="minimized">
    <button class="btn btn_questions" onclick="ShowPopup()">Expand</button>
    <button type="submit" class="btn form-modal__footer-btn" onClick="AccptCookie();">
      <i class="bi bi-arrow-right-square"></i><?= \Yii::t('app', 'Accept and continue'); ?>
    </button>
  </div>
</div>

<script>
  function AjxFilter(sorts) {
    $.post(
      '/question/filter', {
        '".Yii::app()->getRequest()->csrfTokenName."': '".Yii::app()->getRequest()->csrfToken."',
        'sorts': sorts,
      }).done(function(response) {
      response = JSON.parse(response);

      if (response.status == 1) {
        $('.questions.close .questions__list').empty();
        $('.questions.close .questions__list').append(response.result);
      }

    }).fail(function(xhr, status, error) {
      console.log('error AjxSetCar');
    });
  }

  function AjxFilterLike(id, sorts) {
    $.post(
      '/like/filterlike', {
        '".Yii::app()->getRequest()->csrfTokenName."': '".Yii::app()->getRequest()->csrfToken."',
        'id': id,
        'sorts': sorts,
      }).done(function(response) {
      response = JSON.parse(response);

      if (response.status == 1) {
        $('.answers_post .answers_post__list').empty();
        $('.answers_post .answers_post__list').append(response.result);
        console.log(response.sort);
      }

    }).fail(function(xhr, status, error) {
      console.log('error AjxSetCar');
    });
  }

  function AjxFilterDislike(id, sorts) {
    $.post(
      '/dislike/filterdislike', {
        '".Yii::app()->getRequest()->csrfTokenName."': '".Yii::app()->getRequest()->csrfToken."',
        'id': id,
        'sorts': sorts,
      }).done(function(response) {
      response = JSON.parse(response);

      if (response.status == 1) {
        $('.answers_post .answers_post__list').empty();
        $('.answers_post .answers_post__list').append(response.result);
        console.log(response.sort);
      }

    }).fail(function(xhr, status, error) {
      console.log('error AjxSetCar');
    });
  }
</script>