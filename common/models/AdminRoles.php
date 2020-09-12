<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_roles".
 *
 * @property int $id
 * @property string $role_name
 * @property string $created_on
 * @property int $created_by
 * @property string $created_ip
 * @property string $modified_on
 * @property int $modified_by
 * @property string $modified_ip
 * @property string $status
 *
 * @property AdminRolePermissions[] $adminRolePermissions
 * @property AdminUsers[] $adminUsers
 */

class AdminRoles extends \yii\db\ActiveRecord
{
    const ROLE_NAME = 'role_name';
    const CREATED_ON = 'created_on';
    const CREATED_BY = 'created_by';
    const CREATED_IP = 'created_ip';
    const MODIFIED_ON = 'modified_on';
    const MODIFIED_BY = 'modified_by';
    const MODIFIED_IP = 'modified_ip';
    const STATUS      = 'status';
    const STRING_NAME = 'string'; 
    public $dateTime = 'Y-m-d H:s:i';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[self::ROLE_NAME, self::CREATED_ON, self::CREATED_BY, self::CREATED_IP, self::MODIFIED_ON, self::MODIFIED_BY, self::MODIFIED_IP, self::STATUS], 'required'],
            [[self::CREATED_ON, self::MODIFIED_ON], 'safe'],
            [[self::CREATED_BY, self::MODIFIED_BY], 'integer'],
            [self::ROLE_NAME,'match','pattern'=>'/^[a-zA-Z-_\s]*$/i', 'message' => 'Invalid characters in Role Name.'],
            [[self::STATUS], self::STRING_NAME],
            [self::ROLE_NAME,'unique'],
            [[self::ROLE_NAME],'filter','filter' => 'trim'],
            [[self::ROLE_NAME], self::STRING_NAME, 'max' => 30],
            [[self::CREATED_IP, self::MODIFIED_IP], self::STRING_NAME, 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            self::ROLE_NAME => 'Role Name',
            self::CREATED_ON => 'Created On',
            self::CREATED_BY => 'Created By',
            self::CREATED_IP => 'Created Ip',
            self::MODIFIED_ON => 'Modified On',
            self::MODIFIED_BY => 'Modified By',
            self::MODIFIED_IP => 'Modified Ip',
            self::STATUS => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminRolePermissions()
    {
        return $this->hasMany(AdminRolePermissions::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminUsers()
    {
        return $this->hasMany(AdminUsers::className(), ['role_id' => 'id']);
    }
    /**
     * Get Admin Roles
     */
    public static function getRolesHideList($hideList)
    {
       return  AdminRoles::find()->where(['not in',self::ROLE_NAME,$hideList])
                              ->andWhere([self::STATUS=>'Active'])     
                              ->orderBy("id DESC")->all();

    }

    /**
     * Save  Role
     */
    public function saveRole()
    {
       if (!$this->validate()) {
           return false;
       }
         $this->save();
         return $this;
    }
}
