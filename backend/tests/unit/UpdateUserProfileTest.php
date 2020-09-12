<?php 
namespace backend\tests;
use common\models\AdminUsers;
use backend\models\LoginForm;
use Yii;
class UpdateUserProfileTest extends \Codeception\Test\Unit
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

    // Invalid Name and Mobile
    public function testInvalidDetails()
    {
        $model = Yii::$app->user->identity;
        $model->name   = 'ads12@';
        $model->mobile = '3432';
        $this->assertFalse($model->validate());
        $this->assertFalse($model->save());
    }
    // Update Valid Data
    public function testValidDetails()
    {
        $model = Yii::$app->user->identity;
        $model->name   = 'Valid Name';
        $model->mobile = '9876543210';
        $this->assertTrue($model->validate());
        $this->assertTrue($model->save());
        $this->tester->seeRecord(AdminUsers::class,['name'=>'Valid Name','mobile'=>'9876543210','id'=>Yii::$app->user->id]);
    }
}