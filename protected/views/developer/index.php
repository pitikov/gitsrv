<?php
/* @var $this DeveloperController */

$this->breadcrumbs=array(
	'Разработчики',
);
?>
<h1>Разработчики и группы</h1>
<?php


$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>array(
        'Разработчики'=>array('content'=>'Таблица пользователей', 'id'=>'developers'),
        'Группы'=>array('content'=>'Таблица групп', 'id'=>'groups'),


    ),
    'options'=>array(
        'collapsible'=>true,
    ),
));

?>