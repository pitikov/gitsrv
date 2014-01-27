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
));?>