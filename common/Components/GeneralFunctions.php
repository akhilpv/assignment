<?php
namespace common\components;

use Yii;
use yii\helpers\Url;
use yii\helpers\BaseFileHelper;
const USER_VIEW = 'userView';
const RETURN_URL = 'returnURL';
class GeneralFunctions {
    public $basePath = "@webroot";
    public $repoArray = array();
    /**
     * Set from  url in session
     * @ return Url
     */
    public function returnUrl($current_user,$returnUrl)
    {	
        
        if (strcmp(Yii::$app->request->referrer, str_replace($this->repoArray, '', Url::base(true)) . Yii::$app->request->url)) {
            Yii::$app->session[USER_VIEW . $current_user . RETURN_URL] = Yii::$app->request->referrer;
        }
        return (isset(Yii::$app->session[USER_VIEW . $current_user . RETURN_URL])) ? Yii::$app->session[USER_VIEW . $current_user . RETURN_URL] : $returnUrl;
    }
   /**
    * check data exist 
    *if exist return model or redirect previous page with error
    */
    public function  checkDataExist($class,array $fields,string $returnUrl,array $conditions =[]) 
    {
       
        $model = $class::find()->where($fields)->andWhere($conditions)->one();
        if (!empty($model)) {
            return $model;
        } else {
            Yii::$app->session->setFlash(ERROR,  Yii::t(USER_ALERETS,'dataNotExist'));
            Yii::$app->getResponse()->redirect($returnUrl);
            Yii::$app->end();
        }
    }

    public function slugify($str, $delimiter='-') {
        $clean = trim($str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        return preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
     }


    /** 
     *  Get  Unique username 
     * Prefix Prefix append to the username 
     * $class class name of model , model::class
     * $field Validation table field name
     * */
    public function getUsername(string $prefix,$class = null,$field = null) :string {
        if ($class == null) {
            return $this->createUsername($prefix);
        }
        return $this->checkUsernameUnique($class,$field, $prefix);
    }
    //Checking Username has unique
    public function checkUsernameUnique($class,$field, $prefix){
        $username = $this->createUsername($prefix);
        $user = $class::find()->where([$field=>$username])->one();
        if (!empty($user)) {
            $this->checkUsernameUnique($class,$field, $prefix);
        }
        return $username;
    }
    //Create Username 
    public function createUsername(string $prefix) {
        return $prefix.str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }
    //Generate Password 
    //$char used for password length
    function password_generate($chars=6) 
    {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }

    /**
     * @date required, dates in any format 
     * @format optional,Specify date format
     */
    public function create_date_format($date,string $format = 'm-d-Y') : string
    {
        if (!empty($date)) {
        $newDate = date_create($date);
       
        return date_format($newDate,$format);
        } else {
            return '';
        }

    }

    function convertNumberToWords($number) {
        $hyphen      = ' ';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
        );
        
        if (!is_numeric($number)) {
        return false;
        }
        
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
        'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
        E_USER_WARNING
        );
        return false;
        }
        
        if ($number < 0) {
        return $negative . $this->convertNumberToWords(abs($number));
        }
        
        $string = $fraction = null;
        
        if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
        }
        
        switch (true) {
        case $number < 21:
        $string = $dictionary[$number];
        break;
        case $number < 100:
        $tens   = ((int) ($number / 10)) * 10;
        $units  = $number % 10;
        $string = $dictionary[$tens];
        if ($units) {
        $string .= $hyphen . $dictionary[$units];
        }
        break;
        case $number < 1000:
        $hundreds  = $number / 100;
        $remainder = $number % 100;
        $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
        if ($remainder) {
        $string .= $conjunction . $this->convertNumberToWords($remainder);
        }
        break;
        default:
        $baseUnit = pow(1000, floor(log($number, 1000)));
        $numBaseUnits = (int) ($number / $baseUnit);
        $remainder = $number % $baseUnit;
        $string = $this->convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
        if ($remainder) {
        $string .= $remainder < 100 ? $conjunction : $separator;
        $string .= $this->convertNumberToWords($remainder);
        }
        break;
        }
        
        if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
        $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
        }
        
        return $string;
        }

        
}
?>
