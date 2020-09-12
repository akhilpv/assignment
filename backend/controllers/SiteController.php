<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use linslin\yii2\curl;


use yii\web\UnauthorizedHttpException;

use backend\models\PasswordResetRequestForm;
use backend\models\PasswordOtpRequestForm;
use backend\models\LoginForm;

use common\models\NewTicket; //for test

use common\models\AdminUsers;

/**
 * Site controller
 */
const CONTACTID = '';
const REDIRECT_INDEX = 'site/index';
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        $this->layout = 'main';
        return [
            'access' => [
                CONST_CLASS => AccessControl::className(),
                'rules' => [
                    [
                        ACTIONS => ['login',ERROR],
                        'allow' => true,
                    ],
                    [
                        ACTIONS => ['logout','index','unautherized','new-ticket','get-departments','list-tickets'
                                    ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                CONST_CLASS => VerbFilter::className(),
                ACTIONS => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                CONST_CLASS => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
     
        return $this->render('index');
    }

    public function actionNewTicket()
    {
        $curl = new curl\Curl();
        $model = new NewTicket();
        $departments=$this->getData('departments');
        $user=AdminUsers::findOne(Yii::$app->user->getId());
        $departments=ArrayHelper::map($departments['data'],'id','name');
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post())) {
            $param['contactId']     =   $session->get('contactid');
            $param['departmentId']  =   $model["department"];
            $param['category']      =   $model["category"];
            $param['subject']       =   $model["subject"];
            $param['description']   =   $model["description"];
            $response = $this->postData($param,'tickets');
            // print_R($response);
            Yii::$app->session->setFlash(SUCCESS,'Created a new ticket');
            // return $this->redirect($returnUrl);
        }

        return $this->render('new-ticket',compact('model','departments','user'));
    }

    public function actionListTickets()
    {
        $curl = new curl\Curl();
        $session = Yii::$app->session;
        $slug='contacts/'.$session->get('contactid').'/tickets?include=departments';
        
        $response=$this->getData($slug);
        
        return $this->render('ticket-list',compact('response'));
    }

    public function postData($paramArray,$slug)
    {
        $curl = new curl\Curl();
        $response = $curl->setRawPostData(json_encode($paramArray))
            ->setHeaders([
                'Content-Type' => 'application/json',
                'orgId'=>'60001280952',
                'Authorization' => '9446933330c7f886fbdf16782906a9e0',
            ])
            ->post('https://desk.zoho.in/api/v1/'.$slug);
           
            $data=json_decode($response);
            return $data;
    }

    public function getData($slug,$deptid='')
    {

        $curl = new curl\Curl();
        $params=[];
        if(!empty($deptid))
        {
           $params= [
                'departmentId'=>$deptid,
           ];
        }
        $response = $curl->setGetParams($params)
        ->setHeaders([
            'orgId'=>'60001280952',
            'Authorization' => '9446933330c7f886fbdf16782906a9e0',
         ])
         ->get('https://desk.zoho.in/api/v1/'.$slug);

        $data=json_decode($response,true);
        return $data;
        
    }

    public function actionGetDepartments()
    {
        $id  = Yii::$app->request->post('id');
        $options='';
        $data=$this->getData('kbRootCategories',$id);
        foreach($data['data'] as $key=>$val){
            $options .= "<option value=".$val['translations'][0]['name'].">".$val['translations'][0]['name']."</option>";
        }
        echo $options;
        die;
    }
    
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = LOGIN_MAIN;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->password = '';
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $userModel=AdminUsers::findOne(Yii::$app->user->getId());
            $contactparams['firstName']     =   $userModel['name'];
            $contactparams['lastName']      =   $userModel['name'];
            $contactparams['email']         =   $userModel['email'];
            $contactparams['mobile']        =   $userModel['mobile'];
            $contact                =   $this->postData($contactparams,'contacts');
            $session = Yii::$app->session;
            $session->set('contactid', $contact->id);
                    return $this->goBack();
        } else {
          
                return $this->render('login', [
                    MODEL => $model,
                ]);
           
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
     
   
}
