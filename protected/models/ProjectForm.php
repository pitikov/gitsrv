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
}