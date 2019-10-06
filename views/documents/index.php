<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Documents', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'key_values',
            //'created',
            //'updated',
            //'exported',
            //'url:url',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}&nbsp{update}&nbsp{delete}',   //{view}&nbsp;
                'buttons' => [
                    'view' => function($url, $model)   {
                        return Html::a('<button class="btn btn-success">View &nbsp;<i class="glyphicon glyphicon-eye-open"></i></button>',$url);
                    },
                    'update' => function($url, $model) {
                        return Html::a('<button class="btn btn-primary">Update &nbsp;<i class="glyphicon glyphicon-pencil"></i></button>',$url);
                    },
                    'delete' => function($url, $model) {
                        return Html::a('<button class="btn btn-danger">Delete &nbsp;<i class="glyphicon glyphicon-trash"></i></button>', $url,
                            ['data-confirm' => 'Are you sure you want to delete this item?', 'data-method' =>'POST']
                        );
                    },
                    'urlCreator' => function($action, $model, $key, $index) {
                        if ($action == 'view') {
                            return Html::a('Action');
                        }
                        if ($action == 'update') {
                            return Html::a('Action');
                        }
                        if ($action == 'delete') {
                            return Html::a('Action');
                        }
                    }
                ],
            ],  // fin ActionColumn
        ],
    ]); ?>


</div>
