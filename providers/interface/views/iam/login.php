<?php

use helpers\Html;
use helpers\widgets\ActiveForm;

/** @var yii\web\View $this */

$this->title = 'Sign In';
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-4">
        
        <div class="text-center mb-4 login-logo">
            <div class="d-inline-block bg-white p-2 rounded-3 shadow-sm">
                <?= Html::img(Yii::getAlias('@web/providers/interface/assets/images/logo.jpeg'), [
                    'style' => 'width: 80px; height: 80px; object-fit: cover; border-radius: 8px;',
                    'alt' => Yii::$app->name
                ]) ?>
            </div>
            <h1 class="h4 fw-bold text-white mt-3 mb-1 text-shadow-dark">
                <?= Yii::$app->name ?>
            </h1>
            <p class="text-white-75 fw-medium text-shadow-dark">
                Management Dashboard
            </p>
        </div>

        <div class="block block-rounded glass-card mb-0 overflow-hidden">
            <div class="block-content block-content-full px-lg-5 py-md-5">
                
                <div class="mb-4 text-center">
                    <h2 class="h3 fw-bold mb-1 text-dark">Welcome Back</h2>
                    <p class="text-muted fs-sm">Sign in to your account</p>
                </div>

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    
                    <div class="mb-4">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text">
                                <i class="fa fa-user text-muted"></i>
                            </span>
                            <?= $form->field($model, 'username', [
                                'template' => "{input}\n{error}",
                                'options' => ['class' => 'flex-grow-1'] 
                            ])->textInput([
                                'autofocus' => true, 
                                'class' => 'form-control form-control-alt', 
                                'placeholder' => 'Username',
                                'style' => 'font-size: 1rem;'
                            ])->label(false) ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text">
                                <i class="fa fa-lock text-muted"></i>
                            </span>
                            <?= $form->field($model, 'password', [
                                'template' => "{input}\n{error}",
                                'options' => ['class' => 'flex-grow-1']
                            ])->passwordInput([
                                'class' => 'form-control form-control-alt', 
                                'placeholder' => 'Password',
                                'style' => 'font-size: 1rem;'
                            ])->label(false) ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 fs-sm">
                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'class' => 'form-check-input',
                            'template' => "<div class=\"form-check\">{input} {label}</div>",
                            'labelOptions' => ['class' => 'form-check-label fw-medium text-muted']
                        ]) ?>
                        
                        <a class="fw-semibold text-primary" href="#">
                            Forgot Password?
                        </a>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12">
                            <?= Html::submitButton(
                                'Sign In', 
                                ['class' => 'btn w-100 btn-primary btn-lg shadow py-3 fw-bold']
                            ) ?>
                        </div>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <div class="text-center mt-3">
            <p class="fs-sm text-white-75 mb-0" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                &copy; <?= date('Y') ?> <strong><?= Yii::$app->name ?></strong>. All rights reserved.
            </p>
        </div>

    </div>
</div>