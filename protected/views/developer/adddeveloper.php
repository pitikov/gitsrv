<?php
/* @var $this DeveloperFormController */
/* @var $model DeveloperForm */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
	'Разработчики'=>array('/developer'),
	'Добавить учетную запись',
);
?>
<h1>Добавление учетной записи разработчика</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'developer-form-add-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля, отмеченные символом <span class="required">*</span>, обязательны для заполнения.</p>
	
	<?php echo $form->errorSummary($model); ?>

	<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'Основная информация')); ?>
	
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
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password_duplicate'); ?>
		<?php echo $form->passwordField($model,'password_duplicate'); ?>
		<?php echo $form->error($model,'password_duplicate'); ?>
	</div>

<?php $this->endWidget(); ?>

<?php 
$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>$model->attributeLabels()['grouplist'])); 
foreach(array_keys($model->grouplist) as $key) { ?>
		
		<div class="row">
			<?php echo $form->checkbox($model, "grouplist[{$key}]") . " $key"; ?>
		</div>
		
<?php
}
$this->endWidget(); ?>

<?php 
	$tabParameters = array();
	foreach($this->clips as $key=>$clip) $tabParameters['tab'.(count($tabParameters)+1)] = array('title'=>$key, 'content'=>$clip);
?>

<?php $this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters)); ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Добавить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->