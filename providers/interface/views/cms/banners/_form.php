<?php

use helpers\Html;
use helpers\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var dashboard\models\Banners $model */
/** @var helpers\widgets\ActiveForm $form */

// Setup Preview URL
$hasImage = !empty($model->image_link);
$previewUrl = $hasImage ? Yii::getAlias('@web/') . $model->image_link : '';
?>

<?php Pjax::begin(['id' => 'banner-pjax-container']); ?>

<div class="banners-form">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true],
        // 1. FORCE VERTICAL LAYOUT (Fixes the "Big Sidebar" issue)
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}", 
            'labelOptions' => ['class' => 'form-label fw-bold'], 
            'inputOptions' => ['class' => 'form-control'],
        ],
    ]); ?>

    <div class="block-content">
        <div class="row">
            <div class="col-md-12 mb-3">
                <?= $form->field($model, 'title')->textInput([
                    'maxlength' => true, 
                    'placeholder' => 'Enter banner title',
                    'class' => 'form-control form-control-lg' // Make it slightly bigger
                ]) ?>
            </div>

            <div class="col-md-12 mb-3">
                <?= $form->field($model, 'content')->textarea([
                    'rows' => 3,
                    'placeholder' => 'Enter a short description...'
                ]) ?>
            </div>

            <div class="col-md-12 mb-4">
                <label class="form-label fw-bold">Banner Image</label>
                
                <div class="p-3 border border-2 border-dashed rounded bg-body-light position-relative text-center" 
                     style="min-height: 200px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    
                    <div id="image-preview-wrapper" class="mb-3 position-relative" 
                         style="display: <?= $hasImage ? 'block' : 'none' ?>;">
                        
                        <img id="image-preview" src="<?= $previewUrl ?>" 
                             alt="Banner Preview" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 180px; width: auto; object-fit: cover;">

                        <button type="button" id="btn-remove-image" 
                                class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 translate-middle"
                                style="width: 30px; height: 30px; z-index: 10; padding: 0; line-height: 28px;"
                                title="Remove Image">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>

                    <div id="upload-controls" style="width: 100%; max-width: 400px;">
                        <?= $form->field($model, 'imageFile', ['template' => "{input}\n{error}"])->fileInput([
                            'id' => 'banner-image-input',
                            'class' => 'form-control',
                            'accept' => 'image/*'
                        ]) ?>
                        <div class="form-text text-muted small mt-1">
                            Recommended size: 1920x600px (Max 5MB)
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold d-block">Status</label>
                <div class="btn-group w-100" role="group">
                    <?php
                        $status = $model->isNewRecord ? 1 : $model->status; // Default to Active
                    ?>
                    
                    <input type="radio" class="btn-check" name="Banners[status]" id="status-active" value="1" <?= $status == 1 ? 'checked' : '' ?>>
                    <label class="btn btn-outline-success" for="status-active">
                        <i class="fa fa-check me-1"></i> Active
                    </label>

                    <input type="radio" class="btn-check" name="Banners[status]" id="status-inactive" value="0" <?= $status == 0 ? 'checked' : '' ?>>
                    <label class="btn btn-outline-danger" for="status-inactive">
                        <i class="fa fa-ban me-1"></i> Inactive
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="block-content block-content-full bg-body-light text-end p-3 rounded-bottom">
        <button type="button" class="btn btn-alt-secondary me-2" data-bs-dismiss="modal">
            Cancel
        </button>
        
        <?= Html::submitButton($model->isNewRecord ? 'Create Banner' : 'Save Changes', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php Pjax::end(); ?>

<?php
// REGISTER JS FOR IMAGE PREVIEW
$script = <<< JS
    // 1. Image Preview Logic
    document.getElementById('banner-image-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewWrapper = document.getElementById('image-preview-wrapper');
        const previewImg = document.getElementById('image-preview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewWrapper.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // 2. Remove Image Logic
    document.getElementById('btn-remove-image').addEventListener('click', function() {
        const input = document.getElementById('banner-image-input');
        const previewWrapper = document.getElementById('image-preview-wrapper');
        const previewImg = document.getElementById('image-preview');
        
        // Reset Input
        input.value = ''; 
        
        // Hide Preview
        previewImg.src = '';
        previewWrapper.style.display = 'none';
    });
JS;
$this->registerJs($script);
?>