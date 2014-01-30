<?php
/* @var $this ProjectController */

$this->breadcrumbs=array(
	'Проекты',
);
?>
<h1>Список проектов</h1>

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$prjlist,
    'columns'=>array(
      array(
          'name'=>'id',
          'header'=>'Проект',
          'class'=>'ProjectColumn',
      ),
      array(
          'name'=>'owner',
          'header'=>'владелец',
      ),
      array(
          'name'=>'group',
          'header'=>'группа',
      ),
      array(
          'name'=>'description',
          'header'=>'Описание',
      ),
			array(
          'name'=>'id',
          'header'=>'',
          'class'=>'ProjectCtrlColumn',
      ),
		),
		'summaryText'=>CHtml::link('<img title="Создать проект" src="/images/new.png"/>', array('/project/add')).' Проекты {start}-{end} из {count}',
		'emptyText'=>'Проектов на сервере не найденно. Вы можете создать проект'. CHtml::link('<img title="Создать проект" src="/images/new.png"/>', array('/project/add')),
	));
?>