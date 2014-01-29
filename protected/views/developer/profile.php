<?php
/* @var $this DeveloperController */

$this->breadcrumbs=array(
	'Разработчик'=>array('/developer'),
	$model->login,
);
?>
<h1><?php echo "Профиль пользователя &quot;$model->login&quot;"; ?></h1>

<div class="form">
	<?php if(Yii::app()->user->hasFlash('success')) : ?><div class='flash-success'><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif;?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'developer-form-profile-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля, отмеченные символом <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

<?php /*
	*/?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password_duplicate'); ?>
		<?php echo $form->passwordField($model,'password_duplicate'); ?>
		<?php echo $form->error($model,'password_duplicate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить профиль'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->