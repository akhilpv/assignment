<?php 
namespace backend\tests;
use yii;
use backend\models\LoginForm;

class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * Invalid Login
     */
    public function testNotCorrectLogin()
    {
        $model = new LoginForm();
        $model->username = 'invalid_username';
        $model->password = 'invalid_password';
        expect_not($model->login());
        expect_that($model->getErrors('password'));
    }
    /**
     * Valid Login
     */
    public function testCorrectLogin()
    {
        $model = new LoginForm();
        $model->username = 'superadmin@yopmail.com';
        $model->password = '123456';
        $model->login();
        expect_not($model->getErrors('username'));
         expect_not($model->getErrors('password'));
    }
     /**
     * Checking Null Value
     */
    public function testNullValue()
    {
        $model = new LoginForm();
        $model->username = null;
        $model->password = null;
        expect_not($model->login());
        expect($model->hasErrors())->true();
        expect($model->getFirstError('username'))->equals('Email cannot be blank.');
        expect($model->getFirstError('password'))->equals('Password cannot be blank.');

    }
    /**
     * Login With Invalid Password
     */
    public function testNotCorrectPassword()
    {
        $model = new LoginForm();
        $model->username = 'admin@gmail.com';
        $model->password = 'invalid_password';
        expect_not($model->login());
        expect_that($model->getErrors('password'));
    }
     /**
     * Login With Invalid Username
     */
    public function testNotCorrectUsername()
    {
        $model = new LoginForm();
        $model->username = 'invalid_username';
        $model->password = '123456';
        expect_not($model->login());
        expect_that($model->getErrors('password'));
    }
}