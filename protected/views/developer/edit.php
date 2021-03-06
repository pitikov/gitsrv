<?php /* @var $this DeveloperController */

$this->breadcrumbs=array(
	'Разработчик'=>array('/developer'),
	$model->login,
);
?>
<h1><?php echo "Профиль пользователя &quot;$model->login&quot;"; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'developer-form-edit-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля, отмеченные символом <span class="required">*</span>, обязательны для заполнения.</p>
	
		<?php echo $form->errorSummary($model); ?>
		
<?php
$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'Основная информация')); ?>
	<div class="row"> 
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<p class="note"><span class="required">Заполнение полей ввода пароля требуется только при смене текущего пароля</span>.</p>
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

<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'Группы')); ?>
<?php for ($id = 0; $id < count($model->grouplist); $id++) { ?>
	<h4 class="row">
		<?php 
			$gname = array_keys($model->grouplist)[$id];
			echo  $form->checkBox($model, "grouplist[{$gname}]") . " {$gname}"; 
		?>
	</h4>
	<?php } ?>
<?php $this->endWidget(); ?>

<?php 
	$tabParameters = array();
	foreach($this->clips as $key=>$clip) $tabParameters['tab'.(count($tabParameters)+1)] = array('title'=>$key, 'content'=>$clip); 
?>

<?php $this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters)); ?>
	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить профиль'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->