<?php
namespace app\controllers;

use app\components\DocumentsHelper;
use app\models\Documents;
use app\models\Search;
use Yii;
use yii\data\ActiveDataProvider;
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

        // Process key values
        $tempKeyValues = $request['key_values'];
        $tempKeyValuesArray  = explode(',',  $tempKeyValues);
        foreach($tempKeyValuesArray as $k=>$v){
            $tempKeyValuesArray[$k] = explode(':', $v);
        }

        $tempKeyValuesArraySingle = call_user_func_array('array_merge', $tempKeyValuesArray);

        $request['key'] = array_filter($tempKeyValuesArraySingle, function($k){
            return ($k % 2 == 0);
        }, ARRAY_FILTER_USE_KEY);

        $request['value'] = array_filter($tempKeyValuesArraySingle, function($k){
            return ($k % 2 == 1);
        }, ARRAY_FILTER_USE_KEY);

        $request['Documents']['name'] = $request['name'];

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

        $request = Yii::$app->request->post();

        // Retrieve specified document.
        if (isset($request) && isset($request['id']) && is_numeric($request['id']) ){
            $id    = $request['id'];
            $model = Documents::findOne($id);

            if (!empty($model))
            {
                return($model);
            }else {
                return [
                    'status' => false ,
                    'message'=> 'Document not found.'
                ];
            }

        }
        // Retrieve all documents.
        $searchModel = new Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return($dataProvider);
    }

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





}
