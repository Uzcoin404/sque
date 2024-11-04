<?php

// Define paths for the Yii application
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'prod');

require_once '/home/cpe0000072/site/vendor/autoload.php';
require_once '/home/cpe0000072/site/vendor/yiisoft/yii2/Yii.php';

$config = require_once('/home/cpe0000072/site/config/console.php');

// // Adjust the paths as necessary
// require_once 'D:\code\xampp\htdocs\sque\basic\vendor\autoload.php';
// require_once 'D:\code\xampp\htdocs\sque\basic\vendor\yiisoft\yii2\Yii.php';

// // Load your application configuration
// $config = require_once('D:\code\xampp\htdocs\sque\basic\config\console.php'); // Use console.php for console commands

// Create and run the application
(new yii\console\Application($config));

// Set error reporting and log file
error_reporting(E_ALL);
$errorLogPath = 'D:\code\xampp\htdocs\sque\basic\commands\error_log.txt';

if (!file_exists($errorLogPath)) {
  file_put_contents($errorLogPath, "");
}

use app\models\Answers;
use app\models\LikeAnswers;
use yii\console\Controller;
use app\models\Questions;
use app\models\User;
use yii\db\Expression;

class CronJob extends Controller
{
  public function actionRun($task = 'both')
  {
    switch ($task) {
      case 'voting':
        $this->TransferToVoting();
        break;
      case 'archive':
        $this->TransferToArchive();
        break;
      default:
        $this->TransferToVoting();
        $this->TransferToArchive();
    }
  }

  private function TransferToVoting()
  {
    // $subqueryAnswers = (new Query())
    //   ->select(['question_id'])
    //   ->from('answers')
    //   ->groupBy('question_id')
    //   ->having('COUNT(*) >= 3');

    // $subqueryLikes = (new Query())
    //   ->select(['question_id'])
    //   ->from('likes')
    //   ->groupBy('question_id')
    //   ->having('COUNT(*) >= 5');

    // $questions = Questions::find()
    //   ->innerJoin(['ans' => $subqueryAnswers], 'questions.id = ans.question_id')
    //   ->innerJoin(['lik' => $subqueryLikes], 'questions.id = lik.question_id')
    //   ->where(['questions.status' => 4])
    //   ->andWhere(['<', new Expression('questions.moderated_at + 86400'), time()])
    //   ->all();

    $questions = Questions::find()
      ->innerJoin('answers', 'questions.id = answers.question_id')
      ->groupBy('answers.question_id')
      ->having('COUNT(answers.id) >= 3')
      ->where(["status" => 4])
      ->andWhere(['<', new Expression('moderated_at + 86400'), time()])
      ->all();

    print_r($questions);
    foreach ($questions as $question) {
      $question->status = 5;
      $question->voting_at = time();
      $question->updated_at = time();
      $question->update(false); // 'false' skips validation, change to 'true' if validation is needed
    }
  }

  private function TransferToArchive()
  {
    $questions = Questions::find()
      ->innerJoin('likes', 'questions.id = likes.question_id')
      ->groupBy('likes.question_id')
      ->having('COUNT(likes.id) >= 5')
      ->where(["questions.status" => 5])
      ->andWhere(['<', new Expression('voting_at + 86400'), time()])
      // ->andWhere(['<', new Expression('voting_at + 86400'), time()])
      ->all();

    // print_r($questions);
    foreach ($questions as $question) {

      $questionCost = $question->cost;
      $answers = Answers::find()->where(['question_id' => $question->id])->orderBy('likes DESC')->all();
      $currentRank = 1;
      $winnersCount = 0;
      $previousLikes = null;

      if ($answers[0]->likes == 0) {
        $winnersCount = null;
      } else {
        foreach ($answers as $answer) {
          if ($answer->likes == $answers[0]->likes) {
            $winnersCount++;
          } else {
            break; // Stop counting once we hit a different like count
          }
        }

        foreach ($answers as $i => $answer) {

          // If likes are the same as the previous answer, assign the same rank
          if ($previousLikes != 0 && $answer->likes == $previousLikes) {

            $answer->rank = $currentRank;
          } else {
            // Otherwise, assign a new rank and increment the rank counter
            $answer->rank = $currentRank;
            $currentRank++; // Update rank for the next unique like count
          }

          // Winner
          if ($winnersCount >= $i + 1) {
            $reward = round(($questionCost * 0.5) / $winnersCount);

            $answer->rank = 1;
            $answer->winner = 1;
            $answer->reward = $reward;
            User::updateAll(['money' => new Expression("money + $reward")], ['id' => $answer->user_id]);
            print_r($answer->likes);
          }

          $answer->update();
          $previousLikes = $answer->likes; // Update previous likes
        }
      }

      $question->status = 6;
      $question->closed_at = time();
      $question->updated_at = time();
      $question->update(false);
    }
  }
}

if (isset($argv[1])) {
  $task = $argv[1];
  (new CronJob('cron-job-id', null))->actionRun($task);
} else {
  (new CronJob('cron-job-id', null))->actionRun('both');
}
