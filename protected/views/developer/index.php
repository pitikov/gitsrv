<?php
/* @var $this DeveloperController */

$this->breadcrumbs=array(
	'Разработчики',
);
?>
<h1>Разработчики и группы</h1>

<?php

$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'Разработчики')); 
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$devlist,
    'columns'=>array(
			array(
				'name'=>'id',
				'header'=>'login',
				'class'=>'DeveloperColumn',
			),
			'uid','gid',
			array(
				'name'=>'groups',
				'header'=>'группы',
			),
			array(
				'name'=>'name',
				'header'=>'имя пользователя',
			),
			array(
				'name'=>'home',
				'header'=>'домашний каталог',
			),
			array(
				'name'=>'shell',
				'header'=>'оболочка',
			),
			array(
				'name'=>'id',
				'header'=>'',
				'class'=>'DeveloperCtrlColumn',
			),
    ),
		'summaryText'=>CHtml::link('<img title="Добавить учетную запись" src="/images/new.png"/>', array('/developer/addDeveloper')).' Учетные записи {start}-{end} из {count}',
		'emptyText'=>'Учетных записей пользователей не найденно. Вы можете добавить учетную запись '. CHtml::link('<img title="Добавить учетную запись" src="/images/new.png"/>', array('/developer/addDeveloper')),
	)
);

$this->endWidget(); ?>

<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'Группы')); 
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$grouplist,
    'columns'=>array(
			array(
				'name'=>'id',
				'header'=>'группа',
			),
			array(
				'name'=>'gid',
				'header'=>'gid',
			),
			array(
				'name'=>'users',
				'header'=>'члены группы',
			),
			array(
				'name'=>'id',
				'header'=>'',
				'class'=>'GroupCtrlColumn'
			),
    ),
		'summaryText'=>CHtml::link('<img title="Добавить группу" src="/images/new.png"/>', array('/developer/addGroup')).' Группы {start}-{end} из {count}',
		'emptyText'=>'Групп пользователей не найденно. Вы можете добавить группу '. CHtml::link('<img title="Добавить группу" src="/images/new.png"/>', array('/developer/addGroup')),
	)
);

$this->endWidget(); ?>

<?php


    $tabParameters = array();
    foreach($this->clips as $key=>$clip)
        $tabParameters['tab'.(count($tabParameters)+1)] = array('title'=>$key, 'content'=>$clip); // !!
    ?>

    <?php $this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters)); ?>


