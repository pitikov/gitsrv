<?php

class GroupForm extends CFormModel
{
	public $group;
	public $memberlist;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('group', 'required'),
			array('group', 'groupunique'),
			array('memberlist', 'memberlist_not_empty'),
			array('group', 'match', 'pattern'=>'/^([a-z,A-Z][a-z,A-Z,0-9]+)$/'),
			array('group', 'length', 'min'=>3, 'max'=>24),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'group'=>'Название группы',
			'memberlist'=>'Список членов группы',
		);
	}
	
	public function groupunique()
	{
		if (!(posix_getgrnam($this->group)) === FALSE) {
			$this->addError($this->group, $this->attributeLabels()['group'].' должно быть уникальным');
		}
	}
	
	public function memberlist_not_empty()
	{
		$is_empty = TRUE;
		if (isset( $this->memberlist) ) {
			if (count ($this->memberlist) >0 ) {
				foreach(array_keys($this->memberlist) as $key) {
					if (isset($this->memberlist[$key])) {
						if ($this->memberlist[$key]==TRUE) $is_empty = FALSE;
					}
				}
			}
		}
		if ($is_empty) $this->addError($this->group, $this->attributeLabels()['memberlist'].' не может быть пустым');
	}
}
