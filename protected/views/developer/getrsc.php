<?php
$this->breadcrumbs=array(
	'Рессурсы'
);
?>

<h1>Рессурсы</h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$rsclist,
    'columns'=>array(
			array(
				'name'=>'id',
				'header'=>'№',
				'value'=>'$row+1',
			),
			array(
				'name'=>'id',
				'header'=>'файл',
				'class'=>'RscColumn',
			),

			array(
				'name'=>'size',
				'header'=>'размер',
				'value'=>'number_format($data["size"], 2)." Mb"'
			),
			array(
				'name'=>'description',
				'header'=>'описание',
			),   
		),
		'summaryText'=>'Рессурсы {start}-{end} из {count}',
	)
);

?>