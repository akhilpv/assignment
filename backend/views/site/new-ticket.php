<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use yii\widgets\ActiveForm;

$this->title = 'New Ticket';
Yii::$app->view->params['head'] = 'Add New Ticket';
$this->params[BREADCRUMBS][] =  ['label' => 'New Ticket', 'url' => 'JavaScript:void(0)'];
$this->params[BREADCRUMBS][] =$model->isNewRecord ? 'Add' : 'Update';

const FORM_TEMPLATE  ='<div class="row form-group"><div class="col-sm-3 text-right pt-1"><label>{label}</label></div><div class="col-sm-6">{input}{error}{hint}</div></div>';
const FIELD_PASSWORD = '<div class="row form-group"><div class="col-sm-3 text-right pt-1"><label>{label}</label></div><div class="col-sm-6">{input}{error}{hint}</div><a title="Hide Password" id="change_eye" onclick="showPassword(this)" href="javascript:void(0)"><i class="fa fa-eye"></i></a><a style="margin-left:4px" onclick="generatePassword()" href="javascript:void(0)">Generate Password</a></div>';
const REDIRECT_INDEX = 'admin-users/index';

$cancel_url = Url::to(['admin-users/index']);
?>    
    
<!-- Main content -->
<section class="content">
<div class="row">
<div class="col-sm-12">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?=$model->isNewRecord ? 'Add' : 'Update'?> Ticket</h3>
        </div> 
         <!-- Alert Message -->
         <?=Yii::$app->controller->renderpartial('@app/views/layouts/_alert_message')?>
        <!-- //Alert Message -->
    <!-- form start -->
    <div class="box-body">
        <?php $form =ActiveForm::begin(['id'=>'update-profile']);
                echo $form->field($user, 'name', [TEMPLATE => FORM_TEMPLATE])
                ->textInput([AUTOFOCUS => true,PLACEHOLDER=>'Subject',CONST_CLASS=>FORMCONTROL]);
                echo $form->field($user, 'email', [TEMPLATE => FORM_TEMPLATE])
                ->textInput([AUTOFOCUS => true,PLACEHOLDER=>'Subject',CONST_CLASS=>FORMCONTROL]);
                echo $form->field($model, 'department', [TEMPLATE => FORM_TEMPLATE])
                        ->dropdownList($departments,[AUTOFOCUS => true,PLACEHOLDER=>'Department','prompt'=>'select',CONST_CLASS=>FORMCONTROL,
                        'onchange' => '
                        $.post(
                            "' . Url::toRoute('get-departments') . '", 
                            {id: $(this).val()}, 
                            function(res){
                            $("#newticket-category").html(res);
                            }
                        );
                    ',]); 

                echo $form->field($model, 'category', [TEMPLATE => FORM_TEMPLATE])
                        ->dropdownList([],[AUTOFOCUS => true,PLACEHOLDER=>'Category',CONST_CLASS=>FORMCONTROL]);
                echo $form->field($model, 'subject', [TEMPLATE => FORM_TEMPLATE])
                        ->textInput([AUTOFOCUS => true,PLACEHOLDER=>'Subject',CONST_CLASS=>FORMCONTROL]);
                echo $form->field($model, 'description', [TEMPLATE => FORM_TEMPLATE])
                        ->textarea([AUTOFOCUS => true,PLACEHOLDER=>'description',CONST_CLASS=>FORMCONTROL]);
                ?>
                <div class="row form-group">
                    <div class="col-sm-3 text-right pt-1">&nbsp;</div>
                    <div class="col-sm-6 clearfix">
                        <?= Html::submitButton('Save', [CONST_CLASS => 'btn btn-primary pull-left', 'name' => 'update-profile-button']) ?>
                        <a href="<?=$cancel_url?>" class="btn btn-default pull-left ml-1">Cancel</a>
                    </div>
                </div>
        <?php ActiveForm::end(); ?>
    </div>      
    
 <!-- form End -->
    </div>
</div>
</div>
</section>
