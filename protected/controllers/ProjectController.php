<?php

class ProjectController extends Controller
{
	public function actionAdd()
	{
		$model = new ProjectForm('create');
		
		if (isset($_POST['ajax']) && $_POST['ajax']==='project-form-add-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		if (isset($_POST['ProjectForm']))
		{
			$model->attributes=$_POST['ProjectForm'];
			if ($model->validate())
			{
				exec('cd /srv/git/ && sudo git init --bare '.$model->project);
				exec('sudo /usr/bin/chown '.$model->owner.':'.$model->group.' /srv/git/'.$model->project.' -Rf');
				exec('sudo /usr/bin/chmod g+rwx /srv/git/'.$model->project.' -Rf');
				exec('sudo /usr/bin/chmod 777 /srv/git/'.$model->project.'/description -Rf');
				exec('sudo echo '.$model->description.' > /srv/git/'.$model->project.'/description');
				// TODO implict me
				$this->redirect(array('/project'));
			}
		}
		$this->render('add', array('model'=>$model));
	}

	public function actionDelete($project)
	{
		exec('sudo rm -Rf /srv/git/'.$project);
		$this->redirect(array('/project'));
	}

	public function actionEdit()
	{
			{
		$model = new ProjectForm('create');
		
		if (isset($_POST['ajax']) && $_POST['ajax']==='project-form-edit-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		if (isset($_POST['ProjectForm']))
		{
			$model->attributes=$_POST['ProjectForm'];
			if ($model->validate())
			{
				//exec('cd /srv/git/ && sudo git init --bare '.$model->project);
				exec('sudo /usr/bin/chown '.$model->owner.':'.$model->group.' /srv/git/'.$model->project.' -Rf');
				exec('sudo /usr/bin/chmod g+rwx /srv/git/'.$model->project.' -Rf');
				exec('sudo /usr/bin/chmod 777 /srv/git/'.$model->project.'/description -Rf');
				exec('sudo echo '.$model->description.' > /srv/git/'.$model->project.'/description');
				// TODO implict me
				$this->redirect(array('/project'));
			}
		}
		$this->render('edit', array('model'=>$model));
	}
	}

	public function actionIndex()
	{
		$rawData = array();

		$dirindex = scandir('/srv/git');
		foreach($dirindex as $diritem) {
			switch ($diritem) {
				case '.':
				case '..':
					break;
				default:
					$prjstruct = scandir('/srv/git/'.$diritem);

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
						$owner = posix_getpwuid(fileowner('/srv/git/'.$diritem))['name'];
						$group = posix_getgrgid(filegroup('/srv/git/'.$diritem))['name'];
						
						$description = file_get_contents('/srv/git/'.$diritem.'/description');
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