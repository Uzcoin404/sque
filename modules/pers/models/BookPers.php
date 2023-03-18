<?php

namespace app\modules\pers\models;
use app\modules\books\models\Books;
use app\modules\pers\models\BookPersGroup;

use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "book_pers".
 *
 * @property int $id
 * @property int $id_book
 * @property string|null $name
 * @property string|null $surname
 * @property string $nickname
 * @property string|null $aliasname
 * @property int|null $bod
 * @property int|null $old
 * @property int|null $dod
 * @property string|null $profession
 * @property string|null $nationality
 * @property string|null $race
 * @property string|null $gender
 * @property string|null $archetype
 * @property string|null $ritp
 * @property string|null $in_motivation
 * @property string|null $out_motivation
 * @property string|null $obstacles
 * @property string|null $arka
 * @property string|null $role_in_history
 * @property string|null $look_height
 * @property string|null $look_weight
 * @property string|null $look_body_type
 * @property string|null $look_hair_color
 * @property string|null $look_hair_style
 * @property string|null $look_eye_color
 * @property string|null $look_eye_style
 * @property string|null $look_glasses
 * @property string|null $look_features
 * @property string|null $look_skin
 * @property string|null $look_makeup
 * @property string|null $look_scars
 * @property string|null $look_birthmarks
 * @property string|null $look_tatoo
 * @property string|null $look_disabilities
 * @property string|null $look_style
 * @property string|null $look_footwear
 * @property string|null $look_to_clothes
 * @property string|null $look_comment
 * @property string|null $person_q1
 * @property string|null $person_q2
 * @property string|null $person_q3
 * @property string|null $person_q4
 * @property string|null $person_q5
 * @property string|null $person_q6
 * @property string|null $person_q7
 * @property string|null $person_q8
 * @property string|null $person_q9
 * @property string|null $person_q10
 * @property string|null $person_q11
 * @property string|null $person_q12
 * @property string|null $person_q13
 * @property string|null $person_q14
 * @property string|null $person_q15
 * @property string|null $person_q16
 * @property string|null $person_q17
 * @property string|null $person_q18
 * @property string|null $person_q19
 * @property string|null $person_q20
 * @property string|null $person_q21
 * @property string|null $person_q22
 * @property string|null $person_q23
 * @property string|null $person_q24
 * @property string|null $person_q25
 * @property string|null $person_q26
 * @property string|null $person_q27
 * @property string|null $person_q28
 * @property string|null $person_q29
 * @property string|null $person_comment
 * @property string|null $lifepath_q1
 * @property string|null $lifepath_q2
 * @property string|null $lifepath_q3
 * @property string|null $lifepath_q4
 * @property string|null $lifepath_q5
 * @property string|null $lifepath_q6
 * @property string|null $lifepath_q7
 * @property string|null $lifepath_q8
 * @property string|null $lifepath_q9
 * @property string|null $lifepath_10
 * @property string|null $lifepath_comment
 * @property string|null $ffr_q1
 * @property string|null $ffr_q2
 * @property string|null $ffr_q3
 * @property string|null $ffr_q4
 * @property string|null $ffr_q5
 * @property string|null $ffr_q6
 * @property string|null $ffr_q7
 * @property string|null $ffr_q8
 * @property string|null $ffr_q9
 * @property string|null $ffr_q10
 * @property string|null $ffr_q11
 * @property string|null $ffr_q12
 * @property string|null $ffr_q13
 * @property string|null $ffr_q14
 * @property string|null $ffr_q15
 * @property string|null $ffr_q16
 * @property string|null $ffr_q17
 * @property string|null $ffr_q18
 * @property string|null $ffr_q19
 * @property string|null $ffr_comment
 * @property string|null $work_q1
 * @property string|null $work_q2
 * @property string|null $work_q3
 * @property string|null $work_q4
 * @property string|null $work_q5
 * @property string|null $work_q6
 * @property string|null $work_q7
 * @property string|null $work_q8
 * @property string|null $work_q9
 * @property string|null $work_q10
 * @property string|null $work_comment
 * @property string|null $interest_q1
 * @property string|null $interest_q2
 * @property string|null $interest_q3
 * @property string|null $interest_q4
 * @property string|null $interest_q5
 * @property string|null $interest_q6
 * @property string|null $interest_q7
 * @property string|null $interest_q8
 * @property string|null $interest_q9
 * @property string|null $interest_q10
 * @property string|null $interest_q11
 * @property string|null $interest_q12
 * @property string|null $interest_q13
 * @property string|null $interest_q14
 * @property string|null $interest_q15
 * @property string|null $interest_q16
 * @property string|null $interest_q17
 * @property string|null $interest_q18
 * @property string|null $interest_q19
 * @property string|null $interest_q20
 * @property string|null $interest_comment
 * @property string|null $own_q1
 * @property string|null $own_q2
 * @property string|null $own_q3
 * @property string|null $own_q4
 * @property string|null $own_q5
 * @property string|null $own_q6
 * @property string|null $own_q7
 * @property string|null $own_comment
 * @property string|null $spirit_q1
 * @property string|null $spirit_q2
 * @property string|null $spirit_q3
 * @property string|null $spirit_q4
 * @property string|null $spirit_q5
 * @property string|null $spirit_q6
 * @property string|null $spirit_q7
 * @property string|null $spirit_q8
 * @property string|null $spirit_q9
 * @property string|null $spirit_q10
 * @property string|null $spirit_comment
 * @property string|null $live_q1
 * @property string|null $live_q2
 * @property string|null $live_q3
 * @property string|null $live_q4
 * @property string|null $live_q5
 * @property string|null $live_q6
 * @property string|null $live_q7
 * @property string|null $live_q8
 * @property string|null $live_q9
 * @property string|null $live_q10
 * @property string|null $live_comment
 *
 * @property Books $book
 */
