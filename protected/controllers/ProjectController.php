<?php

class ProjectController extends Controller
{
	public function actionAdd()
	{
		$model = new ProjectForm('create');
		$model->owner = Yii::app()->params['default_owner'];
		$model->group = Yii::app()->params['default_group'];

		if (isset($_POST['ajax']) && $_POST['ajax']==='project-form-add-form') {
			echo CActiveForm::validate($model);
			$model->project_unique();
			Yii::app()->end();
		}

		if (isset($_POST['ProjectForm']))
		{
			$model->attributes=$_POST['ProjectForm'];
			if ($model->validate())
			{
				if ($model->is_group_create & !$model->groupexists($model->group)) {
					exec('sudo /usr/sbin/groupadd '.$model->group);
				}

				exec('cd '.Yii::app()->params['gitsrv_root'].' && sudo git init --bare '.$model->project);
				exec('sudo /usr/bin/chown '.$model->owner.':'.$model->group.' '.Yii::app()->params['gitsrv_root'].$model->project.' -Rf');
				exec('sudo /usr/bin/chmod g+rwx '.Yii::app()->params['gitsrv_root'].$model->project.' -Rf');
				exec('sudo /usr/bin/chmod 777 '.Yii::app()->params['gitsrv_root'].$model->project.'/description -Rf');
				exec('sudo echo '.$model->description.' > '.Yii::app()->params['gitsrv_root'].$model->project.'/description');
				$this->redirect(array('/project'));
			}
		}
		$this->render('add', array('model'=>$model));
	}

	public function actionDelete($project)
	{
		exec('sudo rm -Rf '.Yii::app()->params['gitsrv_root'].$project);
		$this->redirect(array('/project'));
	}

	public function actionEdit($project)
	{
		$model = new ProjectForm('edit');

		$model->project = $project;
		$model->description = file_get_contents(Yii::app()->params['gitsrv_root'].$project.'/description');
		$model->owner = posix_getpwuid(fileowner(Yii::app()->params['gitsrv_root'].$project))['name'];
		$model->group = posix_getgrgid(filegroup(Yii::app()->params['gitsrv_root'].$project))['name'];

		if (isset($_POST['ajax']) && $_POST['ajax']==='project-form-edit-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['ProjectForm']))
		{
			$model->attributes=$_POST['ProjectForm'];
			if ($model->validate())
			{
				exec('sudo /usr/bin/chown '.$model->owner.':'.$model->group.' '.Yii::app()->params['gitsrv_root'].$model->project.' -Rf');
				exec('sudo /usr/bin/chmod g+rwx '.Yii::app()->params['gitsrv_root'].$model->project.' -Rf');
				exec('sudo /usr/bin/chmod 777 '.Yii::app()->params['gitsrv_root'].$model->project.'/description -Rf');
				exec('sudo echo '.$model->description.' > '.Yii::app()->params['gitsrv_root'].$model->project.'/description');
				$this->redirect(array('/project'));
			}
		}
		$this->render('edit', array('model'=>$model));
	}

	public function actionIndex()
	{
		$rawData = array();

		$dirindex = scandir(Yii::app()->params['gitsrv_root']);
		foreach($dirindex as $diritem) {
			switch ($diritem) {
				case '.':
				case '..':
					break;
				default:
					$prjstruct = scandir(Yii::app()->params['gitsrv_root'].$diritem);

			if ($prjstruct &&
					(array_search('branches', $prjstruct)) &&
					(array_search('config', $prjstruct)) &&
					(array_search('description', $prjstruct)) &&
					(array_search('HEAD', $prjstruct)) &&
					(array_search('hooks', $prjstruct)) &&
					(array_search('info', $prjstruct)) &&
					(array_search('objects', $prjstruct)) &&
					(array_search('refs', $prjstruct))
					) {
						$owner = posix_getpwuid(fileowner(Yii::app()->params['gitsrv_root'].$diritem))['name'];
						$group = posix_getgrgid(filegroup(Yii::app()->params['gitsrv_root'].$diritem))['name'];

						$description = file_get_contents(Yii::app()->params['gitsrv_root'].$diritem.'/description');
						array_push($rawData, array('id'=>$diritem,  'owner'=>$owner,  'group'=>$group, 'description'=>$description));
					}
					break;
			}
		}


		$project_list = new CArrayDataProvider(
			$rawData,
			array(
				'pagination'=>array(
					'pageSize'=>50,
				),
			)
		);
		$this->render('index', array('prjlist'=>$project_list));
	}

	public function actionWebgit($project = '')
	{
		$this->render('webgit', array('project'=>$project));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}