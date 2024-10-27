<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Pagination;
use yii\data\ArrayDataProvider;

use app\models\Views;
use app\models\Dislike;
use app\models\Like;
use app\models\Questions;
use app\models\User;
use app\models\Answers;
use app\models\LikeAnswers;
use app\models\DislikeAnswer;
use app\models\ChangeEmail;
use app\models\ViewsAnswers;


// AJAX
use yii\widgets\ActiveForm;


class OpenController extends Controller
{

    public $info = [];
    public $status = [];
    public $slut = 1;
    public $user_answer = [];
    public $number = [];
    public $winner_procent = 0.0;

    //Настройка прав доступа
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'myquestions', 'close', 'voting', 'moderation', 'updatestatus', 'time', 'change', 'filter', 'closeview', 'votingview', 'myquestionview', 'myvoiting', 'myvoitingview', 'search', 'myquestionsfilter', 'dateupdate', 'return'],
                'rules' => [

                    [
                        'actions' => ['index', 'create', 'update', 'myquestions', 'close', 'voting', 'moderation', 'updatestatus', 'time', 'text', 'change', 'filter', 'closeview', 'votingview', 'myquestionview', 'myvoiting', 'myvoitingview', 'search', 'myquestionsfilter', 'dateupdate', 'return'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'create', 'close', 'voting', 'filter', 'closeview', 'votingview', 'myquestionview', 'search', 'time'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],

                ],
            ],

        ];
    }


    //Главный экран

    public function actionIndex()
    {
        $questions = Questions::find()
            ->where(["status" => [4]])
            ->orderBy(["created_at" => SORT_DESC]);

        $pages = new Pagination(['totalCount' => $questions->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $questions = $questions->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render(
            'index',
            [
                "questions" => $questions,
                "pages" => $pages,
            ]
        );
    }

    //Внутреннея страница

    public function actionView($slug)
    {



        $users = Yii::$app->user->identity;

        if ($users) {
            $model = User::find()->where(['id' => $users->id])->one();

            $model->date_online = time();

            $model->update();
        }

        $questions = Questions::find()->where(["id" => $slug])->one();
        if (!isset($questions->id)) return $this->redirect("/");
        $this->ViewCreate($slug);
        if ($questions->status == 4 || $questions->status == 2 || $questions->status == 1) {
            return $this->render(
                'view',
                [
                    "question" => $questions,
                ]
            );
        } else {
            $this->redirect("/");
        }
    }

    // Добавление просмотров

    public function ViewCreate($slug)
    {
        $users = Yii::$app->user->identity;

        $user_id = '';
        $type = '';
        $moderation = '';

        if ($users) {
            $user_id = $users->id;
            $type = 1;
            $moderation = $users->moderation;
        } else {
            $user_id = 1;
            $type = 0;
        }
        if (!$moderation) {

            $view = Views::find()->where(['question_id' => $slug, 'user_id' => $user_id])->one();

            $questions = Questions::find()->where(['id' => $slug])->one();
            if ($users) {
                if ($questions->status < 6) {
                    if (!$view) {
                        $views = new Views();
                        $views->question_id = $slug;
                        $views->created_at = time();
                        $views->user_id = $user_id;
                        $views->type_user = $type;
                        $views->save();
                    }
                }
            }
        }
    }

    // Поиск

    public function actionSearch()
    {

        $text = $_GET['text'];

        $question_id = [];

        $search = 1;

        $questions = [];

        $questions = Questions::find()->where(["status" => [4, 5, 6]])->andWhere(
            [
                'or',
                ['like', 'text', $text],
                ['like', 'title', $text]
            ]
        )->orderBy(["cost" => SORT_DESC])->all();

        return $this->render(
            '_search',
            [
                "questions" => $questions,
            ]
        );
    }

    public function actionDateupdate($slug)
    {

        $user = Yii::$app->user->identity;

        if ($user->moderation == 1) {

            // $model = Questions::find()->where(['id' => $slug])->one();

            // if ($model->load(Yii::$app->request->post())) {
            //     $model->created_at = strtotime($model->created_at);
            //     if ($model->created_at <= time()) {
            //         Yii::$app->session->setFlash('error', \Yii::t('app', 'The date is set incorrectly. It should be longer than {date}', ['date' => date("d.m.Y", time())]));
            //         return $this->render(
            //             '_dateupdate',
            //             [
            //                 "model" => $model,
            //             ]
            //         );
            //     }
            //     if ($model->created_at > strtotime("+14 days")) {
            //         Yii::$app->session->setFlash('error', \Yii::t('app', 'The date is set incorrectly. It should be longer than {date}', ['date' => date("d.m.Y", strtotime("+14 days"))]));
            //         return $this->render(
            //             '_dateupdate',
            //             [
            //                 "model" => $model,
            //             ]
            //         );
            //     }

            //     $model->created_at = $model->created_at;
            //     $model->date_changes = 1;

            //     if ($model->status == 4) {
            //         $model->created_at_open = $model->created_at;
            //         $model->setDateEndOpen($model->created_at);
            //     } elseif ($model->status == 5) {
            //         $model->created_at_voiting = time();
            //         $model->setDateEndVoting($model->created_at);
            //     }

            //     $date = date("d.m.y", $model->created_at);
            //     $model->setDateUpdate();
            //     if ($model->update(0)) {
            //         return $this->redirect(
            //             '/',
            //         );
            //     }
            // }

            // return $this->render(
            //     '_dateupdate',
            //     [
            //         "model" => $model,
            //     ]
            // );
        }
    }

    public function array_swap(array &$array, $key, $key2)
    {
        if (isset($array[$key]) && isset($array[$key2])) {
            list($array[$key], $array[$key2]) = array($array[$key2], $array[$key]);
            return true;
        }

        return false;
    }

    // Смена статуса по времени

    public function actionTime()
    {

        //$questions = Questions::find()->where(['status' => 5])->andWhere(["<=","created_at",strtotime("now")])->all(); 
        // если надо сменить статус, то раскомментируйте эту строку, она не работает, так что перенос будет работать независимо от времени. 
        // $questions = Questions::find()->where(['status' => 5])->andWhere(["<=","data",strtotime("-1")])->all();
        // echo '<pre>';
        $questions = Questions::find()->where(['status' => 5])->andWhere(["<=", "date_end_voting", time()])->all();
        foreach ($questions as $value) {

            $i = 0;

            $this->user_answer = [];

            $winner_id = $this->actionWinner($value->id, $value->owner_id);

            $winners_number = 0;

            foreach ($winner_id as $id) {
                if ($id['number'] == 1) {
                    $winners_number++;
                }
            }


            if ($value->winner_id) {
                foreach ($value->winner_id as $id) {

                    $users = User::find()->where(["id" => $id['user_id']])->one();

                    if ($users) {
                        if (!$users->money) {
                            $users->money = $value->cost / $winners_number + 0;
                        } else {
                            $users->money = $value->cost / $winners_number + $users->money;
                        }
                        $users->update(0);
                    }
                }
                if (!$value->date_changes) {
                    $value->data_voiting = time();
                }
                $value->data = time();
                $value->status = 6;
                $value->setDateUpdate();
                $value->setDateClose();
                $value->update(0);

                $i++;
            } else {
                $value->data = time();
                $value->status = 6;
                $value->setDateUpdate();
                $value->setDateClose();
                $value->update(0);
            }
        }

        // echo 'ok';
        // exit;
        $this->actionSetStatusActive();
    }


    // Выбор победителя

    public function actionWinner($id, $user)
    {
        $win = [];
        $answers_number_win = [];
        $answers = [];
        $answer = Answers::find()->where(['question_id' => $id])->orderBy(['created_at' => SORT_DESC])->all();

        foreach ($answer as $value) {

            $this->winner_procent = LikeAnswers::find()->where(['id_answer' => $value->id])->count();
            //  $this->winner_procent= $this->winner_procent-DislikeAnswer::find()->where(['id_answer'=>$value->id])->count();



            if ($value->user_id) {
                $answers[$value->user_id] = $value->id;
                $win[$this->winner_procent][] = $value->user_id;
            }
        }

        //  $dislikeItem = DislikeAnswer::find()->where(['user_id' => $item['user_id'], 'question_id' => $value['id']])->count();
        //  $winner_id[$key]['dislike'] = $dislikeItem;


        krsort($win);
        $win = array_reverse($win);

        $winner = [];
        $number = 0;

        foreach ($win as $k => $values) {

            foreach ($values as $value) {

                array_push($winner, array('user_id' => $value, 'number' => count($win) - $number));
                $answer = Answers::find()->where(['id' => $answers[$value]])->one();
                $answer->number = count($win) - $number; //$winner[$number]['number'];
                $answer->update(0);
            }
            $number++;
        }

        return $winner;
    }

    // Страница моих вопросов

    public function actionMyquestionview($slug)
    {

        $this->ViewCreate($slug);

        $questions = Questions::find()->where(["id" => $slug])->one();
        return $this->render(
            '_viewmyquestion',
            [
                "question" => $questions,
            ]
        );
    }
    public function actionMyquestions()
    {

        $user = Yii::$app->user->identity;

        $questions = Questions::find()->where(["owner_id" => $user->id])->orderBy(["cost" => SORT_DESC]);

        $pages = new Pagination(['totalCount' => $questions->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $questions = $questions->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render(
            '_myquestion',
            [
                "questions" => $questions,
                "pages" => $pages,
            ]
        );
    }

    public function actionMyquestionsfilter($slug)
    {

        $questions = Questions::find()->where(["id" => $slug])->orderBy(["cost" => SORT_DESC])->all();

        return $this->render(
            '_myquestionfilter',
            [
                "questions" => $questions,
            ]
        );
    }

    // Мои голосования

    public function actionMyvoitingview($slug)
    {
        $this->ViewCreate($slug);

        $questions = Questions::find()->where(["id" => $slug])->one();
        return $this->render(
            '_viewmyvoiting',
            [
                "question" => $questions,
            ]
        );
    }

    public function actionMyvoiting()
    {

        $user = Yii::$app->user->identity;

        $answer_like = LikeAnswers::find()->where(['user_id' => $user->id])->all();

        $answer_dislike = DislikeAnswer::find()->where(['user_id' => $user->id])->all();

        $question_id = [];

        $questions = [];

        if ($answer_like) {

            foreach ($answer_like as $value) {
                array_push($question_id, $value->question_id);
            }
        }
        if ($answer_dislike) {
            foreach ($answer_dislike as $value) {
                array_push($question_id, $value->question_id);
            }
        }

        $question_id = array_unique($question_id, SORT_REGULAR);

        foreach ($question_id as $value) {

            $question = Questions::find()->where(["status" => [5, 6], "id" => $value])->orderBy(["cost" => SORT_DESC])->one();
            array_push($questions, $question);
        }

        $count = count($questions);

        $provider = new ArrayDataProvider([
            'allModels' => $questions,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);



        $files = $provider->getModels();

        return $this->render(
            '_myvoiting',
            [
                "questions" => $files,
                "provider" => $provider,
            ]
        );
    }

    // Модерация вопросов

    public function actionModeration()
    {
        $user = Yii::$app->user->identity;
        if ($user->moderation == 1 && $user->key == "jG23zxcmsEKs**aS431") {

            $questions = Questions::find()->where(["status" => [1, 2, 3]])->orderBy(["cost" => SORT_DESC]);

            $pages = new Pagination(['totalCount' => $questions->count(), 'pageSize' => 4, 'forcePageParam' => false, 'pageSizeParam' => false]);

            $questions = $questions->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            return $this->render(
                '_moderation',
                [
                    "questions" => $questions,
                    "pages" => $pages,
                ]
            );
        } else {
            header('Location: /');
            exit;
        }
    }

    public function actionReturn($slug)
    {

        $model = Questions::find()->where(["id" => $slug])->one();

        $user = Yii::$app->user->identity;

        if ($user->moderation == 1) {
            if ($model->load(Yii::$app->request->post())) {
                $user = Yii::$app->user->identity;
                $model->text_return = $model->text_return;
                $model->status = 2;
                $model->setDateUpdate();
                $model->setDateReturnModeration();
                if ($model->update(0)) {

                    return $this->redirect('/questions/moderation');
                }
            }

            return $this->render(
                'return',
                [
                    "model" => $model,
                ]
            );
        }
    }

    public function actionChange($slug)
    {

        $model = Questions::find()->where(["id" => $slug])->one();

        $questions = Questions::find()->where(["id" => $slug])->one();

        if ($questions) {
            if ($model->load(Yii::$app->request->post())) {
                $user = Yii::$app->user->identity;
                $model->owner_id = $user->id;
                $model->status = 1;
                $model->setDateUpdate();
                if ($model->save()) {
                    return $this->redirect('/questions/myquestions');
                }
            }

            return $this->render(
                'update',
                [
                    "model" => $model,
                    "questions" => $questions,
                ]
            );
        }
    }

    public function actionUpdatestatus()
    {

        $user = Yii::$app->user->identity;

        if ($user->moderation == 1 && $user->key == "jG23zxcmsEKs**aS431") {

            $request = Yii::$app->request;
            $question_id = $request->get('question_id');
            $model = Questions::find()->where(['id' => $question_id])->one();

            $model->status = 4;
            $model->moderated_at = time();
            return $model->update(0);

            // $request = Yii::$app->request;

            // $this->info = [
            //     $request->get('question_id'),
            // ];

            // $this->status = [
            //     $request->get('status_id'),
            // ];

            // $this->slut = 2;

            // foreach ($this->status as $value) {
            //     if ($value[0] == 1) {
            //         $this->slut = 4;
            //     }
            //     if ($value[0] == 0) {
            //         $this->slut = 2;
            //     }
            // }

            // foreach ($this->info as $post) {

            //     $questions = Questions::find()->where(['id' => $post])->one();

            //     $questions->status = $this->slut;

            //     $questions->created_at = strtotime('+1 day');

            //     $questions->setDateUpdate();
            //     $questions->setDateModeration();
            //     $questions->setDateOpen();
            //     $questions->setDateEndOpen();
            //     return $questions->update(0);
            // }
        } else {
            header('Location: /');
            exit;
        }
    }


    public function actionClose()
    {

        $questions = Questions::find()->where(['in', 'status', [6, 7]]);

        $pages = new Pagination(['totalCount' => $questions->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $questions = $questions->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render(
            '_close',
            [
                "questions" => $questions,
                "pages" => $pages,
            ]
        );
    }


    public function actionCloseview($slug)
    {

        $this->ViewCreate($slug);

        $questions = Questions::find()->where(["id" => $slug])->one();
        return $this->render(
            '_viewClose',
            [
                "question" => $questions,
            ]
        );
    }




    public function actionCreate()
    {
        $model = new Questions();

        if ($model->load(Yii::$app->request->post())) {
            $user = Yii::$app->user->identity;
            $model->owner_id = $user->id;
            $model->status = 1;
            $model->grand = \Yii::t('app', 'Russian');
            $model->text = strip_tags($model->text);
            $user_cost = User::find()->where(['id' => $user->id])->one();
            if (!$user->money) {
                return $this->redirect('/questions/myquestions');
            } else {
                $user_cost->money = $user->money - $model->cost;
            }
            $user_cost->update(0);
            $model->setDateCreate();
            if ($model->save()) {
                return $this->redirect(
                    '/questions/myquestionsfilter/' . $model->id . '',
                );
            }
            print_r($model);
        }



        return $this->render(
            'create',
            [
                "model" => $model,
            ]
        );
    }



    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdate() {}

    public function actionText()
    {

        $request = Yii::$app->request;

        $this->info = [
            $request->get('id'),
            $request->get('status'),
        ];

        $answer = Answers::find()->where(['id' => $this->info[0]])->one();

        if ($this->info[1] == 1) {

            return $answer->text;
        } else {

            $text = mb_strimwidth($answer->text, 0, 30, "...");
            return $text;
        }
    }
}
