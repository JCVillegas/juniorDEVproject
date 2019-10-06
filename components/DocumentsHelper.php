<?php
namespace app\components;

use app\models\Documents;

class DocumentsHelper
{

    /**
     * Generates and downloads a CSV file.
     *
     * @param Documents $document
     */
    public static function generateCSVFile(Documents $document){

        $filename = $document->name;

        $document->exported = DocumentsHelper::createTimeStamp();

        $data = [];
        $data[0]   = array('CREATION DATE', 'LAST UPDATE');
        $data[1]   = array($document->created, is_null($document->updated)?'NOT UPDATED YET':$document->updated);
        $data[2]   = array('', '');
        $data[3]   = array('KEY', 'VALUE');

        $keyValues = json_decode($document->key_values, true);
        foreach ($keyValues as $key=>$value)
        {
            array_push($data, array($key, $value));
        }
        $fp = fopen('php://output', 'w');
        foreach ( $data as $line ) {
            fputcsv($fp, $line, ',');
        }
        fclose($fp);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename='.$filename.'.csv');
        $document->save();
    }

    /**
     * Saves document data
     *
     * @param array $request
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
     * Updates document
     *
     * @param Documents $document
     * @return int
     */
    public static function processUpdateDocument(Documents $document) {

        $document->updated  = DocumentsHelper::createTimeStamp();
        $document->save();

        return $document->id;
    }

    /**
     * Returns a timestamp
     *
     * @return false|string
     */
    private static function createTimeStamp(){

        return date("Y-m-d H:i:s");
    }
}