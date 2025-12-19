<?php

use helpers\Html;
use helpers\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var dashboard\models\Blogs $model */
/** @var helpers\widgets\ActiveForm $form */

// 1. Load Assets (Quill & Flatpickr)
$this->registerCssFile('https://cdn.quilljs.com/1.3.6/quill.snow.css');
$this->registerCssFile('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
$this->registerJsFile('https://cdn.quilljs.com/1.3.6/quill.js');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/flatpickr');

// Setup Preview URL
$hasImage = !empty($model->image_link);
$previewUrl = $hasImage ? Yii::getAlias('@web/') . $model->image_link : '';
?>

<?php Pjax::begin(['id' => 'blog-pjax-container']); ?>

<div class="blogs-form">
    <?php $form = ActiveForm::begin([
        'id' => 'blog-form',
        'options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'form-label fw-bold'], 
            'inputOptions' => ['class' => 'form-control'],
        ],
    ]); ?>

    <div class="row g-4"> <div class="col-md-8">
            <div class="mb-4">
                <?= $form->field($model, 'title')->textInput([
                    'maxlength' => true, 
                    'class' => 'form-control form-control-lg fs-4 fw-bold', // Make it look like a Headline
                    'placeholder' => 'Enter an engaging title...',
                    'style' => 'height: 50px;'
                ])->label(false) ?> </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-uppercase fs-xs text-muted">Blog Content</label>
                
                <div class="bg-white border rounded shadow-sm overflow-hidden">
                    <div id="toolbar-container" class="border-bottom bg-body-light">
                        <span class="ql-formats">
                            <select class="ql-header"></select>
                            <button class="ql-bold"></button>
                            <button class="ql-italic"></button>
                            <button class="ql-underline"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-list" value="ordered"></button>
                            <button class="ql-list" value="bullet"></button>
                            <button class="ql-blockquote"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-link"></button>
                            <button class="ql-clean"></button>
                        </span>
                    </div>
                    
                    <div id="editor-container" style="min-height: 400px; font-size: 16px; font-family: inherit;">
                        <?= $model->content ?> 
                    </div>
                </div>

                <div style="display:none">
                    <?= $form->field($model, 'content')->textarea(['id' => 'hidden-content-input']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-body-extra-light mb-3">
                <div class="card-body">
                    <h6 class="mb-3 text-uppercase fw-bold text-muted fs-xs">Publishing</h6>
                    
                    <div class="mb-3">
                        <?= $form->field($model, 'status')->dropDownList(
                            [1 => 'Published', 0 => 'Draft'],
                            ['class' => 'form-select']
                        ) ?>
                    </div>

                    <div class="mb-3">
                         <?= $form->field($model, 'published_at')->textInput([
                            'class' => 'form-control flatpickr-input', 
                            'placeholder' => 'Select date...',
                            'id' => 'publish-date-picker'
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 bg-body-extra-light">
                <div class="card-body">
                    <h6 class="mb-3 text-uppercase fw-bold text-muted fs-xs">Featured Image</h6>
                    
                    <div class="text-center p-3 border border-2 border-dashed rounded bg-white position-relative">
                        
                        <div id="blog-image-preview" class="mb-2" style="display: <?= $hasImage ? 'block' : 'none' ?>;">
                            <img id="blog-img-tag" src="<?= $previewUrl ?>" class="img-fluid rounded shadow-sm" style="max-height: 150px; width: 100%; object-fit: cover;">
                            <button type="button" id="btn-remove-blog-img" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle shadow">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>

                        <div id="blog-upload-ui" class="<?= $hasImage ? 'd-none' : '' ?>">
                            <i class="fa fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                            <p class="text-muted fs-sm mb-2">Drop image here or click to upload</p>
                            
                            <?= $form->field($model, 'imageFile')->fileInput([
                                'id' => 'blog-file-input',
                                'class' => 'form-control form-control-sm',
                                'style' => 'opacity: 0; position: absolute; top:0; left:0; width:100%; height:100%; cursor: pointer;'
                            ])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block-content block-content-full text-end bg-body-light rounded-bottom p-3 mt-4">
       <?= Html::a('cancel', ['index'], [
            'class' => 'btn btn-alt-secondary me-2',
           
        ]) ?>
        <?= Html::submitButton('Save Blog Post', ['class' => 'btn btn-primary px-4', 'id' => 'btn-save-blog']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php Pjax::end(); ?>

<?php
$script = <<< JS
    // 1. Initialize Quill
    var quill;
    if (document.getElementById('editor-container')) {
        quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Write your masterpiece...',
            modules: {
                toolbar: '#toolbar-container'
            }
        });
    }

    // 2. THE FIX: Sync Content on EVERY Change
    // This ensures Yii validation always sees the content
    var hiddenInput = document.getElementById('hidden-content-input');
    
    quill.on('text-change', function() {
        hiddenInput.value = quill.root.innerHTML;
    });

    // 3. Initialize Flatpickr (Date Picker)
    flatpickr("#publish-date-picker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        defaultDate: new Date()
    });

    // 4. Image Preview Logic
    document.getElementById('blog-file-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('blog-img-tag').src = e.target.result;
                document.getElementById('blog-image-preview').style.display = 'block';
                document.getElementById('blog-upload-ui').classList.add('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('btn-remove-blog-img').addEventListener('click', function() {
        document.getElementById('blog-file-input').value = '';
        document.getElementById('blog-image-preview').style.display = 'none';
        document.getElementById('blog-upload-ui').classList.remove('d-none');
    });
JS;
$this->registerJs($script);
?>