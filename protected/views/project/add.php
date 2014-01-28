<?php
/* @var $this ProjectController */

$this->breadcrumbs=array(
	'Проект'=>array('/project'),
	'Создать',
);
?>
<h1>Создать репозиторий проекта</h1>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form-add-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля, отмеченные символом <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'project'); ?>
		<?php echo $form->textField($model,'project'); ?>
		<?php echo $form->error($model,'project'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'owner'); ?>
		<?php echo $form->textField($model,'owner'); ?>
		<?php echo $form->error($model,'owner'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group'); ?>
		<?php echo $form->textField($model,'group'); ?>
		<?php echo $form->error($model,'group'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_group_create'); ?>
		<?php echo $form->checkBox($model,'is_group_create'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Создать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->