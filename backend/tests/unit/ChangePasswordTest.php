<?php 
namespace backend\tests;
use common\models\AdminUsers;
use backend\models\LoginForm;
use yii;
class ChangePasswordTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        $model = new LoginForm();
        $model->username = Yii::$app->params['testUsername'];
        $model->password = Yii::$app->params['testPassword'];
        expect($model->login());
        expect_not($model->getErrors('username'));
        expect_not($model->getErrors('password'));
    }

    protected function _after()
    {
    }
    /**
     * Correct Password Details
     */
    public function testCorrectPasswordDetails()
    {
        $model = Yii::$app->user->identity;
        $model->scenario = 'change_password';
        $model->old_password = '123456';
        $model->password     = 'newpassword';
        $model->confirm_password = 'newpassword';
        expect($model->validate());
        expect_that($model->changeAdminPassword());
    }
    /**
     * Incorrect Old Password
     */
    public function testIncorrectOldPassword()
    {
        $model = Yii::$app->user->identity;
        $model->scenario = 'change_password';
        $model->old_password = 'invalidPassword';
        $model->password     = 'newpassword';
        $model->confirm_password = 'newpassword';
        expect_not($model->changeAdminPassword());
        expect($model->getErrors());
        expect($model->hasErrors())->true();
    }
    /**
     * Lessthan minimum limit and unmatch confirm password
     */
    public function testInvalidPasswordNotMatchConfirmPassword()
    {
        $model = Yii::$app->user->identity;
        $model->scenario = 'change_password';
        $model->old_password = '123456';
        $model->password     = 'aa';
        $model->confirm_password = 'abcd';
        expect_not($model->validate());
        expect($model->getErrors());
        expect($model->hasErrors())->true();
        expect($model->getFirstError('password'))->equals('Password should contain at least 6 characters.');
        expect($model->getFirstError('confirm_password'))->equals("Passwords don't match");
    }
}