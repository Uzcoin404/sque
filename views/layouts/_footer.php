<script>
        (function ($) {
            $(function () {
                $('input[type=file]').styler();
             
            });
        })(jQuery);
    </script>
<?PHP  if (!Yii::$app->user->isGuest):?>
<script>
   jQuery(document).ready(function ($) {
  
  var toaskDivOk = document.getElementById('toastOk');
  toastOk = new bootstrap.Toast(toaskDivOk);

  var toaskDivBad = document.getElementById('toastBad');
  toastBad = new bootstrap.Toast(toaskDivBad);
   });

   function ShowToastOk(){
    if(!toastOk) return;
    toastOk.show();
}

function ShowToastBad(form=false,text="Не удалось сохранить! Заполнены не все обязательные поля."){
    if(form){
      //06-11-2021
      form.yiiActiveForm('data').submitting = true;
      form.yiiActiveForm('validate');
      //06-11-2021
    }else{
      $('#toastBad .toast-body').text(text);
      if(!toastBad) return;
            toastBad.show();
    }
  
}
</script>
<!-- MODAL -->

<?PHP ENDIF;?>  