<?php

use yii\db\Migration;

class m190809_112647_create_table_admin_roles extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admin_roles}}', [
            'id' => $this->primaryKey(),
            'role_name' => $this->string()->notNull(),
            'created_on' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'created_ip' => $this->string()->notNull(),
            'modified_on' => $this->dateTime()->notNull(),
            'modified_by' => $this->integer()->notNull(),
            'modified_ip' => $this->string()->notNull(),
            'status' => $this->string()->notNull(),
        ], $tableOptions);

        $this->insert('{{%admin_roles}}',array(
            'role_name' => 'Super Admin',
            'created_on' => '2019-08-08 16:15:06',
            'created_by' => 0,
            'created_ip' => '127.0.0.1',
            'modified_on' => '2019-08-08 16:15:06',
            'modified_by' => 1,
            'modified_ip' => '127.0.0.1',
            'status' => 'Active',
       ));

    }

    public function down()
    {
        $this->dropTable('{{%admin_roles}}');
    }
}
