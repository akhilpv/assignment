<?php
namespace backend\tests;
use yii;
use backend\models\LoginForm;
use common\models\AdminRoles;
class UpdateRoleTest extends \Codeception\Test\Unit
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

    // Update User Role
    public function testUpdateRole()
    {
        $model = AdminRoles::findOne(1);
        $model->role_name = 'New Role';
        $model->status = 'Active';
        $model->saveRole();

        expect($model)->isInstanceOf('common\models\AdminRoles');
        expect($model->role_name)->equals('New Role');
        expect($model->status)->equals('Active');
        

    }
    //Update User Role With Invalid Name
    public function testInvalidName()
    {

        $model = AdminRoles::findOne(1);
        $model->role_name = 'dfd454';
        $model->status = 'Active';
        expect_not($model->validate());
        expect_that($model->getErrors('role_name'));
        expect($model->getFirstError('role_name'))
        ->equals('Invalid characters in Role Name.');
    }
    //Update Role With Invalid Id
    public function testInvalidId()
    {
        $model = AdminRoles::findOne(0);
       $this->tester->assertNull($model);
    }
}