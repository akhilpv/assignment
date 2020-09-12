<?php
namespace common\components;
use Yii;

class BackendEmails {

	const MESSAGE  = 'message';
    const USERNAME ='username';
	const EMAILS   = 'emails';

    const NO_REPLAY_MAIL = ['no-reply@nasherpublisherapp.com'=>'Nasher'];
    
	public function adminLoginCredentials($emails,$username, $password, $name, $type) {

			$loginUrl = Yii::$app->urlManagerBackend->createAbsoluteUrl(['site/index']);
			$emails   = (array) $emails;
			
			if(empty($emails)){
				return false;
			}

		if ($type == 'create') {
			$subject = Yii::t('users/contents','createUserSubject');
			$message = Yii::t('users/contents','createUserContent'); 
				
			$mailer  = Yii::$app->mailer->compose('@common/mail-templates/admin/admin-user-credentials', ['name'=>$name,self::MESSAGE=>$message,self::USERNAME=>$username,'password'=>$password,'loginUrl'=>$loginUrl])
							->setFrom(self::NO_REPLAY_MAIL);
			$mailer->setTo($emails);			 
			$mailer->setSubject($subject)->send();
			return true;
		} else if ($type == 'passwordchanged') {
			$subject = Yii::t('users/contents','UserPswdUpdateSubject'); 
			$message = Yii::t('users/contents','UserPswdUpdateContent'); 
				
			$mailer = Yii::$app->mailer->compose('@common/mail-templates/admin/admin-user-credentials', ['name'=>$name,self::MESSAGE=>$message,self::USERNAME=>$username,'password'=>$password,'loginUrl'=>$loginUrl])
							->setFrom(self::NO_REPLAY_MAIL);
			$mailer->setTo($emails);			 
			$mailer->setSubject($subject)->send();
			return true;
		}
	}
	//Publisher Login Credentials
	public function publisherLoginCredentials($emails,$username, $password, $name) {
		
		$emails = (array) $emails;
		$loginUrl = Yii::$app->urlManagerPublisher->createAbsoluteUrl(['site/index']);
		if(empty($emails)){
			return false;
		}
		$subject = Yii::t('users/contents','createPublisherSubject');
		$message = Yii::t('users/contents','createPublisherContent'); 
			
		$mailer = Yii::$app->mailer->compose('@common/mail-templates/admin/admin-user-credentials', ['name'=>$name,self::MESSAGE=>$message,self::USERNAME=>$username,'password'=>$password,'loginUrl'=>$loginUrl])
						->setFrom(self::NO_REPLAY_MAIL);
		$mailer->setTo($emails);			 
		$mailer->setSubject($subject)->send();
		return true;
	
}
	//Forgot Password 
	public function adminForgotPassword($user) 
	{
		$subject = Yii::t('users/contents','ForgetPasswordSubject');
		$content = Yii::t('users/contents','ForgetPasswordContent');
		 $mail =   Yii::$app
        ->mailer
        ->compose(
            ['html' => '@common/mail-templates/admin/passwordResetToken'],
            ['user' => $user,'content'=>$content]
        )
        ->setFrom(self::NO_REPLAY_MAIL)
        ->setTo($user->email)
        ->setSubject($subject)
        ->send();
        if ($mail) {
        return $user;
        }
        return false;
	}
	//Customer change password by admin
	public function customerLoginCredentials($emails,$username, $password, $name, $type) {

	
		$emails   = (array) $emails;
		
		if(empty($emails)){
			return false;
		}

		if ($type == 'passwordchanged') {
			$subject = Yii::t('users/contents','createCustomerSubject');
			$message = Yii::t('users/contents','createCustomerContent'); 
				
			$mailer  = Yii::$app->mailer->compose('@common/mail-templates/admin/admin-user-credentials', ['name'=>$name,self::MESSAGE=>$message,self::USERNAME=>$username,'password'=>$password])
							->setFrom(self::NO_REPLAY_MAIL);
			$mailer->setTo($emails);			 
			$mailer->setSubject($subject)->send();
			return true;
		} 
	}

	//Send Admin Email Notifications 
	public function sendAdminNotificationEmail($email,$name,$params)
	{		
			$loginUrl = Yii::$app->urlManagerBackend->createAbsoluteUrl(['site/inedx']);
			$subject = (!empty($params['subject'])) ? $params['subject'] : 'Notification';
			$mailer  = Yii::$app->mailer->compose('@common/mail-templates/admin/admin-notifications', ['name'=>$name,'params'=>$params,'loginUrl'=>$loginUrl])
							->setFrom(self::NO_REPLAY_MAIL);
			$mailer->setTo($email);			 
			$mailer->setSubject($subject)->send();
			return true;

	}

