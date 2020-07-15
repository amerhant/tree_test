<?php

use yii\db\Migration;

/**
 * Class m200714_134512_create_tree
 */
class m200714_134512_create_tree extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE `tree`(  
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `parent_id` INT(11),
                `position` INT(11),
                `path` VARCHAR(12288),
                `level` INT(11),
                PRIMARY KEY (`id`)
            ); 
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("
            DROP TABLE `tree`;  
        ");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200714_134512_create_tree cannot be reverted.\n";

        return false;
    }
    */
}
