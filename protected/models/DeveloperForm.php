<?php

class DeveloperForm extends CFormModel
{
	public $login;
	public $username;
	public $password;
	public $password_duplicate;
	public $grouplist;
	public $rsakey;

	const WEAK = 0;
	const STRONG = 1;

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
			array('login', 'match', 'pattern'=>'/^([a-z,A-Z][a-z,A-Z,0-9]+)$/', 'on'=>'useradd'),
			array('login, username', 'length', 'min'=>4, 'max'=>32),
			array('login','loginunique','on'=>'useradd'),
			array('password, password_duplicate', 'required','on'=>'useradd'),
			array('password, password_duplicate', 'compare', 'compareAttribute'=>'password_duplicate', 'allowEmpty'=>true, 'strict'=>true, 'on'=>'useradd, usermod'),
			array('grouplist', 'grouplistvalidate'),
			array('rsakey','type','type'=>'string'),
//			array('password', 'passwordStrength', 'strength'=>self::STRONG),
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
		if (count(posix_getpwnam($this->login))>0) {
			$this->addError($this->login, 'login должен быть уникальным');
		}
	}

	public function grouplistvalidate()
	{
		// TODO validate group list
	}
	
	public function passwordStrength($attribute, $params)
	{
    if ($params['strength'] === self::WEAK)
        $pattern = '/^(?=.*[a-zA-Z0-9]).{5,}$/';  
    elseif ($params['strength'] === self::STRONG)
        $pattern = '/^(?=.*\d(?=.*\d))(?=.*[a-zA-Z](?=.*[a-zA-Z])).{5,}$/';  
 
    if(!preg_match($pattern, $this->$attribute))
      $this->addError($attribute, 'пароль слишком слабый');
	}
}