	//Send Admin Email Notifications 
	public function sendAdminOrderEmail($email,$name,$params)
	{		
			$loginUrl = Yii::$app->urlManagerBackend->createAbsoluteUrl(['site/inedx']);
			$subject = 'You have a new order '. (isset($params['orderId']) ? "#".$params['orderId']: "");

			$message =  "<p>You have a new order with order id ".(isset($params['orderId']) ? "#".$params['orderId']: "")." has been placed by the customer ".(isset($params['customer']) ? $params['customer']: "")."</p>";
			$emailTitle = 'You have a new order '.(isset($params['customer']) ? "#".$params['orderId']: "");

			$params['content'] = $message;
			$params['emailTitle'] = $emailTitle;

			$mailer  = Yii::$app->mailer->compose('@common/mail-templates/admin/admin-order-mail', ['name'=>$name,'params'=>$params,'loginUrl'=>$loginUrl])
							->setFrom(self::NO_REPLAY_MAIL);
			$mailer->setTo($email);			 
			$mailer->setSubject($subject)->send();
			return true;

	}


	//Send Admin Publisher Email Notifications 
	public function sendPublisherOrderNotificationMail($params)
	{
			$loginUrl = $params['link'];
			$email   = $params['email'];
			$subject = 'You have a new order '. (isset($params['orderId']) ? "#".$params['orderId']: "");

			$message =  "<p>You have a new order with order id ".(isset($params['orderId']) ? "#".$params['orderId']: "")." has been placed by the customer ".(isset($params['customer']) ? "#".$params['customer']: "")."</p>";
			$emailTitle = 'You have a new order '.(isset($params['customer']) ? "#".$params['orderId']: "");

			$params['content'] = $message;
			$params['emailTitle'] = $emailTitle;

			$mailer  = Yii::$app->mailer->compose('@common/mail-templates/admin/publication-order-mail', ['name'=>$params['name'],'params'=>$params,'loginUrl'=>$loginUrl])
							->setFrom(self::NO_REPLAY_MAIL);

			$mailer->setTo($email);			 
			$mailer->setSubject($subject)->send();
			return true;

	}

	//Send Admin Publisher Email Notifications 
	public function sendPublisherNotificationMail($params)
	{
		$loginUrl = $params['link'];
		$email = $params['email'];
		$subject = (!empty($params['title'])) ? $params['title'] : 'Notification';
		$mailer = Yii::$app->mailer->compose('@common/mail-templates/admin/publisher-notifications', ['name'=>$params['name'],'params'=>$params,'loginUrl'=>$loginUrl])
		->setFrom(self::NO_REPLAY_MAIL);
		$mailer->setTo($email); 
		$mailer->setSubject($subject)->send();
		return true;
	}

	//Send Admin Publisher Email Notifications 
	public function sendUserNotificationMail($params)
	{
		
		$email = trim($params['user_email']);
		if(!empty($email)) {
			$subject = "New issue published by " . $params['publisher_name'];
			$mail = Yii::$app->mailer->compose('@common/mail-templates/user/user-issue-notifications', [
				'name'=> $params['user_name'],'params'=>$params, 'fromCron' => 'Y'
				])
				->setFrom(self::NO_REPLAY_MAIL);
			$mail->setTo($email); 

			$mail->setSubject($subject)->send();
			if ($mail) {
				return true;
			}		
		}
        return false;
	}


	// *** User Section ** //
	public function userRegistrationOtp($email,$name,$otp,$status)
	{
		if ($status !='Active') {

			$subject = 'Nasher Publisher App Registration OTP';
			$content = 'We are sharing a verification code to register your account. The code is valid for 10 minutes and usable only once.';
		} else {

			$subject = 'Nasher Publisher App Reset Password OTP';
			$content = 'We are sharing a verification code to reset  your account password. The code is valid for 10 minutes and usable only once.';
		}
		$mail =   Yii::$app
        ->mailer
        ->compose(
            ['html' => '@common/mail-templates/user/registration-otp'],
            ['content'=>$content,'otp'=>$otp,'name'=>$name]
        )
        ->setFrom(self::NO_REPLAY_MAIL)
        ->setTo($email)
        ->setSubject($subject)
        ->send();
        if ($mail) {
        return true;
        }
        return false;
	}

	public function customerOrder($email, $name, $params)
	{
		$subject = 'You have successfully placed the order '.(isset($params['orderId']) ? "#".$params['orderId'] : "");
		$message =  Yii::t('users/contents','userOrderDescription', ['orderId'=> $params['orderId']]);
		$emailTitle =  "Thanks for your order!";

		$params['content'] = $message;
		$params['emailTitle'] = $emailTitle;

		$mail =  Yii::$app->mailer
					->compose(
						['html' => '@common/mail-templates/user/customer-order'],
						['name'=>$name, 'params' => $params]
					)
					->setFrom(self::NO_REPLAY_MAIL)
					->setTo($email)
					->setSubject($subject)
					->send();
        if ($mail) {
        	return true;
        }
        return false;
	}
	
}
