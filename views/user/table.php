<?php
    $this->title = \Yii::t('app', 'Tables');
    $procent = 0;

    // 'user' => $user->username, // имя
    //     'like_count' => $like_count, // Сумма лайков
    //     'likes_click_count' => $likes_click_count, // Лайки и нажал на кнопку
    //     'likes_noclick_count' => $likes_noclick_count, // Лайки и не нажал на кнопку
    //     'dislike_click_count' => $dislike_click_count, // Дизлайки и нажал на кнопку
    //     'dislike_noclick_count' => $dislike_noclick_count, // Дизлайки и не нажал на кнопку
    //     'dislike_count' => $dislike_count, // Сумма дизлайков
?>
    <div class="table_user_like_count">
        <table class="table_like_user">
            <colgroup>
                <col span="11" style="background-color:#fff">
            </colgroup>
            <tr>
                <th>№ <br><span>(1)</span></th>
                <th><?=Yii::t('app','User')?><br><span>(2)</span></th>
                
                <th><?=Yii::t('app','Sum')?><br><span>(3)</span></th>
                <th><?=Yii::t('app','Total number of likes')?><br><span>(4)</span></th>
                <th><?=Yii::t('app','Like and didn\'t press the button')?><br><span>(5)</span></th>
                <th><?=Yii::t('app','Like and press the button')?><br><span>(6)</span></th>
                <th><?=Yii::t('app','Total number of dislikes')?><br><span>(7)</span></th>
                <th><?=Yii::t('app','Dislike and didn\'t press the button')?><br><span>(8)</span></th>
                <th><?=Yii::t('app','Dislike and press the button')?><br><span>(9)</span></th>

                <th><?=Yii::t('app','Like percentage')?><br><span>(10)</span></th>
                <th><?=Yii::t('app','Dislike percentage')?><br><span>(11)</span></th>
            </tr>
            <?php
            $number = 0;
            $i = 1;
            foreach($table as $value){
             
                    $flag_likes = $value['likes_noclick_count'] && $value['like_count'];
                    $flag_dislikes = $value['dislike_noclick_count'] && $value['dislike_count'];
                    ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$value['user']?></td>
                            <td><?=$value['likes_noclick_count'] + $value['dislike_noclick_count']?></td>
                            <td><?=$value['like_count']?></td>
                            <td><?=$value['likes_noclick_count']?></td>
                            <td><?=$value['likes_click_count']?></td>
                            <td><?=$value['dislike_count']?></td>
                            <td><?=$value['dislike_noclick_count']?></td>
                            <td><?=$value['dislike_click_count']?></td>
                            <td><?=$flag_likes ? round($value['likes_noclick_count'] / $value['like_count'] * 100) : 0?>%</td>
                            <td><?=$flag_dislikes ? round($value['dislike_noclick_count'] / $value['dislike_count'] * 100) : 0?>%</td>
                            
                        </tr>
                    <?php
                $i++;
            }
            ?>
        </table>
    </div>
<?php
       
?>