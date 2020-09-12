<?php 
namespace backend\tests;
use yii;
use backend\models\LoginForm;
use common\models\AdminRolePermissions;
class UserRolePermissionTest extends \Codeception\Test\Unit
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

    // Insert Data to role permissions
    public function testInsertRolePermissions()
    {
        $model = new AdminRolePermissions();
        $data = json_encode(array('Manage User Roles'=>array('view','edit','delete'))); 
        $model->role_id = 1;
        $model->permissions = $data;
        $permissions = $model->updateRolePermissions();
        expect($permissions)->isInstanceOf('common\models\AdminRolePermissions');
        expect($permissions->role_id)->equals(1);

    }
    // Insert Data to role permissions
    public function testUpdateRolePermissions()
    {
        $model = new AdminRolePermissions();
        $data = json_encode(array('Manage User Roles'=>array('view','edit','delete'))); 
        $model->role_id = 1;
        $model->permissions = $data;
        $permissions = $model->updateRolePermissions();
        expect($permissions)->isInstanceOf('common\models\AdminRolePermissions');
        expect($permissions->role_id)->equals(1);

    }
    // See Record In table
    // public function testSeeRecord()
    // {
    //     $this->tester->seeRecord(AdminRolePermissions::class,['permissions'=>'{"Manage Dashboard":["view"],"Manage User Roles":["view"],"Manage Users":["view"]}']);
    // }
}