<?php

use yii\db\Migration;

/**
 * Class m200714_185410_book
 */
class m200714_185410_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200714_185410_book cannot be reverted.\n";

        return false;
    }
    
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
		$this->createTable('{{%book}}', [
			'id' => $this->primaryKey(),
			'slug' => $this->string()->notNull()->unique(),
			'title' => $this->string()->notNull(),
			'publishing' => $this->string()->notNull(),
			'status' => $this->integer()->notNull()->defaultValue(10),
			'created_at' => $this->integer()->notNull(),
			'updated_at' => $this->integer()->notNull(),
		], $tableOptions);
	}
	
	public function down()
	{
		$this->dropTable('{{%book}}');
	}
}
