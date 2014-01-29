<?php
/* @var $this ProjectController */

$this->breadcrumbs=array(
	'Проекты'=>array('/project'),
	'WebGit',
);
?>
<?php
	$url = Yii::app()->getBaseUrl().'/git';
	if ($project != '') {
		$url = $url.'/?p='.$project.';a=summary';
	}
?>
<iframe src="<?php echo $url;?>" width="920" height="600" frameborder="0" style="margin:0;"></iframe>