<?php

use yii\captcha\Captcha;

$this->title = "Wall History - All posts";

?>

<div class="row">
    <div class="col-md-8">

        <?php if(!empty($savedPosts)): ?>
            <?php foreach ($savedPosts as $post): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="mb-3"><?=$post->name?></h4>
                        <div class="message_box">
                            <?=$post->message?>
                        </div>

                        <div class="message_info">
                            <?=Yii::$app->formatter->asRelativeTime($post->created_date)?> | <?=$post->ipAddress?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
    <div class="col-md-4">
        <?php $form = \yii\bootstrap5\ActiveForm::begin([
            'class' => 'fixed_form',
            'action' => '/post/post-save'
        ]) ?>

        <?= $form->field($model,'name')->textInput(['placeholder' => 'Имя']) ?>

        <?= $form->field($model,'message')->textarea(['rows' => 4, 'placeholder' => 'Ваши гениальные мысли, которые запомнит история']) ?>

        <?= $form->field($model, 'captcha')->widget(Captcha::class, [
            'template' => '{image}<div class="row"><div class="col-12">{input}</div></div>',
        ]) ?>

        <?= \yii\bootstrap5\Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>

        <?php $form = \yii\bootstrap5\ActiveForm::end() ?>
    </div>
</div>