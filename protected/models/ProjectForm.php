<?php

/**
 * ProjectForm class. */
class ProjectForm extends CFormModel
{
	public $project;
	public $owner;
	public $group;
	public $description;

	public $is_group_create;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('project, owner, group, description', 'required'),
			array('project', 'project_unique', 'on'=>'create'),
			array('is_group_create', 'groupadd', 'on'=>'create'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'project'=>'Название проекта',
			'owner'=>'владелец',
			'group'=>'группа',
			'description'=>'описание',
			'is_group_create'=>'создать группу проекта'
		);
	}

	public function create()
	{
	}

	public function edit()
	{

	}

	public function ownerList()
	{
		$owner_list = array();
		$pwdfile = fopen('/etc/passwd','r');
		if ($pwdfile) {
			while (!feof($pwdfile)) {
				$entry = explode (':', fgets($pwdfile, 512));
				if (count($entry)>2) {
					if ($entry[2]>= Yii::app()->params['min_uid']) array_push($owner_list, array($entry[0]=>$entry[0]));
				}
			}
			fclose($pwdfile);
		}
		return $owner_list;
	}

	public function groupList()
	{
		$group_list = array();
		$groupfile = fopen('/etc/group','r');
		if ($groupfile) {
			while (!feof($groupfile)) {
				$entry = explode (':', fgets($groupfile, 512));
				if (count($entry)>2) {
					if ($entry[2]>= Yii::app()->params['min_gid']) array_push($group_list, array($entry[0]=>$entry[0]));
				}
			}
			fclose($groupfile);
			if ($this->is_group_create) array_push($group_list, array('git_'.$this->project=>'git_'.$this->project));
			if (array_search('users', $group_list)===FALSE) array_push($group_list, array('users'=>'users'));
		}
		return $group_list;
	}
	
	public function project_unique()
	{
		if(!$this->hasErrors())
		{
			$repolist = scandir(Yii::app()->params['gitsrv_root']);
			if (array_search($this->project, $repolist)===FALSE) {
			} else {
				$this->addError('project', 'Название проекта должно быть уникальным');
			}
		}
	}
	
	public function groupadd()
	{
		$this->group = $this->is_group_create ? 'git_'.$this->project:$this->group;
	}
	
	public function groupexists($group)
	{
		if (posix_getgrnam($group)===FALSE) {
			return FALSE;			
		} else {
			return TRUE;
		}
	}
}