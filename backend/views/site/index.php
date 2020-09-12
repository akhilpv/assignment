<?php
   /* @var $this yii\web\View */
   use yii\helpers\Url;
   use yii\helpers\Html;
   $this->title = "Dashboard";
   Yii::$app->view->params['head'] = 'Dashboard';
   $this->params['breadcrumbs'][] ='Dashboard';
   ?>
<section class="content">
 <!-- Alert Message -->
 <?=Yii::$app->controller->renderpartial('@app/views/layouts/_alert_message')?>
   <!-- //Alert Message -->
  
</section>
<!-- Main content -->