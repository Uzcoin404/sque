<div class="questions">
    <div class="questions__list">
        <?PHP FOREACH($questions as $question):?>
            <div class="questions__list_element">
                <div class="questions__list_element_text">
                    <p class="title"><?=$question->title?></p>
                    <p class="text"><?=$question->text?></p>
                </div>
            </div>
        <?PHP ENDFOREACH;?>
    </div>
</div>