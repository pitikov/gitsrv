<?php

class DeveloperController extends Controller
{
	
	public function actions()
	{
	  return array(
	      'page'=>array('class'=>'CViewAction')
	  );
	}
	
	public function actionGetRessource()
	{
		if (Yii::app()->user->isGuest) {
			throw new CHttpException(403,"Только авторизированные пользователи имеют доступ к данному рессурсу");
		} else {
			$ressourceList = array();
			$rscdir = scandir(Yii::app()->basepath."/../ressource");
			if ($rscdir) foreach($rscdir as $file) {
				if (($file != ".") & ($file != "..") & ($file != ".dirindex")) {
					array_push($ressourceList, array('id'=>$file, 'size'=>filesize(Yii::app()->basepath."/../ressource/{$file}")/(1000*1000), 'description'=>''));
				}
			}
			if (array_search('.dirindex', $rscdir)) {
				$dirinfo = fopen(Yii::app()->basepath."/../ressource/.dirindex", 'r');
				if ($dirinfo) {
					while (!feof($dirinfo)) {
						$item = explode(":",fgets($dirinfo));
						if (count($item)>=2) {
							for($id = 0 ; $id < count($ressourceList); $id++) {
								if ($ressourceList[$id]['id']==$item[0]) {
									$ressourceList[$id]['description']=$item[1];
								}
							}
						}
					}
					fclose($dirinfo);
				}
			}
			$rsclist = new CArrayDataProvider($ressourceList);
			$this->render('getrsc', array('rsclist'=>$rsclist));
		}
	}
	
