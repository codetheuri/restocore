<?php

use yii\db\Migration;

class m260316_060306_add_address_to_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%profiles}}', 'physical_address', $this->text()->after('mobile_number'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%profiles}}', 'physical_address');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260316_060306_add_address_to_profiles_table cannot be reverted.\n";

        return false;
    }
    */
}
