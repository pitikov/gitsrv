<?php
/* @var $this DeveloperController */

$this->breadcrumbs=array(
	'Разработчики',
);
?>
<h1>Разработчики и группы</h1>
<?php


$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'Разработчики')); ?>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'Группы')); ?>
<?php $this->endWidget(); ?>

<?php


    $tabParameters = array();
    foreach($this->clips as $key=>$clip)
        $tabParameters['tab'.(count($tabParameters)+1)] = array('title'=>$key, 'content'=>$clip); // !!
    ?>

    <?php $this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters)); ?>


