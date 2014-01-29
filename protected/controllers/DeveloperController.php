<?php

class DeveloperController extends Controller
{

	public function actionAdd()
	{
    $model=new DeveloperForm('useradd');

    if(isset($_POST['ajax']) && $_POST['ajax']==='developer-form-add-form')
    {
			echo CActiveForm::validate($model);
			Yii::app()->end();
    }

    if(isset($_POST['DeveloperForm']))
    {
			$model->attributes=$_POST['DeveloperForm'];
			if($model->validate())
			{
				// TODO form inputs are valid, do something here
				$this->redirect(array('/developer'));
			}
    }
    $this->render('add',array('model'=>$model));
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
		$this->render('index');
	}

	public function actionView()
	{
		$this->render('view');
	}

	public function actionProfile()
	{
    $model=new DeveloperForm('usermod');

    $userinfo = posix_getpwuid(Yii::app()->user->getId());

    $model->login = $userinfo['name'];
    $model->username = $userinfo['gecos'];

    $model->password = '';
    $model->password_duplicate = '';

    if(isset($_POST['ajax']) && $_POST['ajax']==='developer-form-profile-form')
    {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }

    if(isset($_POST['DeveloperForm']))
    {
        $model->attributes=$_POST['DeveloperForm'];
        if($model->validate())
        {

					if (!is_null($model->password)) {
						exec("echo {$model->login}:{$model->password} | sudo /usr/sbin/chpasswd");
					}
					exec("sudo /usr/sbin/usermod -c '$model->username' $model->login");
					// form inputs are valid, do something here
          Yii::app()->user->setFlash('success','Данные пользователя обновленны');
					$this->refresh();
          //$this->redirect($this->createUrl('/developer/profile'));
        }
    }
    $this->render('profile',array('model'=>$model));
	}

	public function actionLogout()
	{
    Yii::app()->user->logout();
    $this->redirect(Yii::app()->homeUrl);
	}

	public function actionLogin()
	{
		$model=new LoginForm('login');

    // uncomment the following code to enable ajax-based validation
    if(isset($_POST['ajax']) && $_POST['ajax']==='login-form-login-form')
    {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }

    if(isset($_POST['LoginForm']))
    {
        $model->attributes=$_POST['LoginForm'];
        if($model->validate() && $model->login())
        {
					$this->redirect($this->createUrl('/project/index'));
					// form inputs are valid, do something here
          return;
        }
    }
    $this->render('login',array('model'=>$model));
	}

	  /**
   * This is the action to handle external exceptions.
   */
  public function actionError()
  {
    if($error=Yii::app()->errorHandler->error)
    {
      if(Yii::app()->request->isAjaxRequest)
	echo $error['message'];
      else
	$this->render('error', $error);
    }
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