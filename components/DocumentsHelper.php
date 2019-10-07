<?php
namespace app\components;

use app\models\Documents;
use Yii;
use yii\helpers\FileHelper;

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
     * Saves document data to DB.
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
     * Updates document data and saves to DB.
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
     * Updates Documents data with dropbox url.
     *
     * @param Documents $document
     * @return int
     * @throws \Exception
     */
    public static function processUploadDocument(Documents $document) {

        $documentName = DocumentsHelper::uploadExportFile($document);
        $publicUrl    = DocumentsHelper::getDropBoxUrl($documentName);

        $document->updated  = DocumentsHelper::createTimeStamp();
        $document->url      = $publicUrl;
        $document->save();

        return $document->id;
    }

    /**
     * Uploads CSV file to dropbox.
     *
     * @param Documents $documentData
     * @return mixed
     * @throws \yii\base\Exception
     */
    private static function uploadExportFile($documentData)
    {
        $filename = $documentData['name'];
        $data[0]   = array('CREATION DATE', 'LAST UPDATE');
        $data[1]   = array($documentData['created'], $documentData['exported']);
        $data[2]   = array('', '');
        $data[3]   = array('KEY', 'VALUE');
        $keyValues = json_decode($documentData['key_values'], true);
        foreach ($keyValues as $key=>$value)
        {
            array_push($data, array($key, $value));
        }
        FileHelper::createDirectory('tmp/', $mode = 0775, $recursive = true);
        $file = 'tmp/' . $filename .'.csv';
        $fp = fopen( $file, 'w');
        foreach ( $data as $line ) {
            fputcsv($fp, $line, ',');
        }
        fclose($fp);
        $api_url = 'https://content.dropboxapi.com/2/files/upload';
        $token   = Yii::$app->params['dropboxToken'];
        $headers = array('Authorization: Bearer '. $token,
            'Content-Type: application/octet-stream',
            'Dropbox-API-Arg: '.
            json_encode(
                array(
                    "path"=> '/'. basename($file),
                    "mode" => "add",
                    "autorename" => true,
                    "mute" => false
                )
            )
        );
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        $fp       = fopen($file, 'rb');
        $filesize = filesize($file);
        curl_setopt($ch, CURLOPT_POSTFIELDS, fread($fp, $filesize));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code != '200') {
            throw new \Exception('There was a problem uploading the file to Dropbox.');
        }
        $documentName = $response['name'];
        unlink(Yii::$app->basePath . '/web/' . $file);

        return $documentName;
    }

    /**
     * Gets dropbox public url for uploaded CSV file.
     *
     * @param string $documentName
     * @return mixed
     * @throws \Exception
     */
    private static function getDropboxUrl($documentName){

        $api_url = 'https://api.dropboxapi.com/2/sharing/create_shared_link_with_settings';

        $headers = array('Authorization: Bearer '. Yii::$app->params['dropboxToken'],
            'Content-Type: application/json',
        );
        $data =
            json_encode(
                array(
                    "path"=> '/'. $documentName
                )
            );
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response  = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        if ($http_code != '200') {
            throw new \Exception('There was a problem uploading the file to Dropbox.');
        }
        return $response['url'];

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