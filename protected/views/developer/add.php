<?php
/* @var $this DeveloperFormController */
/* @var $model DeveloperForm */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
	'Разработчики'=>array('/developer'),
	'Добавить учетную запись',
);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'developer-form-add-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login'); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

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
		<?php echo $form->labelEx($model,'password_duplicate'); ?>
		<?php echo $form->textField($model,'password_duplicate'); ?>
		<?php echo $form->error($model,'password_duplicate'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Добавить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->