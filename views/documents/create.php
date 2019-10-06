<?php

use app\models\Documents;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Documents */

$this->title = 'Create Document';
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="documents-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <script src='https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js'></script>
        <script>
            $(document).ready(function() {
                let i = 1;
                $('#add').click(function() {
                    i++;
                    $('#dynamic_field').append('' +
                        '<tr id = "row'+i+'"> ' +
                        '<td>' +
                        '<label class="control-label">Key&nbsp; </label>' +
                        '<input type=\'text\' name=\'key[]\'   required="true"> ' +
                        '</td>' +
                        '<td>' +
                        '<label class="control-label">Value&nbsp; </label>' +
                        '<input type=\'text\' name=\'value[]\' required="true">' +
                        '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button>' +
                        '</td>' +
                        '</tr>'+
                        '');
                    $("#keyValueCounter").val(i);
                });
                $(document).on('click', '.btn_remove', function(){
                    let buttonId = $(this).attr("id");
                    i--;
                    $('#row' + buttonId +'').remove();
                    $("#keyValueCounter").val(i);
                });
            });

        </script>
        <div class="form-group field-documents-key_values required">

            <table id='dynamic_field'>
                <tr>
                    <td> <label  class="control-label" for="documents-created">Key  </label> <input type='text' name='key[]'   required="true"> </td>
                    <td> <label  class="control-label" for="documents-created">Value</label> <input type='text' name='value[]' required="true"> </td>
                    <td> <button type='button' name='add' class="btn btn-success" id='add'>Add More</button>
                </tr>
            </table>
        </div>
        <input type='hidden' id="keyValueCounter" name="keyValueCounter">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>



