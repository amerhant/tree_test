<?php

use yii\db\Migration;

/**
 * Class m200714_142914_insert_tree
 */
class m200714_142914_insert_tree extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            INSERT INTO `tree` (`parent_id`, `position`, `path`, `level`) VALUES ('0', '0', '1', '1');  
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("
            DELETE FROM `tree` WHERE `id` = '1'; 
        ");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200714_142914_insert_tree cannot be reverted.\n";

        return false;
    }
    */
}
