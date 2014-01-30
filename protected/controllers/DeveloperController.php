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
		if (Yii::app()->user->getId()!=0) {
			$user = Yii::app()->user->name;
			throw new CHttpException(403,"Пользователь {$user} не имеет доступа к данному рессурсу");
		}
		$grouplist = new CArrayDataProvider(array());
		$devlist = new CArrayDataProvider(array());
		$this->render('index', array('devlist'=>$devlist, 'grouplist'=>$grouplist));
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
    $model->grouplist=array();
    $usrglist = array();
    

    foreach(explode(" ", exec("id -G $model->login")) as $group) {
			array_push($usrglist, posix_getgrgid($group)['name']);
    }
    
    $model->grouplist = array_fill_keys($usrglist, true);

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
					$glist = '';

					foreach(array_keys($model->grouplist) as $key) {
						if ($model->grouplist[$key]==TRUE) {
							if ($glist == '') {
								$glist = "-G {$key}";
							} else {
								$glist = $glist.",{$key}";
							}
						}
					}
					exec("sudo /usr/sbin/usermod -c '{$model->username}' {$glist} {$model->login}");
          Yii::app()->user->setFlash('success','Данные пользователя обновленны');
					$this->refresh();
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
          return;
        }
    }
    $this->render('login',array('model'=>$model));
	}

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
}