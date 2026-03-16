<?php

use yii\db\Migration;

class m260315_080000_jwt_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        if ($this->db->getTableSchema('{{%jwt_blacklist}}') === null) {
            $this->createTable('{{%jwt_blacklist}}', [
                'id' => $this->primaryKey(),
                'jti' => $this->string(64)->notNull()->unique(),
                'expires_at' => $this->integer()->notNull(),
                'created_at' => $this->integer()->notNull(),
            ], $tableOptions);
        }

        if ($this->db->getTableSchema('{{%jwt_refresh_tokens}}') === null) {
            $this->createTable('{{%jwt_refresh_tokens}}', [
                'id' => $this->primaryKey(),
                'user_id' => $this->bigInteger()->notNull(),
                'token' => $this->string(255)->notNull()->unique(),
                'jti' => $this->string(64)->notNull(),
                'expires_at' => $this->integer()->notNull(),
                'ip_address' => $this->string(45),
                'user_agent' => $this->string(255),
                'is_revoked' => $this->boolean()->defaultValue(false),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);
        }
    }

    public function down()
    {
        $this->dropTable('{{%jwt_refresh_tokens}}');
        $this->dropTable('{{%jwt_blacklist}}');
    }
}
