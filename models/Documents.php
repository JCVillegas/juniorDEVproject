<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property string $name
 * @property array $key_values
 * @property string $created
 * @property string $updated
 * @property string $exported
 * @property string $url
 */
class Documents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'key_values'], 'required'],
            [['key_values', 'created', 'updated', 'exported'], 'safe'],
            [['name', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'key_values' => 'Key Values',
            'created' => 'Created',
            'updated' => 'Updated',
            'exported' => 'Exported',
            'url' => 'Url',
        ];
    }
}
