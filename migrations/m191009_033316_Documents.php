<?php

use yii\db\Migration;

/**
 * Class m191009_033316_Documents
 */
class m191009_033316_Documents extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('documents', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(255)->notNull(),
            'key_values' => $this->json()->notNull(),
            'created'    => $this->timestamp()->null(),
            'updated'    => $this->timestamp()->null(),
            'exported'   => $this->timestamp()->null(),
            'url'        => $this->string(255)->null(),
        ]);

    }

    public function down()
    {
        echo "m191009_033316_Documents cannot be reverted.\n";

        return false;
    }

}
