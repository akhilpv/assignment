<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
const LOGIN_TEMPLATE = '<div class="form-group has-feedback">{input}{error}{hint}';
$imageURL = Url::base(true).Yii::getAlias('@imagePath').'/';
?>

<div class="login-box-body">
   <!-- Alert Message -->
   <?=Yii::$app->controller->renderpartial('@app/views/layouts/_alert_message')?>
    <!-- //Alert Message -->
    <p class="login-box-msg"> <img src="<?=$imageURL?>logo.png"  width="170px" height="35px"></p>
 
    <?php 
        $form = ActiveForm::begin(['id' => 'login-form']); 

        echo $form->field($model, 'username', ['template' => LOGIN_TEMPLATE.'<span class="glyphicon glyphicon-envelope form-control-feedback"></span></div>'])
                ->textInput(['autofocus' => true,'placeholder'=>'Email',CONST_CLASS=>'form-control']); 

        echo  $form->field($model, 'password', ['template' => LOGIN_TEMPLATE.'<span class="glyphicon glyphicon-lock form-control-feedback"></span></div>'])
                ->passwordInput(['autofocus' => true,'placeholder'=>'Password',CONST_CLASS=>'form-control']) 
    ?>
        <div class="row">

            <div class="col-xs-6">
                <a href="<?=Url::to(['site/request-password-reset'])?>" class="pt-1 d-block">I forgot my password</a>
            </div>  

            <div class="col-xs-2"></div>

            <div class="col-xs-4">
                <?= Html::submitButton('Sign In', [CONST_CLASS => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>

        </div>
    <?php ActiveForm::end(); ?>
</div>