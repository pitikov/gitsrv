<?php

class DeveloperForm extends CFormModel
{
	public $login;
	public $username;
	public $password;
	public $password_duplicate;
	public $grouplist;
	public $rsakey;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('username', 'required'),
			array('login','required','on'=>'useradd'),
			array('login','loginunique','on'=>'useradd'),
			array('password, password_duplicate', 'required','on'=>'useradd'),
			array('password, password_duplicate', 'compare', 'compareAttribute'=>'password_duplicate', 'allowEmpty'=>true, 'strict'=>true, 'on'=>'useradd, usermod'),
			array('grouplist', 'grouplistvalidate'),
			array('rsakey','type','type'=>'string'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'login'=>'login',
			'username'=>'Имя пользователя',
			'password'=>'Пароль',
			'password_duplicate'=>'Повторите ввод пароля',
			'grouplist'=>'Список груп',
			'rsakey'=>'открытый ключ (файл ~/.ssh/id_rsa.pub)',
		);
	}

	public function loginunique()
	{
		$userlist = array();
		$pwdfile = fopen('/etc/passwd','r');
		if ($pwdfile) {
			while (!feof($pwdfile)) {
			  $userstruct = strtok(fgets($pwdfile, 512),':');
			  if ($userstruct===FALSE) {
			  } else {
					array_push($userlist, $userstruct[0]);
			  }
			}
			fclose($pwdfile);
			if (array_search($this->login, $userlist)===FALSE) {} else {
				$this->addError($this->login, 'login должен быть уникальным');
			}
		}
	}

	public function grouplistvalidate()
	{
		// TODO validate group list
	}

}
