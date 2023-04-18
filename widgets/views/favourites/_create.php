<?PHP 
use yii\helpers\Html;
use app\models\Favourites;
use app\models\User;


?>
<div class="questions__list_element_text_price_favourites">
    <?php if($favourite){ ?>
        <?php 
            foreach($favourite as $value){
        ?>
            <button onclick="DeleteFavourites(this)" style="background: url(/icons/star_active_from.png)" data-id-question="<?=$id_question?>" data-id-favourite="<?=$value->id?>"></button>
        <?php
            } 
        ?>
        
    <?php } else { ?>
        <button onclick="CreateFavourites(this)" style="background: url(/icons/star.png)" data-id-question="<?=$id_question?>"></button>
    <?php } ?>
</div>