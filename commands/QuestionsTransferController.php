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
$errorLogPath = 'D:\code\xampp\htdocs\sque\basic\commands\error_log.txt';

if (!file_exists($errorLogPath)) {
  file_put_contents($errorLogPath, "");
}
ini_set('error_log', $errorLogPath);

use yii\console\Controller;
use app\models\Questions;
use yii\db\Expression;
use yii\db\Query;

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
    $subqueryAnswers = (new Query())
      ->select(['question_id'])
      ->from('answers')
      ->groupBy('question_id')
      ->having('COUNT(*) >= 3');

    $subqueryLikes = (new Query())
      ->select(['question_id'])
      ->from('likes')
      ->groupBy('question_id')
      ->having('COUNT(*) >= 5');

    $questions = Questions::find()
      ->innerJoin(['ans' => $subqueryAnswers], 'questions.id = ans.question_id')
      ->innerJoin(['lik' => $subqueryLikes], 'questions.id = lik.question_id')
      ->where(['questions.status' => 4])
      ->andWhere(['<', new Expression('questions.moderated_at + 86400'), time()])
      ->all();

    print_r($questions);
    foreach ($questions as $question) {
      $question->status = 5;
      $question->voting_at = time();
      $question->update(false); // 'false' skips validation, change to 'true' if validation is needed
    }
  }

  private function TransferToArchive()
  {
    $questions = Questions::find()
      ->where(["status" => 5])
      ->andWhere(['<', new \yii\db\Expression('voting_at + 86400'), time()])
      ->all();

    print_r($questions);
    foreach ($questions as $question) {
      $question->status = 6;
      $question->closed_at = time();
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
