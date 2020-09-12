<?php

use yii\db\Migration;

class m190809_112647_create_table_admin_role_permissions extends Migration
{
    public function up()
    {
        $this->execute("SET foreign_key_checks = 0;");
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admin_role_permissions}}', [
            'id' => $this->primaryKey(),
            'role_id' => $this->integer()->notNull(),
            'permissions' => $this->text()->notNull(),
            'created_on' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'created_ip' => $this->string()->notNull(),
            'modified_on' => $this->dateTime(),
            'modified_by' => $this->integer(),
            'modified_ip' => $this->string(),
            'status' => $this->string()->notNull()->defaultValue('Active'),
        ], $tableOptions);
        $this->createIndex('role_id', '{{%admin_role_permissions}}', 'role_id');
        $this->addForeignKey('admin_role_permissions_ibfk_1', '{{%admin_role_permissions}}', 'role_id', '{{%admin_roles}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->execute("SET foreign_key_checks = 1;");

    }

    public function down()
    {
        $this->dropTable('{{%admin_role_permissions}}');
    }
}
