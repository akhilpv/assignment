<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;
                  
$this->title = $name;
if (Yii::$app->user->isGuest) {
  Yii::$app->response->redirect(Url::to(['site/index'], true));
}
?>

<!-- Main content -->
<section class="content">
      <div class="error-page">
        <h2 class="headline text-red"> <?=Yii::$app->response->statusCode?></h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-red"></i><?= Html::encode($this->title)?></h3>

          <p>
          <?=nl2br(Html::encode($message)) ?>
            Meanwhile, you may <a href="<?=url::to(['site/index'])?>">return to dashboard</a>
          </p>

        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->