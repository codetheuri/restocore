<?php

use helpers\Html;
use helpers\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use dashboard\models\MenuCategories;

/** @var yii\web\View $this */
/** @var dashboard\models\FoodMenus $model */
/** @var helpers\widgets\ActiveForm $form */

// 1. Fetch Categories
$categories = ArrayHelper::map(
    MenuCategories::find()->where([ 'is_deleted' => 0])->all(), 
    'id', 
    'name'
);

// 2. Load Quill Assets
$this->registerCssFile('https://cdn.quilljs.com/1.3.6/quill.snow.css');
$this->registerJsFile('https://cdn.quilljs.com/1.3.6/quill.js');

// 3. Image Preview Setup
$hasImage = !empty($model->image);
$previewUrl = $hasImage ? Yii::getAlias('@web/') . $model->image : '';
?>

<?php Pjax::begin(['id' => 'menu-pjax-container']); ?>

<div class="food-menus-form">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'form-label fw-bold'], 
            'inputOptions' => ['class' => 'form-control'],
        ],
    ]); ?>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="block block-rounded h-100 mb-0">
                <div class="block-content">
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <?= $form->field($model, 'name')->textInput([
                                'maxlength' => true, 
                                'placeholder' => 'e.g., Grilled Chicken Salad',
                                'class' => 'form-control form-control-lg'
                            ]) ?>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Price</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold">KES</span>
                                <?= $form->field($model, 'price', ['template' => "{input}\n{error}"])->textInput([
                                    'type' => 'number', 
                                    'step' => '0.01',
                                    'class' => 'form-control form-control-lg'
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'category_id')->dropDownList(
                            $categories, 
                            ['prompt' => '-- Select Category --', 'class' => 'form-select']
                        ) ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description / Ingredients</label>
                        
                        <div class="bg-white border rounded">
                            <div id="toolbar-container" class="border-bottom bg-body-light">
                                <span class="ql-formats">
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-list" value="bullet"></button>
                                    <button class="ql-list" value="ordered"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-clean"></button>
                                </span>
                            </div>
                            
                            <div id="editor-container" style="height: 150px; font-size: 14px;">
                                <?= $model->description ?>
                            </div>
                        </div>

                        <div style="display:none;">
                            <?= $form->field($model, 'description')->textarea(['id' => 'hidden-description']) ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            
            <div class="block block-rounded mb-3">
                <div class="block-content text-center p-3">
                    <label class="form-label fw-bold mb-2">Food Image</label>
                    <div class="p-2 border border-2 border-dashed rounded bg-body-light position-relative">
                        <div id="menu-image-preview" class="mb-2" style="display: <?= $hasImage ? 'block' : 'none' ?>;">
                            <img id="menu-img-tag" src="<?= $previewUrl ?>" class="img-fluid rounded shadow-sm" style="max-height: 160px; width: 100%; object-fit: cover;">
                            <button type="button" id="btn-remove-menu-img" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle shadow">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div id="menu-upload-ui" class="<?= $hasImage ? 'd-none' : '' ?> py-4">
                            <i class="fa fa-utensils fa-2x text-muted mb-2"></i>
                            <div class="text-muted fs-sm">Upload Photo</div>
                        </div>
                        <?= $form->field($model, 'imageFile')->fileInput([
                            'id' => 'menu-file-input',
                            'class' => 'form-control',
                            'style' => 'opacity: 0; position: absolute; top:0; left:0; width:100%; height:100%; cursor: pointer;'
                        ])->label(false) ?>
                    </div>
                </div>
            </div>

            <div class="block block-rounded">
                <div class="block-content">
                    <div class="mb-4">
                        <label class="form-label fw-bold d-block">Stock Status</label>
                        <div class="form-check form-switch">
                            <?php $model->is_available = $model->isNewRecord ? 1 : $model->is_available; ?>
                            <input class="form-check-input" type="checkbox" id="stockSwitch" name="FoodMenus[is_available]" value="1" <?= $model->is_available ? 'checked' : '' ?>>
                            <label class="form-check-label" for="stockSwitch">Available to Order</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">Website Visibility</label>
                         <?= $form->field($model, 'status')->dropDownList([1 => 'Published', 0 => 'Hidden (Draft)'], ['class' => 'form-select'])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block-content block-content-full text-end bg-body-light rounded-bottom p-3 mt-3">
       
        <?= Html::a('cancel', ['index'], [
            'class' => 'btn btn-alt-secondary me-2',
           
        ]) ?>
        <?= Html::submitButton('Save Item', ['class' => 'btn btn-primary px-4']) ?>
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
            placeholder: 'Ingredients, allergens, or special notes...',
            modules: {
                toolbar: '#toolbar-container'
            }
        });

        // 2. Sync Logic (Immediate update)
        var hiddenInput = document.getElementById('hidden-description');
        quill.on('text-change', function() {
            hiddenInput.value = quill.root.innerHTML;
        });
    }

    // 3. Image Preview Logic
    document.getElementById('menu-file-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('menu-img-tag').src = e.target.result;
                document.getElementById('menu-image-preview').style.display = 'block';
                document.getElementById('menu-upload-ui').classList.add('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('btn-remove-menu-img').addEventListener('click', function() {
        document.getElementById('menu-file-input').value = '';
        document.getElementById('menu-image-preview').style.display = 'none';
        document.getElementById('menu-upload-ui').classList.remove('d-none');
    });
JS;
$this->registerJs($script);
?>