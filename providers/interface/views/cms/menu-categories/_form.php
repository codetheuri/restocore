<?php

use helpers\Html;
use helpers\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var dashboard\models\MenuCategories $model */
/** @var helpers\widgets\ActiveForm $form */
?>

<?php Pjax::begin(['id' => 'menu-categories-pjax']); ?>

<div class="menu-categories-form">
    <?php $form = ActiveForm::begin([
        'options' => ['data-pjax' => true],
        // Force Vertical Layout (Labels above inputs)
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'form-label fw-bold'], 
            'inputOptions' => ['class' => 'form-control'],
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-12 mb-3">
            <?= $form->field($model, 'name')->textInput([
                'maxlength' => true, 
                'placeholder' => 'e.g., Breakfast, Italian, Drinks...',
                'class' => 'form-control form-control-lg' // Make it slightly larger
            ]) ?>
        </div>

        <div class="col-md-12 mb-3">
            <?= $form->field($model, 'description')->textarea([
                'rows' => 4, 
                'placeholder' => 'Short description for the menu section (optional)...'
            ]) ?>
        </div>
       
        <div class="col-md-12 mb-3">
            <label class="form-label fw-bold d-block">Visibility</label>
            <div class="btn-group w-100" role="group">
                <?php $status = $model->isNewRecord ? 1 : $model->status; ?>
                
                <input type="radio" class="btn-check" name="MenuCategories[status]" id="status-active" value="1" <?= $status == 1 ? 'checked' : '' ?>>
                <label class="btn btn-outline-success" for="status-active">
                    <i class="fa fa-check me-1"></i> Visible
                </label>

                <input type="radio" class="btn-check" name="MenuCategories[status]" id="status-hidden" value="0" <?= $status == 0 ? 'checked' : '' ?>>
                <label class="btn btn-outline-danger" for="status-hidden">
                    <i class="fa fa-eye-slash me-1"></i> Hidden
                </label>
            </div>
        </div>
    </div>

    <div class="block-content block-content-full text-end bg-body-light rounded-bottom p-3">
        <button type="button" class="btn btn-alt-secondary me-2" data-bs-dismiss="modal">Cancel</button>
        <?= Html::submitButton('Save Category', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php Pjax::end(); ?>