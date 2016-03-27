<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\color\ColorInput;
use yii\helpers\Url;

$this->title = 'Create';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
	<div class="row">
		<div class="col-lg-4">	
		    <?php $form = ActiveForm::begin([
		        'id' => 'imageForm',
		        'options' => ['class' => 'form-horizontal']
		    ]); ?>
		
		        <?= $form->field($model, 'text')->textarea() ?>
		
		        <?= $form->field($model, 'font_size')->textInput() ?>
				
				<?= $form->field($model, 'font_color')->widget(ColorInput::classname(), [
				    'options' => ['placeholder' => 'Select color ...'],
				]);?>
				
				<?= $form->field($model, 'outline_color')->widget(ColorInput::classname(), [
				    'options' => ['placeholder' => 'Select color ...'],
				]);?>
				
				<?= $form->field($model, 'font_name')->dropDownList($model->fonts())?>
				
		        <div class="form-group">
		            <div class="col-lg-offset-1 col-lg-5">
		                <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
		            </div>
		            <div class="col-lg-offset-1 col-lg-5">
		                <?= Html::button('Preview', ['class' => 'btn btn-primary', 'name' => 'preview-button', 'id' => 'previewButton']) ?>
		            </div>
		        </div>
		
		    <?php ActiveForm::end(); ?>
		</div>	
	
		<div class="col-lg-8">
			<div id="image-display"></div>
		</div>
	</div>
</div>
<?php 
$url_to = Url::to(['/imagane/save']);
$image_url = Html::img(['/imagane/show']);
$js = <<<EOF
$("#previewButton").click(function(e) {
	$.ajax({
    	type: "POST",
        url: '{$url_to}',
        data: $("#imageForm").serialize(), // serializes the form's elements.
           success: function(response)
           {
				if(response == 'sucess'){
               		$("#image-display").html('{$image_url}');
				}
           }
    });
});
$("#imagine-font_name").change(function(e) {
	$.ajax({
    	type: "POST",
        url: '{$url_to}',
        data: $("#imageForm").serialize(), // serializes the form's elements.
           success: function(response)
           {
				if(response == 'sucess'){
               		$("#image-display").html('{$image_url}');
				}
           }
    });
});
EOF;

$this->registerJs($js);
?>
