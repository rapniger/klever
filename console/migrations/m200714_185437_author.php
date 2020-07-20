<?php

use yii\db\Migration;

/**
 * Class m200714_185437_author
 */
class m200714_185437_author extends Migration
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
        echo "m200714_185437_author cannot be reverted.\n";

        return false;
    }
	
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
		$this->createTable('{{%author}}', [
			'id' => $this->primaryKey(),
			'id_book' => $this->string()->notNull(),
			'slug' => $this->string()->notNull()->unique(),
			'name' => $this->string()->notNull(),
			'subname' => $this->string()->notNull(),
			'status' => $this->integer()->notNull()->defaultValue(10),
			'created_at' => $this->integer()->notNull(),
			'updated_at' => $this->integer()->notNull(),
		], $tableOptions);
	}
	
	public function down()
	{
		$this->dropTable('{{%author}}');
	}
}
