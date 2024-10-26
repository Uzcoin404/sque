<?php

// Define paths for the Yii application
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'prod');

// Adjust the paths as necessary
require 'D:\code\xampp\htdocs\sque\basic\vendor\autoload.php';
require 'D:\code\xampp\htdocs\sque\basic\vendor\yiisoft\yii2\Yii.php';

// Load your application configuration
$config = require('D:\code\xampp\htdocs\sque\basic\config\console.php'); // Use console.php for console commands

// Create and run the application
(new yii\console\Application($config));

// Set error reporting and log file
error_reporting(E_ALL);
$errorLogPath = 'D:\code\xampp\htdocs\sque\basic\config\commands\error_log.txt';

if (!file_exists($errorLogPath)) {
  file_put_contents($errorLogPath, "");
}
ini_set('error_log', $errorLogPath);

use yii\console\Controller;
use app\models\Questions;

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
    $questions = Questions::find()
      ->innerJoin('answers', 'questions.id = answers.id_questions')
      // ->innerJoin('like_answer', 'questions.id = like_answer.id_questions')
      ->groupBy(['answers.id_questions', 'like_answer.id_questions'])
      ->having('COUNT(answers.id) >= 3')
      ->orHaving('COUNT(like_answer.id) >= 5')
      ->where(["status" => 4])
      ->orWhere(['<', new \yii\db\Expression('date_moderation + 86400'), time()])
      ->all();

    print_r($questions);
    foreach ($questions as $question) {
      $question->status = 5;
      $question->date_voting = time();
      $question->update(false); // 'false' skips validation, change to 'true' if validation is needed
    }
  }

  private function TransferToArchive()
  {
    $questions = Questions::find()
      ->where(["status" => 5])
      ->orWhere(['<', new \yii\db\Expression('date_voting + 86400'), time()])
      ->all();

    foreach ($questions as $question) {
      $question->status = 6;
      $question->date_close = time();
      $question->update(false); // 'false' skips validation, change to 'true' if validation is needed
    }
  }
}

if (isset($argv[1])) {
  $task = $argv[1];
  (new CronJob('cron-job-id', null))->actionRun($task);
} else {
  (new CronJob('cron-job-id', null))->actionRun('both');
}
