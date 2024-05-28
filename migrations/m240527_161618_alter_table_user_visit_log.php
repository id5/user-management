<?php

use yii\db\Migration;

class m240527_161618_alter_table_user_visit_log extends Migration
{
    
    public function safeUp()
    {
        $this->alterColumn('{{%user_visit_log}}', 'ip', 'VARCHAR(40) NULL');
    }

    public function safeDown()
    {
    }
    
}