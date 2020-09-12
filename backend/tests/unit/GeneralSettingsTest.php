<?php 
namespace backend\tests;

 use yii;
 use backend\models\LoginForm;
 use common\models\GeneralSettings;

class GeneralSettingsTest extends \Codeception\Test\Unit
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

    // tests
    public function testCorrectAddAddress()
    {
        $model = new GeneralSettings();

        $data = $model->saveGeneralSettings('Address');

        expect($data->address)->equals('Test Address');

    }
}