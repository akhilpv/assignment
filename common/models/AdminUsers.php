<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin_users".
 *
 * @property int $id
 * @property string $password
 * @property string $name
 * @property string $profile_image
 * @property string $email
 * @property int $role_id
 * @property string $mobile
 * @property int $reset_otp
 * @property string $reset_otp_expired_on
 * @property string $created_on
 * @property string $created_ip
 * @property string $modified_on
 * @property string $modified_ip
 * @property string $status
 * @property string $password write-only password
 *
 * @property AdminRoles $role
 */


class AdminUsers extends ActiveRecord implements IdentityInterface
{
    
    public $old_password;
    public $confirm_password;
    public $imageResize = [];
    const STATUS_ACTIVE        = 'active';
  
    const DATETIME = 'Y-m-d H:i:s';
    const PASSWORD = 'password';
    const CONFIRM_PASSWORD ='confirm_password';
    const OLD_PASSWORD ='old_password';
    const MOBILE = 'mobile';
    const ROLE_ID = 'role_id';
    const EMAIL = 'email';
    const CREATED_ON ='created_on';
    const CREATED_IP ='created_ip';
    const MODIFIED_ON ='modified_on';
    const MODIFIED_IP ='modified_ip';
    const STATUS ='status';
    const STRING_NAME = 'string';
    
     /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_users';
    }
  
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password',self::CONFIRM_PASSWORD,self::OLD_PASSWORD],'required','on'=>'change_password'],
            [[self::ROLE_ID],'required','on'=>'add__update_admin_user'],
            [['password',self::CONFIRM_PASSWORD],'required','on'=>'update_user_pswd'],
            [[self::PASSWORD,self::MOBILE, 'name', self::EMAIL, self::CREATED_ON, self::CREATED_IP, self::MODIFIED_ON, self::MODIFIED_IP, self::STATUS], 'required'],
            [[self::ROLE_ID, 'reset_otp'], 'integer'],
            [['reset_otp_expired_on', self::CREATED_ON, self::MODIFIED_ON,'sent_login_credential'], 'safe'],
            [[self::STATUS], self::STRING_NAME],
            [[self::PASSWORD, 'name'], self::STRING_NAME, 'max' => 256],
            ['name','match','pattern'=>'/^[A-z \s]+$/i'],
            [['mobile'],  'match', 'pattern'=>'/^([+]?([0-9 -]{10})+)$/', 'message' => 'Please enter valid phone number'],
            [[self::MOBILE], self::STRING_NAME, 'max' => 16],
            [[self::CREATED_IP, self::MODIFIED_IP], self::STRING_NAME, 'max' => 50],
            [[self::EMAIL], 'unique'],
            [self::EMAIL,self::EMAIL],
            [[self::EMAIL], self::STRING_NAME, 'max' => 150],
            [[self::PASSWORD], self::STRING_NAME, 'max' => 255,'min'=>6],
            [self::CONFIRM_PASSWORD, 'compare', 'compareAttribute'=>self::PASSWORD, 'message'=>"Passwords don't match"],
            [[self::ROLE_ID], 'exist', 'skipOnError' => true, 'targetClass' => AdminRoles::className(), 'targetAttribute' => [self::ROLE_ID => 'id'],'on'=>'add__update_admin_user'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            self::PASSWORD => 'Password',
            'name' => 'Name',
            'profile_image' => 'Profile Image',
            self::EMAIL => 'Email',
            self::ROLE_ID => 'Role',
            self::MOBILE => 'Mobile',
            'reset_otp' => 'Reset Otp',
            'reset_otp_expired_on' => 'Reset Otp Expired On',
            self::CREATED_ON => 'Created On',
            self::CREATED_IP => 'Created Ip',
            self::MODIFIED_ON => 'Modified On',
            self::MODIFIED_IP => 'Modified Ip',
            self::STATUS => 'Status',
        ];
    }
    /**
     *  matching the old password with your existing password.
     * if password match 
     * @return true, //And Update Password
     * */
	public function changeAdminPassword()
	{
         $user = AdminUsers::findOne(Yii::$app->user->id);
        if (!(Yii::$app->security->validatePassword($this->old_password, $user->password))) {
            $this->addError(self::OLD_PASSWORD, 'Old password is incorrect.');
        } else {
            $this->scenario = 'change_password';
            $this->password =  Yii::$app->security->generatePasswordHash($this->confirm_password);
            return $this->save(false);
        }

	}
      /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(AdminRoles::className(), ['id' => self::ROLE_ID]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublisher()
    {
        return $this->hasOne(Publishers::className(), ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, self::STATUS => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }


     /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne([self::EMAIL => $username, self::STATUS => self::STATUS_ACTIVE]);
    }
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        return static::findOne([
            'reset_otp_token' => $token,
            self::STATUS => self::STATUS_ACTIVE,
        ]);
    }
    
     /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
     /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->reset_otp = rand(100000,999999);
    }
    /**
     * Function For Change Users Password 
     */
    public function changePassword()
    {
       
            $password = $this->password;
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            if ($this->save(false)) { 
                $this->sendUserCredentials($this->email,$this->name, $password, 'passwordchanged');
                return $this;
            } else {
                return null;
            }
    }
    /**
     * Create Admin Users 
     */
    public function createAdminUser()
    {
        
        $password = $this->password;
        $this->password = Yii::$app->security->generatePasswordHash($this->password);
        $this->save();           
        $this->sendUserCredentials($this->email,$this->name, $password);
        return $this;
    }
    /**
     * Create Admin Users 
     */
    public function updateAdminUser()
    {
        if ($this->validate()) {
            $this->save();
            return $this;
        }
        return null;
    }

      /**
     * Send User Credentials
     */

    public function sendUserCredentials($email,$name,$password, $type="create"){
		
		if (Yii::$app->backendEmails->adminLoginCredentials($email,$email, $password, $name, $type)) {
            $this->sent_login_credential = 1;
            $this->save();
        }
    }
    
}
