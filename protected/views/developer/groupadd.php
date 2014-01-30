<?php
/* @var $this GroupFormController */
/* @var $model GroupForm */
/* @var $form CActiveForm */
$this->breadcrumbs=array(
	'Разработчики'=>array('/developer/index'),
	'Создать группу'
);
?>
<h1>Создать группу</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-form-groupadd-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля, отмеченные символом <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	
<?php
$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'Основная информация')); ?>
		<div class="row">
		<?php echo $form->labelEx($model,'group'); ?>
		<?php echo $form->textField($model,'group'); ?>
		<?php echo $form->error($model,'group'); ?>
	</div>
<?php $this->endWidget(); ?>

<?php 
$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>$model->attributeLabels()['memberlist'])); 

foreach(array_keys($model->memberlist) as $key) { ?>
		
		<div class="row">
			<?php echo $form->checkbox($model, "memberlist[{$key}]") . " $key"; ?>
		</div>
		
<?php
}

echo $form->error($model,'memberlist');
$this->endWidget(); 
?>

<?php 
	$tabParameters = array();
	foreach($this->clips as $key=>$clip) $tabParameters['tab'.(count($tabParameters)+1)] = array('title'=>$key, 'content'=>$clip);
?>

<?php $this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters)); ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Создать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->