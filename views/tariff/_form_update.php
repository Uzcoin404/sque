<?PHP
use app\modules\User;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\select2\Select2;

$date_curent=strtotime("now");
$current_day="root";
if(isset($model->end_at)){
  $current_day=floor((abs($date_curent - $model->end_at))/86400)+1;
}
$base_prise=250;
?>
<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">У Вас осталось: <strong><?=$current_day;?> дней</strong></h5>
        <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <div class="container form-modal__container">
          <div class="row form-modal__row">
            <div class="col-12">
              <p>Хотите купить больше дней для пользования сервисом?</p>
            </div>
          </div>
          <div class="row form-modal__row">

              <div class="tariff__tariff col col-md-3">
                <div class="tariff__tariff_element">
                  <strong class="tariff__tariff_name">30 дней</strong>
                  <div class="tariff__tariff_discont"></div>
                  <div class="tariff__tariff_coast"><?=floor(30*$base_prise);?> рублей</div>
                  <a OnClick="PayTariff(<?=floor(30*$base_prise);?>,30)" class="tariff__tariff_bay btn form-modal__footer-btn">Купить</a>
                </div>
              </div>

              <div class="tariff__tariff col col-md-3">
                <div class="tariff__tariff_element">
                  <strong class="tariff__tariff_name">60 дней</strong>
                  <div class="tariff__tariff_discont">-7%</div>
                  <div class="tariff__tariff_coast"><?=floor((60*$base_prise)*0.93);?> рублей</div>
                  <a OnClick="PayTariff(<?=floor((60*$base_prise)*0.93);?>,60)" class="tariff__tariff_bay btn form-modal__footer-btn">Купить</a>
                </div>
              </div>

              <div class="tariff__tariff col col-md-3">
                <div class="tariff__tariff_element">
                  <strong class="tariff__tariff_name">90 дней</strong>
                  <div class="tariff__tariff_discont">-10%</div>
                  <div class="tariff__tariff_coast"><?=floor((90*$base_prise)*0.9);?> рублей</div>
                  <a OnClick="PayTariff(<?=floor((90*$base_prise)*0.9);?>,90)" class="tariff__tariff_bay btn form-modal__footer-btn">Купить</a>
                </div>
              </div>

              <div class="tariff__tariff col col-md-3">
                <div class="tariff__tariff_element">
                  <strong class="tariff__tariff_name">180 дней</strong>
                  <div class="tariff__tariff_discont">-20%</div>
                  <div class="tariff__tariff_coast"><?=floor((180*$base_prise)*0.8);?> рублей</div>
                  <a OnClick="PayTariff(<?=floor((180*$base_prise)*0.8);?>,180)" class="tariff__tariff_bay btn form-modal__footer-btn">Купить</a>
                </div>
              </div>

          </div>
        </div>
      </div>
</div>