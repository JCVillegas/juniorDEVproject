<?php
namespace app\controllers;

use app\components\DocumentsHelper;
use app\models\Documents;
use app\models\Search;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\rest\ActiveController;

class DocController extends ActiveController

{
    public $modelClass = 'app\models\Documents';

    /**
     * POST - Creates a document
     * @return array|mixed
     */
    public function actionCreates()

    {
        $request = Yii::$app->request->post();
        $check   = $this->validateFields($request);

        if ($check !== true){
            return $check;
        }

        $request['Documents']['name'] = $request['name'];

        list($request['key'], $request['value']) = $this->processKeyValues($request['key_values']);

        DocumentsHelper::processSaveDocument($request);

        return [
            'status' => true,
            'message'=> 'Document successfully created.'
        ];
    }

    /**
     * GET - Gets all documents or by id.
     *
     * @return Documents|array|ActiveDataProvider|null
     */
    public function actionReads(){

        $request = Yii::$app->request->get();

        // Retrieve specified document.
        if (isset($request) && isset($request['id']) && is_numeric($request['id'])){
            $id    = $request['id'];
            $model = Documents::findOne($id);

            if (!empty($model))
            {
                return($model);
            }else {
                return [
                    'status' => false ,
                    'message'=> 'Document doesnt exist.'
                ];
            }

        }
        // Retrieve all documents.
        $searchModel = new Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return($dataProvider);
    }

    /**
     * DELETE - Deletes document by id
     *
     * @return array
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDeletes()
    {

        $request = Yii::$app->request->post();

        // Check if id was given specified document.
        if (isset($request) && isset($request['id']) && is_numeric($request['id'])) {
            $id = $request['id'];
            $model =   Documents::findOne($id);

            if (empty($model))
            {
                return [
                    'status' => false ,
                    'message'=> 'Document doesnt exist.'
                ];
            }

            $model->delete();

            if (!empty($model))
            {
                return [
                'status' => true ,
                'message'=> 'Document deleted successfully.'
            ];

            }else {
                return [
                    'status' => false ,
                    'message'=> 'Document not found.'
                ];
            }

        }else{

            return [
                'status' => false ,
                'message'=> 'A valid is is needed.'
            ];
        }
    }

    /**
     *  POST - Update documents by given id.
     *
     * @return Documents|array|null
     */
    public function actionUpdates(){

        $request = Yii::$app->request->post();

        $check = $this->validateFields( $request['name'], $request['key_values'], $request['id']);

        if ($check !== true){
            return $check;
        }

        list($request['key'], $request['value']) = $this->processKeyValues($request['key_values']);
        $jsonKeyValue = json_encode(array_combine($request['key'], $request['value']) );

        $document =   Documents::findOne($request['id']);

        if (empty($document))
        {
            return [
                'status' => false ,
                'message'=> 'Document with provided id doesnt exist.'
            ];
        }

        $document->name       = $request['name'];
        $document->key_values = $jsonKeyValue;
        $document->updated    = DocumentsHelper::createTimeStamp();
        $document->save();

        return [
            'status' => true,
            'message'=> 'Document successfully updated.'
        ];

    }



private function processKeyValues($tempKeyValues){

    $tempKeyValuesArray  = explode(',',  $tempKeyValues);
    foreach($tempKeyValuesArray as $k=>$v){
        $tempKeyValuesArray[$k] = explode(':', $v);
    }

    $tempKeyValuesArraySingle = call_user_func_array('array_merge', $tempKeyValuesArray);

    $key = array_filter($tempKeyValuesArraySingle, function($k){
        return ($k % 2 == 0);
    }, ARRAY_FILTER_USE_KEY);

    $value = array_filter($tempKeyValuesArraySingle, function($k){
        return ($k % 2 == 1);
    }, ARRAY_FILTER_USE_KEY);

    return array($key, $value);
    }

    private function validateFields ($request)
    {
        /*// Check for id.
        if (empty($id) || !is_numeric($id)) {
            return [
                'status' => false,
                'message'=> 'A valid ID is needed.'
            ];
        }*/

        // Check for name.
        if (empty($request['name'])) {
            return [
                'status' => false,
                'message'=> 'A name for the document is needed.'
            ];
        }

        // Check for keyValues.
        if (empty($keyValues)) {
            return [
                'status' => false,
                'message'=> 'Key values are needed.'
            ];
        }

        return true;
    }
}
