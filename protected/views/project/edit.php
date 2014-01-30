<?php
/* @var $this ProjectController */

$this->breadcrumbs=array(
	'Проект'=>array('/project'),
	$model->project,
);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form-edit-form',
	'enableAjaxValidation'=>true,
)); ?>

	<h1>Редактирование параметров проекта &quot;<?php echo $model->project; ?>&quot;</h1>
	<p class="note">Поля, отмеченные символом <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<?php $is_owner_edit = ($model->owner==Yii::app()->user->name) | (Yii::app()->user->getId()==0);?>
		<?php echo $form->labelEx($model,'owner'); ?>
		<?php echo $is_owner_edit?$form->dropdownlist($model,'owner', $model->ownerList()):$model->owner; ?>
		<?php echo $form->error($model,'owner'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group'); ?>
		<?php echo $form->dropdownlist($model,'group', $model->groupList()); ?>
		<?php echo $form->error($model,'group'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->