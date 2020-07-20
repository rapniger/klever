<?php

use yii\db\Migration;

class m200715_101700_session extends Migration
{
    public function safeUp()
    {

    }
    
    public function safeDown()
    {
        echo "m200715_101700_session cannot be reverted.\n";

        return false;
    }
    
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
		$this->createTable('{{%session}}', [
			'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
			'expire' => 'INTEGER',
			'data' => 'BLOB',
		], $tableOptions);
	}
	
	public function down()
	{
		$this->dropTable('{{%session}}');
	}
}
