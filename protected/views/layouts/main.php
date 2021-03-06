<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="SHORTCUT ICON" href="/images/git.png" type="image/png">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><img src='/images/git.png' height='32' width='32'/><?php echo " ".CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Разработчики', 'url'=>array('/developer/index'), 'visible'=>!Yii::app()->user->isGuest, 'visible'=>((Yii::app()->user->getId()==0) && !Yii::app()->user->isGuest)),
				array('label'=>'Проекты', 'url'=>array('/project/index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'webgit', 'url'=>array('/project/webgit'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Справка', 'url'=>array('/developer/page', 'view'=>'help'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Загрузи', 'url'=>array('/developer/getRessource'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Профиль ('.Yii::app()->user->name.')', 'url'=>array('/developer/profile'),
				'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Выйти', 'url'=>array('/developer/logout'),
				'visible'=>!Yii::app()->user->isGuest, 'linkOptions'=>array('confirm'=>'Завершить сеанс пользователя '.Yii::app()->user->name.'?'))
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; 2014 by <?php echo CHtml::link('Pitikov Evgeniy', 'mailto:pitikov@yandex.ru')?>.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered();?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
