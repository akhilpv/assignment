<?php

use yii\db\Migration;

class m200218_051258_002_create_table_admin_users extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admin_users}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(150)->notNull(),
            'password' => $this->string(150)->notNull(),
            'role_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'mobile' => $this->string(16)->notNull(),
            'reset_otp' => $this->string(10),
            'reset_otp_token' => $this->string(150),
            'reset_otp_expired_on' => $this->dateTime(),
            'created_on' => $this->dateTime()->notNull(),
            'created_ip' => $this->string(50)->notNull(),
            'created_by' => $this->integer()->notNull(),
            'modified_on' => $this->dateTime()->notNull(),
            'modified_ip' => $this->string(50)->notNull(),
            'modified_by' => $this->integer()->notNull(),
            'status' => $this->string()->notNull(),
        ], $tableOptions);
        $this->alterColumn('{{%admin_users}}', 'status', "ENUM('Active','Inactive')");

        $this->createIndex('username', '{{%admin_users}}', 'email', true);

        $this->insert('{{%admin_users}}',array(
            'password' => '$2y$13$xvtMbOd/Royr8V2xAZaqTOxwFXreRz6J7uxUNZu2sEF9EezNUyJDq',
            'name' => 'Super Admin',
            'email' => 'superadmin@yopmail.com',
            'role_id' => 1,
            'mobile' => '9876543210',
            'created_on' => '2019-05-02 00:00:00',
            'created_ip' => '127.0.0.1',
            'created_by'=>0,
            'modified_by'=>0,
            'modified_on' => '2019-05-02 00:00:00',
            'modified_ip' => '127.0.0.1',
            'status' => 'Active',
        ));
    }

    public function down()
    {
        $this->dropTable('{{%admin_users}}');
    }
}
