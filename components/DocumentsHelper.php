<?php
namespace app\components;

use app\models\Documents;

class DocumentsHelper
{
    /**
     * Saves data for document
     * @param $request
     * @return int
     */
    public static function processSaveDocument($request) {

        $keys            = $request['key'];
        $values          = $request['value'];

        foreach (array_combine($keys,  $values)  as $key => $value) {
            $checkKey   = !empty($key) ? trim(substr($key, 0, 100)) : '';
            $checkValue = !empty($value) ? trim(substr($value, 0, 100)) : '';
        }
        $jsonKeyValue = json_encode(array_combine($keys, $values) );

        $document             = new Documents;
        $document->name       = $request['Documents']['name'];
        $document->key_values = $jsonKeyValue;
        $document->created    = DocumentsHelper::createTimeStamp();
        $document->save();

        return $document->id;
    }

    /**
     * Return a timestamp
     * @return false|string
     */
    private static function createTimeStamp(){

        return date("Y-m-d H:i:s");
    }
}