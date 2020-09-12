<?php
namespace common\components;

use Yii;
use common\models\AdminUsers;
use common\models\AdminRolePermissions;
class Permissions {

	public function isAllowed($controller,$action)
	{
		if (!$this->isActionAllowed(Yii::$app->user->getId(), $controller, $action)) {
			return Yii::$app->getResponse()->redirect(['site/unautherized']);
		 }
	}
	
	 //check if is action is allowed for the user
	public function isActionAllowed($userId, $controller, $action){
		$controller = trim($controller);
		
		$uActions = $this->adminPermitions();

		if(empty($uActions) && empty($uActions[$controller]) && !in_array($action,$uActions[$controller])){	
			return false;
		}
		
		
		$user = AdminUsers::find()->with(['role'=>function ($query) {
											$query->andWhere(['status' => 'Active']);
										}])
										->where(["id" => $userId])->one();
		$permissions = Yii::$app->session[$userId.'_permissions'];		
		if(!empty($user) && !empty($user->role)){
			if(trim($user->role->role_name) == "Super Admin"){
				return true;
			}else if(!empty($permissions)){
				return $this->validatePermission($permissions,$controller, $action);
			}else{
				$permissions = AdminRolePermissions::find()->where(["role_id" => $user->role->id])->one();	
				if(!empty($permissions)){
					$perVal = json_decode($permissions->permissions,true);
					Yii::$app->session[$userId.'_permissions'] = $perVal;
					return $this->validatePermission($perVal,$controller, $action);
				}else{
					
					return false;
				}
			}
		}else{
			
			return false;
		}
	}
	// check role has permission
	public function validatePermission($permissions,$controller, $action){
		return (isset($permissions[$controller]) && !empty($permissions[$controller]) && in_array($action,$permissions[$controller]));
	
	}

	//Permissions
	public function adminPermitions(){

		
		return [
			'Manage User Roles'        => ['view','add','edit','delete'],
			'Manage Users'             => ['view','add','edit','delete'], 
        ];
	}
	
	
}
