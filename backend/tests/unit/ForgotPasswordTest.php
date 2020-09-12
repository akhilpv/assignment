<?php
namespace backend\tests;

use backend\models\PasswordResetRequestForm;
use yii;
class ForgotPasswordTest extends \Codeception\Test\Unit
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
    // Send Message with wrong email address
    public function testSendMessageWithWrongEmailAddress()
    {
        $model = new PasswordResetRequestForm();
        $model->email = 'not-existing-email@example.com';
        expect_not($model->createResetOTP());
    }
    // Send Mail 
    public function testSendEmailSuccessfully()
    {
        
        $model = new PasswordResetRequestForm();
        $model->email = Yii::$app->params['testUsername'];;
        expect_that($model->createResetOTP());

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey($model->email);
    }
}