class BookPers extends \yii\db\ActiveRecord
{
    public $parents;
    public $relatives;
    public $group;
    public $imageFile;
    public static function tableName()
    {
        return 'book_pers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_book', 'nickname'], 'required','message'=>'Поле "{attribute}" не может быть пустым'],
            [['id_book', 'old','status'], 'integer'],
            [['in_motivation', 'out_motivation', 'obstacles', 'hystori', 'arka', 'role_in_history', 'look_features', 'look_scars', 'look_birthmarks', 'look_tatoo', 'look_disabilities', 'look_style', 'look_footwear', 'look_to_clothes', 'look_comment', 'person_q1', 'person_q2', 'person_q3', 'person_q4', 'person_q5', 'person_q6', 'person_q7', 'person_q8', 'person_q9', 'person_q10', 'person_q11', 'person_q12', 'person_q13', 'person_q14', 'person_q15', 'person_q16', 'person_q17', 'person_q18', 'person_q19', 'person_q20', 'person_q21', 'person_q22', 'person_q23', 'person_q24', 'person_q25', 'person_q26', 'person_q27', 'person_q28', 'person_q29', 'person_comment', 'lifepath_q1', 'lifepath_q2', 'lifepath_q3', 'lifepath_q4', 'lifepath_q5', 'lifepath_q6', 'lifepath_q7', 'lifepath_q8', 'lifepath_q9', 'lifepath_10', 'lifepath_comment', 'ffr_q1', 'ffr_q2', 'ffr_q3', 'ffr_q4', 'ffr_q5', 'ffr_q6', 'ffr_q7', 'ffr_q8', 'ffr_q9', 'ffr_q10', 'ffr_q11', 'ffr_q12', 'ffr_q13', 'ffr_q14', 'ffr_q15', 'ffr_q16', 'ffr_q17', 'ffr_q18', 'ffr_q19', 'ffr_comment', 'work_q1', 'work_q2', 'work_q3', 'work_q4', 'work_q5', 'work_q6', 'work_q7', 'work_q8', 'work_q9', 'work_q10', 'work_comment', 'interest_q1', 'interest_q2', 'interest_q3', 'interest_q4', 'interest_q5', 'interest_q6', 'interest_q7', 'interest_q8', 'interest_q9', 'interest_q10', 'interest_q11', 'interest_q12', 'interest_q13', 'interest_q14', 'interest_q15', 'interest_q16', 'interest_q17', 'interest_q18', 'interest_q19', 'interest_q20', 'interest_comment', 'own_q1', 'own_q2', 'own_q3', 'own_q4', 'own_q5', 'own_q6', 'own_q7', 'own_comment', 'spirit_q1', 'spirit_q2', 'spirit_q3', 'spirit_q4', 'spirit_q5', 'spirit_q6', 'spirit_q7', 'spirit_q8', 'spirit_q9', 'spirit_q10', 'spirit_comment', 'live_q1', 'live_q2', 'live_q3', 'live_q4', 'live_q5', 'live_q6', 'live_q7', 'live_q8', 'live_q9', 'live_q10', 'live_comment'], 'string'],
            [['name', 'surname', 'nickname', 'aliasname', 'profession', 'nationality', 'race', 'gender', 'archetype', 'ritp', 'look_height', 'look_weight', 'look_body_type', 'look_hair_color', 'look_hair_style', 'look_eye_color', 'look_eye_style', 'look_glasses', 'look_skin', 'look_makeup'], 'string', 'max' => 255],
            [['id_book'], 'exist', 'skipOnError' => true, 'targetClass' => Books::className(), 'targetAttribute' => ['id_book' => 'id']],
            [['image'], 'string', 'max' => 255],
            [['dod'], 'string'],
            [['bod'], 'string'],
            [['group'], 'validateGroup'],
            [['id_group'],'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg','wrongExtension'=>"Выбран не верный формат"],
        ];
    }
  
    public function validateGroup($attribute, $params)
    {
        if ($this->$attribute<=0) {
            $this->addError($attribute, 'Не верно указана группа');
        }
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_book' => 'Книга',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'nickname' => 'Отображаемое имя',
            'aliasname' => 'Прозвища',
            'bod' => 'Дата рождения',
            'old' => 'Возраст',
            'dod' => 'Дата смерти',
            'profession' => 'Профессия',
            'nationality' => 'Национальность',
            'relatives'=>'Связи с другими персонажами',
            'parents'=>'Родители',
            'race' => 'Раса',
            'gender' => 'Пол',
            'archetype' => 'Архетип',
            'ritp' => 'Роль в сюжете',
            'hystori' => 'История',
            'in_motivation' => 'Внутренняя мотивация',
            'out_motivation' => 'Внешняя мотивация',
            'obstacles' => 'Конфликты и препятствия',
            'arka' => 'Арка персонажа',
            'role_in_history' => 'Роль в истории',
            'look_height' => 'Рост',
            'look_weight' => 'Вес',
            'look_body_type' => 'Телосложение',
            'look_hair_color' => 'Цвет волос',
            'look_hair_style' => 'Прическа',
            'look_eye_color' => 'Цвет глаз',
            'look_eye_style' => 'Форма глаз',
            'look_glasses' => 'Очки или контактные линзы',
            'look_features' => 'Отличительные черты',
            'look_skin' => 'Кожа',
            'look_makeup' => 'Макияж',
            'look_scars' => 'Шрамы',
            'look_birthmarks' => 'Родимые пятна',
            'look_tatoo' => 'Татуировки',
            'look_disabilities' => 'Физические недостатки',
            'look_style' => 'Стиль одежды',
            'look_footwear' => 'Обувь',
            'look_to_clothes' => 'Отношение к одежде',
            'look_comment' => 'Другое',
            'person_q1' => 'Любимые слова и фразы',
            'person_q2' => 'Пессимист или оптимист? ',
            'person_q3' => 'Интроверт или экстраверт?',
            'person_q4' => 'Умственные недостатки',
            'person_q5' => 'Плохие привычки',
            'person_q6' => 'Хорошие привычки',
            'person_q7' => 'Отношение к деньгам',
            'person_q8' => 'Что заставляет персонажа смеяться? ',
            'person_q9' => 'Как персонаж проявляет привязанность и симпатию? ',
            'person_q10' => 'Каким персонаж видит себя?',
            'person_q11' => 'Каким хочет казаться? ',
            'person_q12' => 'Каким его видят другие персонажи? ',
            'person_q13' => 'Сильные стороны',
            'person_q14' => 'Слабые стороны',
            'person_q15' => 'Отношение к соперничеству',
            'person_q16' => 'Персонаж склонен к поспешным решениям и выводам или предпочитает обдумывать свои поступки?  ',
            'person_q17' => 'Реакция на похвалу',
            'person_q18' => 'Реакция на критику',
            'person_q19' => 'Самый большой страх',
            'person_q20' => 'Самый большой секрет',
            'person_q21' => 'Самое сокровенное желание',
            'person_q22' => 'Когда в последний раз персонаж плакал? Из-за чего?',
            'person_q23' => 'Политические взгляды',
            'person_q24' => 'На какие чувства полагается больше всего?',
            'person_q25' => 'Как относится к людям лучше себя?',
            'person_q26' => 'Как относится к людям хуже себя? ',
            'person_q27' => 'Какие качества больше всего ценит в друзьях? ',
            'person_q28' => 'Если бы персонаж мог изменить что-то в себе, что бы это было?',
            'person_q29' => 'Раздражители, больные темы',
            'person_comment' => 'Другое',
            'lifepath_q1' => 'Каким персонаж был в детстве?',
            'lifepath_q2' => 'Рос богатым или бедным? ',
            'lifepath_q3' => 'Рос в заботе или страдал от недостатка внимания? ',
            'lifepath_q4' => 'Самое большое достижение в жизни ',
            'lifepath_q5' => 'Запахи, напоминающие о детстве',
            'lifepath_q6' => 'Лучшее воспоминание из детства',
            'lifepath_q7' => 'Худшее воспоминание из детства',
            'lifepath_q8' => 'Чего персонаж стыдится больше всего?',
            'lifepath_q9' => 'Чем гордится больше всего?',
            'lifepath_10' => 'О чем сожалеет больше всего?',
            'lifepath_comment' => 'Другое',
            'ffr_q1' => 'У персонажа большая или маленькая семья? ',
            'ffr_q2' => 'Отношение к семье',
            'ffr_q3' => 'Отношения в семье',
            'ffr_q4' => 'Каким персонаж представляет себе идеального лучшего друга?',
            'ffr_q5' => 'Есть ли у персонажа лучший друг? Какой он? ',
            'ffr_q6' => 'Домашние животные',
            'ffr_q7' => 'Персонаж состоит с кем-то в романтических и/или интимных отношениях? ',
            'ffr_q8' => 'Персонаж верит в любовь с первого взгляда?',
            'ffr_q9' => 'Когда в последний раз персонаж занимался сексом? ',
            'ffr_q10' => 'Отношение к сексу',
            'ffr_q11' => 'Как персонаж реагирует на угрозы? ',
            'ffr_q12' => 'Предпочитает решать конфликты словами или кулаками? ',
            'ffr_q13' => 'Как персонаж относится к незнакомцам?',
            'ffr_q14' => 'Отношение к оружию',
            'ffr_q15' => 'Какое оружие предпочитает? ',
            'ffr_q16' => 'Кого персонаж ненавидит больше всего? ',
            'ffr_q17' => 'Кого любит больше всего? ',
            'ffr_q18' => 'У персонажа есть враги? ',
            'ffr_q19' => 'Куда или к кому персонаж идет, когда злится/расстроен/устал? ',
            'ffr_comment' => 'Другое',
            'work_q1' => 'Работа (кем работает в настоящее время)',
            'work_q2' => 'Отношение к работе',
            'work_q3' => 'Предыдущие места работы',
            'work_q4' => 'Хобби',
            'work_q5' => 'Уровень навыков',
            'work_q6' => 'Дополнительное образование/специализации',
            'work_q7' => 'Таланты',
            'work_q8' => 'Спортивные навыки',
            'work_q9' => 'Отношение к спорту',
            'work_q10' => 'Социально-экономический статус',
            'work_comment' => 'Другое',
            'interest_q1' => 'Любимое животное',
            'interest_q2' => 'Нелюбимое животное',
            'interest_q3' => 'Любимые места',
            'interest_q4' => 'Нелюбимые места',
            'interest_q5' => 'Какое место персонажу хочется посетить больше всего?',
            'interest_q6' => 'Какое место хочется посетить меньше всего?',
            'interest_q7' => 'Любимая песня',
            'interest_q8' => 'Любимая книга',
            'interest_q9' => 'Любимый фильм',
            'interest_q10' => 'Любимое произведение искусства',
            'interest_q11' => 'Любимый цвет',
            'interest_q12' => 'Любимый вид искусства',
            'interest_q13' => 'Любимый артист',
            'interest_q14' => 'Любимый день недели',
            'interest_q15' => 'Где персонаж любит отдыхать?',
            'interest_q16' => 'Кем персонаж нарядился бы на Хэллоуин? ',
            'interest_q17' => 'Если бы персонаж мог путешествовать во времени, в какое время отправился бы в первую очередь?',
            'interest_q18' => 'Любимая сказка',
            'interest_q19' => 'Нелюбимая сказка',
            'interest_q20' => 'Если бы персонаж мог выбрать суперспособность, какой бы она была? ',
            'interest_comment' => 'Другое',
            'own_q1' => 'Где живет персонаж? ',
            'own_q2' => 'Что всегда есть в холодильнике? ',
            'own_q3' => 'Что хранится в прикроватной тумбочке? ',
            'own_q4' => 'Что персонаж возит в машине? ',
            'own_q5' => 'Что носит с собой? ',
            'own_q6' => 'Что в карманах?',
            'own_q7' => 'Что ценит больше всего?',
            'own_comment' => 'Другое',
            'spirit_q1' => 'Знак зодиака',
            'spirit_q2' => 'Персонаж верит в жизнь после смерти? ',
            'spirit_q3' => 'Суеверный или нет? ',
            'spirit_q4' => 'Религиозность, отношение к религии',
            'spirit_q5' => 'Отношение к науке',
            'spirit_q6' => 'Отношение к технологиям',
            'spirit_q7' => 'Что, по мнению персонажа, является самым ужасным поступком в отношении другого человека? ',
            'spirit_q8' => 'Что, по мнению персонажа, является “свободой”?',
            'spirit_q9' => 'Отношение ко лжи',
            'spirit_q10' => 'Когда персонаж врал в последний раз? Зачем? ',
            'spirit_comment' => 'Другое',
            'live_q1' => 'Привычки в еде',
            'live_q2' => 'Состояние здоровья, аллергии, болезни, перенесенные заболевания',
            'live_q3' => 'Какой у персонажа дом, обстановка внутри, порядок?',
            'live_q4' => 'Что персонаж делает утром первым делом после пробуждения?',
            'live_q5' => 'Что персонаж обязательно делает перед сном? ',
            'live_q6' => 'Любимый напиток',
            'live_q7' => 'Любимая еда',
            'live_q8' => 'Отношение к алкоголю',
            'live_q9' => 'Отношение к курению',
            'live_q10' => 'Отношение к наркотикам ',
            'live_comment' => 'Другое',
            'status' => 'Вкл./Выкл.',
            "imageFile"=>"Изображение",
            "group"=>"Группа"
        ];
    }

    public function upload()
    {
     //   if ($this->validate()) {
            $user=Yii::$app->user->identity;
            //if(!isset($this->imageFile->baseName)) return 0;
            $name=MD5($user->id."".strtotime('now')."".$this->imageFile->baseName) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs(Yii::getAlias('@webroot').'/img/pers/' .$name) ;
            return $name;
      //  } else {
      //      return false;
     //   }
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Books::className(), ['id' => 'id_book']);
    }

    public function getBooks()
    { 
        $user=Yii::$app->user->identity;
        $groups = Books::find()->where(["id_user"=>$user->id])->all();
        
        return ArrayHelper::map($groups,'id','name');

    }

    public function getArchytype(){
        return [
            ""=>"-",
          "Любовник"=>"Любовник",  
          "Герой"=>"Герой",  
          "Маг"=>"Маг",  
          "Бунтарь"=>"Бунтарь",  
          "Исследователь"=>"Исследователь",  
          "Ментор"=>"Ментор",  
          "Невинный / Ребенок"=>"Невинный / Ребенок",  
          "Создатель"=>"Создатель",  
          "Правитель / Лидер "=>"Правитель / Лидер ",  
          "Опекун / Воспитатель"=>"Опекун / Воспитатель",  
          "Обыватель"=>"Обыватель",  
          "Шут / Трикстер"=>"Шут / Трикстер",  
        ];
    }

    public function getRitp(){
        return [
            ""=>"-",
            "Протагонист"=>"Протагонист",  
            "Антагонист"=>"Антагонист",
            "Любовный интерес"=>"Любовный интерес",
            "Конфидент (доверенное лицо)"=>"Конфидент (доверенное лицо)",
            "Дейтерагонист (девтерагонист)"=>"Дейтерагонист (девтерагонист)",
            "Третичный персонаж"=>"Третичный персонаж",
            "Противоположность"=>"Противоположность",
        ];
    }

    public function getItemsIDs($items)
    {
       $ids = array();
       foreach($items as $item)
           $ids[] = $item->id;
       return $ids;
    }

    public function getPers(){
        $user = Yii::$app->user->identity;
        $book_where=[
            "id_user"=>$user->id,
        ];
        $books=Books::find()->where($book_where);
        if(isset($this->id_book) && $this->id_book>0 ){
            $books->andWhere(['id'=>$this->id_book]);

        }
        $books=$books->orderBy(["id_group"=>"DESC"])->all();
        $scene_where=[
            "id_book"=>$this->getItemsIDs($books),
        ];
        $BookPers=BookPers::find()->where($scene_where)->all();
        
        return ArrayHelper::map($BookPers,'id','nickname');
    }

 

    public function getRelativesValue(){
        $BookPersPers=BookPersPers::find()->where(["type"=>2,"id_pers"=>$this->id])->all();
        $result=[];
        foreach($BookPersPers as $pers){
            $result[]=$pers->to_id_pers;
        }
        return $result;
    }

    public function getParentsValue(){
        $BookPersPers=BookPersPers::find()->where(["type"=>1,"id_pers"=>$this->id])->all();
        $result=[];
        foreach($BookPersPers as $pers){
            $result[]=$pers->to_id_pers;
        }
        return $result;
    }

    public function getGroupsList()
    { 
        $user=Yii::$app->user->identity;
        //$book_id=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
        $groups = BookPersGroup::find()->where(["id_user"=>$user->id,'status'=>1,'id_book'=> $this->id_book])->all();
        $result=ArrayHelper::map($groups,'id','name');
        //$result[0]="-";
        return $result;

    }
    public function findGroup(){
        $user=Yii::$app->user->identity;
        if(!$this->group ||  (is_countable($this->group) && count($this->group)<=0)){
            //$book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
            $BookPersGroup=BookPersGroup::find()->where(['id_book'=>$this->id_book,'isDefault'=>1])->one();
            return $BookPersGroup->id."|";
        }
        $result="";
        if(is_array($this->group)){
            foreach($this->group as $group){
                if(intval($group)>0){
                    $result= $result.$group."|";
                }else{
                    $char=mb_substr($group, 0, 1);
                    $group = mb_substr( $group, 1);
                    if($group!="-" && $group!="0" && $char=="@"){
                        
                        $color = array_rand(BookPersGroup::getColorList(), 1);
                        $BookGroups = new BookPersGroup();
                        $BookGroups->name=$group;
                        $BookGroups->id_user=$user->id;
                        $BookGroups->color= $color;
                        $BookGroups->id_book=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
                        $BookGroups->status=1;
                        $BookGroups->save();
                        $result= $result.$BookGroups->id."|";
                    }
                }
            }
        }
       
        return $result;
    }

    public function getGroupName(){

        $result="";
        if(!isset($this->id_group))
        return $result;
            foreach($this->id_group as $group){
                $group_res = BookPersGroup::find()->where(["id"=>$group])->one();
                if(isset($group_res->name)){
                    $result.="<span style='background-color:".$group_res->color."'>".$group_res->name."</span> / ";
                }
            }
        return $result;
        
    }
    
    public function getGroupColor(){
        if(!isset($this->id_group))
        return "transparent";
        $group = BookPersGroup::find()->where(["id"=>$this->id_group])->one();
        if(!isset($group->color))
        return "transparent";
        return $group->color;
    }

    public function getStatus(){
        return[
            '1' => 'Доступна',
            '0' => 'Отключена',
        ];
    }
    public function getPopover($text=false){
        if($text){
            return "Имя:<br>".mb_substr(strip_tags($this->name),0,50)."<br>Фамилия:<br>".$this->surname."<br>Дата рождения:<br>".$this->bod."<br>Дата смерти:<br>".$this->dod."<br>Рост:<br> ".$this->look_height."<br>Вес:<br>".$this->look_weight."<br>";
        }
        return "<dl><dt>Имя:</dt><dd>".mb_substr(strip_tags($this->name),0,50)."</dd><dt>Фамилия:</dt><dd>".$this->surname."</dd><dt>Дата рождения:</dt><dd> ".$this->bod."</dd><dt>Дата смерти:</dt><dd>".$this->dod."</dd><dt>Рост:</dt><dd> ".$this->look_height."</dd><dt>Вес:</dt><dd>".$this->look_weight."</dd></dl>";
    }

    public function afterFind(){
        parent::afterFind();
        $this->name=strip_tags($this->name);
        $this->group=$this->id_group;
        $this->id_group=explode('|',$this->id_group);
    }
    
    public function getMaxSort(){
        $user=Yii::$app->user->identity;
        $book_id=Books::find()->where(["id_user"=>$user->id,"status"=>1,'main'=>1])->one()->id;
        return BookPers::find()->where(['id_book'=>$book_id])->max('sort')+1;
    }
    public function getGroup($group_id){
        return BookPersGroup::find()->where(["id"=>$group_id])->one();
    }
}