	public function actionAddDeveloper()
	{
		if (Yii::app()->user->getId()!=0) {
			$user = Yii::app()->user->name;
			throw new CHttpException(403,"Пользователь {$user} не имеет доступа к данному рессурсу");
		}
    $model=new DeveloperForm('useradd');

    $sysgroups = array();
		$groupfile = fopen('/etc/group','r');
		if ($groupfile) {
			while (!feof($groupfile)) {
				$gitem = explode (":", fgets($groupfile));
				if (count($gitem)==4) {
					if (
						($gitem[2]>=Yii::app()->params['min_gid']) &
						($gitem[0]!='nobody') &
						($gitem[0]!='nogroup')
					) {
						array_push($sysgroups, $gitem[0]);
					}
				}
			}
			fclose($groupfile);
		}

		$model->grouplist = array_fill_keys($sysgroups, FALSE);

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
				$grouplist = false;
				foreach(array_keys($model->grouplist) as $group) {
					if ($model->grouplist[$group]) {
						if ($grouplist == false) $grouplist = "-G $group";
						else $grouplist = $grouplist.",$group";
					}
				}
				if ($groupfile == false) $grouplist = '';
				exec ("sudo /usr/sbin/useradd -g users -c '{$model->username}' -k /etc/skel -m -s /usr/bin/git-shell {$grouplist} {$model->login}");
				exec("echo {$model->login}:{$model->password} | sudo /usr/sbin/chpasswd");

				$this->redirect(array('/developer'));
			}
    }
    $this->render('adddeveloper',array('model'=>$model));
	}

	public function actionAddGroup()
	{
		if (Yii::app()->user->getId()!=0) {
			$user = Yii::app()->user->name;
			throw new CHttpException(403,"Пользователь {$user} не имеет доступа к данному рессурсу");
		}
    $model=new GroupForm;
    $sysusers = array();
    $pwdfile = fopen('/etc/passwd','r');
    if ($pwdfile) {
			while (!feof($pwdfile)) {
				$pwditem = explode(":",fgets($pwdfile));
				if (count($pwditem)==7) {
					if (
						($pwditem[1] != "*") &
						($pwditem[2] >= Yii::app()->params['min_uid']) &
						($pwditem[0] != 'nobody')
					) {
						array_push($sysusers, $pwditem[0]);
					}
				}
			}
			fclose($pwdfile);
    }
    $model->memberlist = array_fill_keys($sysusers, false);
    if (isset($model->memberlist[Yii::app()->user->name])) $model->memberlist[Yii::app()->user->name] = true;

    if(isset($_POST['ajax']) && $_POST['ajax']==='group-form-groupadd-form')
    {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }

    if(isset($_POST['GroupForm']))
    {
			$model->attributes=$_POST['GroupForm'];
      if($model->validate()) {
				exec("sudo /usr/sbin/groupadd $model->group");
				foreach(array_keys($model->memberlist) as $member) {
					if ($model->memberlist[$member] == TRUE) exec ("sudo /usr/sbin/usermod -a -G {$model->group} {$member}");
				}

				$this->redirect($this->createUrl('/developer/index').'#tab2');
      }
    }
    $this->render('groupadd',array('model'=>$model));
	}

	public function actionDeleteDeveloper($login)
	{
		if (Yii::app()->user->getId()!=0) {
			$user = Yii::app()->user->name;
			throw new CHttpException(403,"Пользователь {$user} не имеет доступа к данному рессурсу");
		} else {
			exec("sudo /usr/sbin/userdel -f -r {$login}");
		}
		$this->redirect($this->createUrl('/developer/index'));
	}

	public function actionDeleteGroup($group)
	{
		if (Yii::app()->user->getId()!=0) {
			$user = Yii::app()->user->name;
			throw new CHttpException(403,"Пользователь {$user} не имеет доступа к данному рессурсу");
		} else {
			exec("sudo /usr/sbin/groupdel {$group}");
			$this->redirect($this->createUrl('/developer/index').'#tab2');
		}
	}

	public function actionEditDeveloper($login)
	{
		if (Yii::app()->user->getId()!=0) {
			$user = Yii::app()->user->name;
			throw new CHttpException(403,"Пользователь {$user} не имеет доступа к данному рессурсу");
		} else {
			$model=new DeveloperForm('usermod');

			$userinfo = posix_getpwnam($login);

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
					$this->redirect($this->createUrl('/developer/index'));
        }
			}
			$this->render('edit',array('model'=>$model));
		}
	}

	public function actionIndex()
	{
		if (Yii::app()->user->getId()!=0) {
			$user = Yii::app()->user->name;
			throw new CHttpException(403,"Пользователь {$user} не имеет доступа к данному рессурсу");
		}

		$sysusers = array();
		$pwdfile = fopen('/etc/passwd', 'r');
		if ($pwdfile) {
			while (!feof($pwdfile)) {
				$pwditem = explode(":", fgets($pwdfile));
				if (count($pwditem)==7) {
					if (
						($pwditem[1] != "*") &
						($pwditem[2] >= Yii::app()->params['min_uid']) &
						($pwditem[0] != 'nobody')
					) {
						$usergrouplist = explode(" ",exec("id -G $pwditem[0]"));
						$usergroups = false;
						foreach($usergrouplist as $usergroup) {
							if ($usergroups == false) {
								$usergroups = posix_getgrgid($usergroup)['name'];
							} else {
								$usergroups = "{$usergroups}, ". posix_getgrgid($usergroup)['name'];
							}
						}

						array_push($sysusers, array(
							'id'=>$pwditem[0],
							'uid'=>$pwditem[2],
							'gid'=>posix_getgrgid($pwditem[3])['name'],
							'groups'=>$usergroups,
							'name'=>$pwditem[4],
							'home'=>$pwditem[5],
							'shell'=>$pwditem[6]
						));
					}
				}
			}
			fclose($pwdfile);
		}

		$sysgroups = array();
		$groupfile = fopen('/etc/group','r');
		if ($groupfile) {
			while (!feof($groupfile)) {
				$gitem = explode (":", fgets($groupfile));
				if (count($gitem)==4) {
					if (
						($gitem[2]>=Yii::app()->params['min_gid']) &
						($gitem[0]!='nobody') &
						($gitem[0]!='nogroup')
					)
					{
						array_push($sysgroups, array(
							'id'=>$gitem[0],
							'gid'=>$gitem[2],
							'users'=>str_replace(",", ", ", $gitem[3])
						));
					}
				}
			}
			fclose($groupfile);
		}

		$devlist = new CArrayDataProvider(
			$sysusers,
			array(
				'pagination'=>array(
				'pageSize'=>25,
			),
		));
		$grouplist = new CArrayDataProvider(
			$sysgroups,
			array(
				'pagination'=>array(
				'pageSize'=>25,
			),
		));
		$this->render('index', array('devlist'=>$devlist, 'grouplist'=>$grouplist));
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

					if ($model->rsakey!="") {
						$sshdir = posix_getpwnam(Yii::app()->user->name)['dir']."/.ssh";
						if (array_search('.ssh', scandir(posix_getpwnam(Yii::app()->user->name)['dir']),true)===FALSE) mkdir($sshdir);
						exec("sudo /usr/bin/chmod 777 -Rf {$sshdir}");
						$is_key_exists = false;
						if (!(array_search('authorized_keys', scandir(posix_getpwnam(Yii::app()->user->name)['dir']."/.ssh"),true)===FALSE)) {
							$fpubkey = fopen("{$sshdir}/authorized_keys",'r');
							if ($fpubkey) {
								while (!feof($fpubkey)) {
									if (fgets($fpubkey) == $model->rsakey) $is_key_exists = true;
								}
								fclose($fpubkey);
							}
						}
						if (!$is_key_exists) exec("sudo echo '{$model->rsakey}' >> {$sshdir}/authorized_keys");
						exec("sudo /usr/bin/chmod 700 {$sshdir} -Rf");
						exec("sudo /usr/bin/chmod 600 {$sshdir}/authorized_keys");
						exec("sudo /usr/bin/chown {$model->login}:users {$sshdir} -Rf");
					}

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
      if(Yii::app()->request->isAjaxRequest) echo $error['message'];
      else $this->render('error', $error);
    }
  }
}