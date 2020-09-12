<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_role_permissions".
 *
 * @property int $id
 * @property int $role_id
 * @property string $permissions
 * @property string $created_on
 * @property int $created_by
 * @property string $created_ip
 * @property string $modified_on
 * @property int $modified_by
 * @property string $modified_ip
 * @property string $status
 *
 * @property AdminRoles $role
 */
class AdminRolePermissions extends \yii\db\ActiveRecord
{
    const ROLE_ID = 'role_id';
    const PERMISSIONS = 'permissions';
    const CREATED_ON = 'created_on';
    const CREATED_BY = 'created_by';
    const CREATED_IP = 'created_ip';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_role_permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[self::ROLE_ID, self::PERMISSIONS, self::CREATED_ON, self::CREATED_BY, self::CREATED_IP], 'required'],
            [[self::ROLE_ID, self::CREATED_BY, 'modified_by'], 'integer'],
            [[self::PERMISSIONS, 'status'], 'string'],
            [[self::CREATED_ON, 'modified_on'], 'safe'],
            [[self::CREATED_IP, 'modified_ip'], 'string', 'max' => 20],
            [[self::ROLE_ID], 'exist', 'skipOnError' => true, 'targetClass' => AdminRoles::className(), 'targetAttribute' => [self::ROLE_ID => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            self::ROLE_ID => 'Role ID',
            self::PERMISSIONS => 'Permissions',
            self::CREATED_ON => 'Created On',
            self::CREATED_BY => 'Created By',
            self::CREATED_IP => 'Created Ip',
            'modified_on' => 'Modified On',
            'modified_by' => 'Modified By',
            'modified_ip' => 'Modified Ip',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(AdminRoles::className(), ['id' => self::ROLE_ID]);
    }
    /**
     * Update Role Permissions
     */
    public function updateRolePermissions()
    {
        $this->save();
        return $this;
    }
}
