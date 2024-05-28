<?php

use yii\db\Migration;

class m240527_161618_alter_table_user extends Migration
{
    
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'registration_ip', 'VARCHAR(40) NULL');
    }

    public function safeDown()
    {
    }
    
}