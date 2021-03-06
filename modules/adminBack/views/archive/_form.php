<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Archive */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="archive-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'service_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Service::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(\dektrium\user\models\User::find()->all(), 'id', 'username')) ?>

    <div class="row mb align-center">
        <div class="col-sm-6">
            <?= $form->field($model, 'photo')->fileInput(['multiple' => 'multiple', 'id' => 'sortpicture']) ?>
            <div class="hidden">
                <?= $form->field($model, 'photo')->textInput(['id' => 'photo_img', 'type' => 'hidden']) ?>
            </div>
            <button class="btn btn-primary img-btn" id="upload">Загрузить изображение</button>
        </div>
        <div class="col-sm-6 block-image">
            <?php if (!empty($model->photo)): ?>
                <?php $path = Yii::getAlias('/img/admin/') . $model->photo; ?>
                <img src="<?= $path; ?>" alt="image" width="300">
            <?php endif; ?>
        </div>
    </div>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$image_js = <<<JS
var type = 'category';
$('.img-btn').on('click', function(event) {
    event.stopPropagation(); // Остановка происходящего
    event.preventDefault();  // Полная остановка происходящего
    var file_data = $('#sortpicture').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
          url: '/upload/upload',
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'post',
          success: function(php_script_response){
              var response = JSON.parse(php_script_response);
              alert(response.message);
              var photo = response.path;
              $('#photo_img').val(photo);
              $('.block-image img').attr("src",'/img/admin/'+response.path);
          }
     });
});
JS;
$this->registerJs($image_js);
?>
