<?php 
namespace backend\tests;
use yii;
use backend\models\LoginForm;
use common\models\Categories;

class CategoryManagementTest extends \Codeception\Test\Unit
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

    // Add Category
    public function testAddCategory()
    {
        $model = new Categories();
        $model->category_name = 'Some Category';
        $model->description  = 'Some Description';
        $model->status       = 'Active';
        $model->created_by      = 1;
        $model->created_on      = Date(self::DATETIME);
        $model->created_ip      = '127.128.0.1';
        $data = $model->saveCategory();
        expect($data)->isInstanceOf('common\models\Categories');
        expect($data->category_name)->equals('Some Category');
        expect($data->description)->equals('Some Description');
        expect($data->status)->equals('Active');
        $this->tester->seeRecord(Categories::class,['category_name'=>'Some Category','status'=>'Active','slug'=>'some-category']);
    }
    //Add Parent SubCategory
    public function testAddSubCategory()
    {
        $parentData = $this->insertCategory();
        //Insert Parent Category
        $model = new Categories();
        $model->category_name = 'Some Category';
        $model->description  = 'Some Description';
        $model->status       = 'Active';

        $model->created_by      = 1;
        $model->created_on      = Date(self::DATETIME);
        $model->created_ip      = '127.128.0.1';
        $data = $model->saveCategory();
        
        expect($data)->isInstanceOf('common\models\Categories');
        expect($data->category_name)->equals('Some Category');
        expect($data->description)->equals('Some Description');
        expect($data->status)->equals('Active');
        $this->tester->seeRecord(Categories::class,['category_name'=>'Some Category','status'=>'Active','slug'=>'some-category','parent_id'=>$parentData->id]);
    }
    //Edit Category
    public function testEditCategory()    
    {
        $dataModel = $this->insertCategory();
        $model = Categories::findOne($dataModel->id);
        $model->category_name = 'New Category';
        $model->description  = 'New Description';
        $model->status       = 'Active';


        $model->created_by      = 1;
        $model->created_on      = Date(self::DATETIME);
        $model->created_ip      = '127.128.0.1';
        
        $model->modified_by      = 1;
        $model->modified_on      = Date(self::DATETIME);
        $model->modified_ip      = '127.128.0.1';
        $data = $model->saveCategory();  

        expect($data)->isInstanceOf('common\models\Categories');
        expect($data->category_name)->equals('New Category');
        expect($data->description)->equals('New Description');
        expect($data->status)->equals('Active');
        $this->tester->seeRecord(Categories::class,['category_name'=>'New Category','status'=>'Active','slug'=>'some-category']);
    }
    //Incorrect Add Category
    public function testIncorrectAddCategory()
    {
         //Insert Parent Category
         $model = new Categories();

         $model->category_name = 'Some Category 1';
         $model->description  = null;
         $model->status       = null;
       
 
         $model->created_by      = 1;
         $model->created_on      = Date(self::DATETIME);
         $model->created_ip      = '127.128.0.1';
         $data = $model->saveCategory();  
         expect_not($data);
         expect_that($model->getErrors('category_name'));
         expect($model->getFirstError('category_name'))->equals('Invalid characters in Category Name.');

        

         expect_that($model->getErrors('status'));
         expect($model->getFirstError('status'))->equals('Status cannot be blank.');

    }

    //insert Data
    public function insertCategory()
    {
          //Insert Parent Category
          $model = new Categories();
          $model->parent_id = 0;
          $model->category_name = 'Some Category';
          $model->description  = 'Some Description';
          $model->status       = 'Active';
          $model->seo_title    = 'Seo Title';
          $model->seo_description = 'Seo Description';
          $model->seo_metatag     = 'Seo Metatag';
  
          $model->created_by      = 1;
          $model->created_on      = Date(self::DATETIME);
          $model->created_ip      = '127.128.0.1';
          $data = $model->saveCategory();  
          return $model; 
    }
}