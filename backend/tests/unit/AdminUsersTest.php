<?php
namespace backend\tests;
use yii;
use backend\models\LoginForm;
use common\models\AdminUsers;
use common\models\AdminRoles;
class AdminUsersTest extends \Codeception\Test\Unit
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

    // Currect Add
    public function testCorrectAdd()
    {
        $model = new AdminUsers();
        $model->name = 'Some Name';
        $model->email = 'validmail@example.com';
        $model->mobile = '9876543210';
        $model->role_id = '8';
        $model->password = 'somepassword';
        $model->status = 'Active';
        $users = $model->createAdminUser();

        expect($users)->isInstanceOf('common\models\AdminUsers');
        expect($users->name)->equals('Some Name');
        expect($users->email)->equals('validmail@example.com');
        expect($users->role_id)->equals('8');
        expect($users->status)->equals('Active');
    }
    // Update User
    public function testUpdateUser()
    {
        $model = AdminUsers::findOne(1);
        $model->name = 'Some Name';
        $model->email = 'validmail@example.com';
        $model->mobile = '9876543210';
        $model->role_id = '8';
        $model->password = 'somepassword';
        $model->status = 'Active';
        $users = $model->createAdminUser();

        expect($users)->isInstanceOf('common\models\AdminUsers');
        expect($users->name)->equals('Some Name');
        expect($users->email)->equals('validmail@example.com');
        expect($users->role_id)->equals('8');
        expect($users->status)->equals('Active');
    }
    //Not Currect Add
    public function testNotCorrectAdd()
    {
        $model = new AdminUsers();
        $model->name = 'Some@!Name';
        $model->email = 'valid@mail.com';
        $model->mobile = '77567dsf';
        $model->role_id = '8';
        $model->password = 'som';
        $model->status = null;
        $this->tester->assertFalse($model->validate());

        expect_that($model->getErrors('name'));
        expect($model->getFirstError('name'))->equals('Name is invalid.');
        expect_that($model->getErrors('mobile'));
        expect($model->getFirstError('mobile'))->equals('Please enter valid phone number');
        expect_that($model->getErrors('password'));
        expect($model->getFirstError('password'))->equals('Password should contain at least 6 characters.');
        expect_that($model->getErrors('status'));
        expect($model->getFirstError('status'))->equals('Status cannot be blank.');
    }
    // Check email has unique 
    public function testCheckUniqueEmail()
    {
        $model = new AdminUsers();
        $model->name = 'Some Name';
        $model->email = Yii::$app->params['testUsername'];
        $model->mobile = '9876543210';
        $model->role_id = '8';
        $model->password = 'somepassword';
        $model->status = 'Active';
        $this->tester->assertFalse($model->validate());

        expect_that($model->getErrors('email'));
        expect($model->getFirstError('email'))->equals('Email "'.$model->email.'" has already been taken.');
        //See the mail has already exist in the table
        $this->tester->seeRecord(AdminUsers::class,['email'=>$model->email]);
    }

}