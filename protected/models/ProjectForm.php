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
			//array('is_group_create', 'bool'),
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
		}
		return $group_list;
	}

}