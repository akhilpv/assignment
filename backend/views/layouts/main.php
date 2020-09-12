<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AdminAsset;
use yii\helpers\Html;
use  yii\web\View;
use yii\helpers\Url;

AdminAsset::register($this);
$this->registerJsFile("@web/backend/web/bower_components/jquery/dist/jquery.min.js");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="">
     <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="skin-blue sidebar-mini wysihtml5-supported">
<?php $this->beginBody() ?>

<div class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php echo Yii::$app->controller->renderpartial('@app/views/layouts/admin-header'); ?>
<?php echo Yii::$app->controller->renderpartial('@app/views/layouts/admin-menu'); ?>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <?php echo Yii::$app->controller->renderpartial('@app/views/layouts/breadcrumbs'); ?>
    <!-- Content Header (Page header) -->
    <?= $content ?>   
     <!-- Main content End -->
</div>

<?php echo Yii::$app->controller->renderpartial('@app/views/layouts/admin-footer'); ?>

<?php
$this->registerJs(
   " 
   setInterval(getNotificationUpdates, 10000);
   function getNotificationUpdates(){
      $.ajax({'type': 'GET',
         'url': '". Url::to(['site/get-notification-updates'])."',		  
         'cache': false,
         'dataType': 'json',
         'success': function (response) {								
            if(parseInt(response.notification) > 0) {
               //$('#notification-block').removeClass('hide');
               if(parseInt(response.notification) > 0 ){
                  count = parseInt(response.notification) > 999 ? '999+' : response.notification;
                  
                  $('#count-notification').html(count);
                  //$('#count-notification').removeClass('hide');
               }else{
                  $('#count-notification').html();
                  //$('#count-notification').addClass('hide');
               }
               if(response.notificationSummary !=''){
                  $('#notification-block ul.bounceInDown').html(response.notificationSummary);
               }else{
                  $('#notification-block ul.bounceInDown').html('');
               }									
            }else{
               //$('#notification-block').addClass('hide');
               $('#count-notification').html();
               //$('#count-notification').addClass('hide');
            }
         }
      });
   }
   ",
   View::POS_READY,
   'notification-handler'
); 
 $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
