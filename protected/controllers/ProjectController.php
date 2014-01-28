<?php

class ProjectController extends Controller
{
	public function actionAdd()
	{
		$this->render('add');
	}

	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionEdit()
	{
		$this->render('edit');
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
					'pageSize'=>10,
				),
			)
		);
		$this->render('index', array('prjlist'=>$project_list));
	}

	public function actionView()
	{
		$this->render('view');
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