<?php 

namespace backend\tests;
use yii;
use backend\models\LoginForm;
use common\models\AdminUsers;

class PublisherUserManagementTest extends \Codeception\Test\Unit
{
    const DATETIME = 'Y:m:d H:i:s';
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

        $model->name   = 'Some Name';
        $model->email  = 'validmail@example.com';
        $model->mobile = '9876543210';
        $model->status = 'Active';
        $model->created_on = date(self::DATETIME);
        $model->created_ip = '127.0.0.1';
        $model->modified_on = date(self::DATETIME);
        $model->modified_ip = '127.0.0.1';
        $model->password    = Yii::$app->generalFunctions->password_generate();
        $model->role_id    = 0;

        $users = $model->createPublisher();

        expect($users)->isInstanceOf('common\models\AdminUsers');
        expect($users->name)->equals('Some Name');
        expect($users->email)->equals('validmail@example.com');
        expect($users->status)->equals('Active');

        $this->tester->seeRecord(AdminUsers::class,['name'=>'Some Name']);
    }
     // Update User
     public function testUpdateUser()
     {
         $user = $this->insertData();
         $model = AdminUsers::findOne($user->id);
         $model->name = 'Some Name';
         $model->email = 'validmail@example.com';
         $model->mobile = '9876543210';
         $model->status = 'Active';
         $users = $model->createPublisher();
 
         expect($users)->isInstanceOf('common\models\AdminUsers');
         expect($users->name)->equals('Some Name');
         expect($users->email)->equals('validmail@example.com');
         expect($users->status)->equals('Active');
     }
     //Check Validation 
     public function testCheckEmailUnique()
     {
        $this->insertData();
        $model = new AdminUsers();
        $model->name   = 'Some Name';
        $model->email  = 'validmail@example.com';
        $model->mobile = '9876543210';
        $model->status = 'Active';
        $model->created_on = date(self::DATETIME);
        $model->created_ip = '127.0.0.1';
        $model->modified_on = date(self::DATETIME);
        $model->modified_ip = '127.0.0.1';
        $model->password    = Yii::$app->generalFunctions->password_generate();
        $model->role_id    = 0;

        expect_not($model->validate());
        expect_that($model->getErrors('email'));
        expect($model->getFirstError('email'))->equals('Email "validmail@example.com" has already been taken.');
     }

     //insert data
     public function insertData()
     {
        $model = new AdminUsers();
        $model->name   = 'Some Name';
        $model->email  = 'validmail@example.com';
        $model->mobile = '9876543210';
        $model->status = 'Active';
        $model->created_on = date(self::DATETIME);
        $model->created_ip = '127.0.0.1';
        $model->modified_on = date(self::DATETIME);
        $model->modified_ip = '127.0.0.1';
        $model->password    = Yii::$app->generalFunctions->password_generate();
        $model->role_id    = 0;

       return $model->createPublisher();
       

     }
}