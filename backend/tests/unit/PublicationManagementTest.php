<?php
 namespace backend\tests;
 use yii;
use backend\models\LoginForm;
use common\models\Publications;
use common\models\AdminUsers;
use common\models\Categories;
use common\models\Publishers;

class PublicationManagementTest extends \Codeception\Test\Unit
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

   // Insert Publications
    public function testAddPublications()
    {
        $model = new Publications();
        $publisher = $this->insertPublicationDetails();
        $category  = $this->insertCategory();

        $model->publisher_id           =  $publisher->id;
        $model->publisher_name         = 'Some Name';
        $model->type                   = 'Daily';
        $model->category_id            = $category->id;
        $model->subscription_amount    = '250';
        $model->description            = 'Some Description for publications';
        $model->status                 = 'Active';

        $publication = $model->savePublication();

        expect($publication)->isInstanceOf('common\models\Publications');
        expect($publication->publisher_name)->equals('Some Name');
        expect($publication->type)->equals('Daily');
        expect($publication->subscription_amount)->equals('250');
        expect($publication->publisher_id)->equals($publisher->id);

        $this->tester->seeRecord(Publications::class,['publisher_name'=>'Some Name','publisher_id'=>$publisher->id]);
    }

     // Insert Publications With Null Value
     public function testInvalidAddWithEmptyValue()
     {
         $model = new Publications();
 
         $model->publisher_id           = Null;
         $model->publisher_name         = Null;
         $model->type                   = null;
         $model->category_id            = null;
         $model->subscription_amount    = null;
         $model->description            = 'Some Description for publications';
         $model->status                 = null;
 
         $data = $model->savePublication();
 
         expect_not($data);
         expect_that($model->getErrors('publisher_id'));
         expect($model->getFirstError('publisher_id'))->equals('Publisher cannot be blank.');

         expect_that($model->getErrors('publisher_name'));
         expect($model->getFirstError('publisher_name'))->equals('Title cannot be blank.');

         expect_that($model->getErrors('type'));
         expect($model->getFirstError('type'))->equals('Type cannot be blank.');

         expect_that($model->getErrors('category_id'));
         expect($model->getFirstError('category_id'))->equals('Category cannot be blank.');

         expect_that($model->getErrors('subscription_amount'));
         expect($model->getFirstError('subscription_amount'))->equals('Subscription Amount cannot be blank.');

         expect_that($model->getErrors('status'));
         expect($model->getFirstError('status'))->equals('Status cannot be blank.');

     }

      // Insert Publications
      public function testInvalidAddValidationErrors()
      {
          $model = new Publications();
          $publisher = $this->insertPublicationDetails();
          $category  = $this->insertCategory();
  
          $model->publisher_id           = $publisher->id;
          $model->publisher_name         = 'Test Name 1';
          $model->type                   = 'Weekly';
          $model->category_id            =  $category->id;
          $model->subscription_amount    = 'test';
          $model->description            = 'Some Description for publications';
          $model->status                 = 'Pending';
          

          $data = $model->savePublication();
  
          expect_not($data);

          expect_that($model->getErrors('publisher_name'));
          expect($model->getFirstError('publisher_name'))->equals('Invalid characters in Title.');
 
          expect_that($model->getErrors('subscription_amount'));
          expect($model->getFirstError('subscription_amount'))->equals('Subscription Amount must be a number.');
 
      }      
    //insert Publisher Data to get publisher id
    public function insertPublicationDetails()
    {
        $model = $this->insertPublisherData();
        $publisherModel   =  new Publishers();
        $publisherModel->title  = 'Some Name';
        $publisherModel->email  = $model->email;
        $publisherModel->mobile = $model->mobile;
        $publisherModel->created_ip = $model->created_ip;
        $publisherModel->user_id = $model->id;
        $publisherModel->status  = $model->status;

        return $publisherModel->savePublisherDetails();

    }
      //Creating publiser user
      public function insertPublisherData()
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
      
       //insert Category to get Category Data
    public function insertCategory()
    {
          //Insert Parent Category
          $model = new Categories();
         
          $model->category_name = 'Some Category';
          $model->description  = 'Some Description';
          $model->status       = 'Active';
         
  
          $model->created_by      = 1;
          $model->created_on      = Date(self::DATETIME);
          $model->created_ip      = '127.128.0.1';
          $data = $model->saveCategory();  
          return $model; 
    }
}