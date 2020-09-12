<?php
 namespace backend\tests;
 use yii;
 use backend\models\LoginForm;
 use common\models\BannerImages;

class BannerManagementTest extends \Codeception\Test\Unit
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

    // Add Banner
    public function testAddBanner()
    {
        $model = new BannerImages();
        $model->page_key        = 'Home';
        $model->image_name      = 'new_image.jpg';
       
        $model->banner_text     = 'New Arriaval';
        $model->status          = 'Active';
        $model->banner_link     = 'text.com/textlink';
        $model->imagecrop       = 'abcd';

        $model->created_by      = 1;
        $model->created_on      = Date(self::DATETIME);
        $model->created_ip      = '127.128.0.1';
        $data = $model->saveBanner();
        expect($data)->isInstanceOf('common\models\BannerImages');
        expect($data->page_key)->equals('Home');
        expect($data->image_name)->equals('new_image.jpg');
        expect($data->status)->equals('Active');
        $this->tester->seeRecord(BannerImages::class,['page_key'=>'Home','status'=>'Active','banner_text'=>'New Arriaval']);
    }
    // Edit Banner
    public function testEditBanner()
    {
        $bannerData = $this->insertBannerData();
        $model = BannerImages::findOne($bannerData->id);
        $model->page_key        = 'Contact';
       
        $model->banner_text     = 'Big Billion Days';
        $model->status          = 'Inactive';
        $model->banner_link     = 'text.com/textlink';
        $model->imagecrop       = 'abcd';

        $model->created_by      = 1;
        $model->created_on      = Date(self::DATETIME);
        $model->created_ip      = '127.128.0.1';
        $data = $model->saveBanner();
        expect($data)->isInstanceOf('common\models\BannerImages');
        expect($data->page_key)->equals('Contact');
        expect($data->status)->equals('Inactive');
        $this->tester->seeRecord(BannerImages::class,['page_key'=>'Contact','status'=>'Inactive','banner_text'=>'Big Billion Days']);
    }
      // Edit Product
      public function testInavalidData()
      {
          $bannerData = $this->insertBannerData();
          $model = BannerImages::findOne($bannerData->id);
          $model->page_key        = null;
         
          $model->banner_text     = 'Big Billion Days Big Billion Days Big Billion Days Big Billion Days ';
          $model->status          = null;
          $model->banner_link     = 'text.com/textlink';
          $model->imagecrop       = 'abcd';
  
          $model->created_by      = 1;
          $model->created_on      = Date(self::DATETIME);
          $model->created_ip      = '127.128.0.1';
          $data = $model->saveBanner();

          expect_not($data);
         expect_that($model->getErrors('page_key'));
         expect($model->getFirstError('page_key'))->equals('Page Key cannot be blank.');

         expect_that($model->getErrors('banner_text'));
         expect($model->getFirstError('banner_text'))->equals('Banner Text should contain at most 20 characters.');

         expect_that($model->getErrors('status'));
         expect($model->getFirstError('status'))->equals('Status cannot be blank.');
      }
    //Insert Banner Data
    public function insertBannerData()
    {
        $model = new BannerImages();
        $model->page_key        = 'Home';
        $model->image_name      = 'new_image.jpg';
       
        $model->banner_text     = 'New Arriaval';
        $model->status          = 'Active';
        $model->banner_link     = 'text.com/textlink';
        $model->imagecrop       = 'abcd';

        $model->created_by      = 1;
        $model->created_on      = Date(self::DATETIME);
        $model->created_ip      = '127.128.0.1';
        $model->saveBanner();
       return $model;
    }
}