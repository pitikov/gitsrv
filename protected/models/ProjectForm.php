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
			array('project', 'match', 'pattern'=>'/^([a-z,A-Z][a-z,A-Z,0-9,_]+)$/'),
			array('project', 'length', 'min'=>4, 'max'=>32),

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

	public function ownerList()
	{
		$owner_list = array();
		$pwdfile = fopen('/etc/passwd','r');
		if ($pwdfile) {
			while (!feof($pwdfile)) {
				$entry = explode (':', fgets($pwdfile, 512));
				if (count($entry)>2) {
					if ($entry[2]>= Yii::app()->params['min_uid']) array_push($owner_list, $entry[0]);
				}
			}
			fclose($pwdfile);
		}
		if (!in_array(Yii::app()->user->name, $owner_list, true)) array_push($owner_list, Yii::app()->user->name);
		return array_combine($owner_list, $owner_list);
	}

	public function groupList()
	{
		$group_list = array();
		$groupfile = fopen('/etc/group','r');
		if ($groupfile) {
			while (!feof($groupfile)) {
				$entry = explode (':', fgets($groupfile, 512));
				if (count($entry)>2) {
					if ($entry[2]>= Yii::app()->params['min_gid']) array_push($group_list, $entry[0]);
				}
			}
			fclose($groupfile);
			if ($this->is_group_create) array_push($group_list, 'git_'.$this->project);
		}
		$usergroup = trim(posix_getgrgid(posix_getpwuid(Yii::app()->user->getId())['gid'])['name']);
		if (!in_array($usergroup, $group_list, true)) array_push($group_list, $usergroup);
		if (!in_array($this->group, $group_list, true)) array_push($group_list, $this->group);
		return array_combine($group_list, $group_list);

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