<?php 
namespace backend\tests;
use common\models\AdminRoles;
use backend\models\LoginForm;
use yii;
class AddRolesTest extends \Codeception\Test\Unit
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

    // Correct Add Role
    public function testCorrectAddRole()
    {
        $model = new AdminRoles();
        $model->role_name = 'Some Role';
        $model->status    = 'Active';

        expect($model->validate());
        expect($model->saveRole());

        expect($model)->isInstanceOf('common\models\AdminRoles');
        expect($model->role_name)->equals('Some Role');
        expect($model->status)->equals('Active');
    }
    // Correct Add Role With Inactive Status
    public function testCorrectAddRoleInactive()
    {
        $model = new AdminRoles();
        $model->role_name = 'Some Role';
        $model->status    = 'Inactive';

        expect($model->validate());
        expect($model->saveRole());

        expect($model)->isInstanceOf('common\models\AdminRoles');
        expect($model->role_name)->equals('Some Role');
        expect($model->status)->equals('Inactive');
    }

    //Check Role Name Unique
    public function testRoleNameUnique()
    {
        $model = new AdminRoles();
        $model->role_name = 'Admin';
        $model->status    = 'Active';

        $this->assertFalse($model->validate());

        expect_that($model->getErrors('role_name'));
        expect($model->getFirstError('role_name'))
        ->equals('Role Name "Admin" has already been taken.');
    } 
    // Adding Invalid Role Name
    public function testInvalidRoleName()
    {
        $model = new AdminRoles();
        $model->role_name = 'Admin@13';
        $model->status    = 'Active';

        expect_not($model->validate());

        expect_that($model->getErrors('role_name'));
        expect($model->getFirstError('role_name'))->equals('Invalid characters in Role Name.');
    }
    // Adding With Null Value
    public function testNullValue()
    {
        $model = new AdminRoles();
        $model->role_name = null;
        $model->status    = null;

        $this->assertFalse($model->validate());

        expect_that($model->getErrors('role_name'));
        expect_that($model->getErrors('status'));

        expect($model->getFirstError('role_name'))->equals('Role Name cannot be blank.');
        expect($model->getFirstError('status'))->equals('Status cannot be blank.');
    }
}