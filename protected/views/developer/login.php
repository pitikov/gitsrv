<?php
/* @var $this LoginFormController */
/* @var $model LoginForm */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form-login-form',
	'enableAjaxValidation'=>false,
)); ?>
<h1>Авторизация пользователя</h1>
	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->textField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rememberMe'); ?>
		<?php echo $form->checkBox($model,'rememberMe'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Авторизация'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->