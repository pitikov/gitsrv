<?php

class ProjectCtrlColumn extends CDataColumn {
  protected function renderDataCellContent($row, $data)
  {
		if ($this->isEditAccess($data['owner'], $data['group'])) {
			echo CHtml::link('<img src="/images/edit.png" title="редактировать свойства проекта"/>', Yii::app()->createUrl('/project/edit', array('project'=>$data['id'])));
		}
		if ($this->isDeleteAccess($data['owner'])) {
			echo CHtml::link('<img src="/images/delete.png" title="удалить проект"/>', Yii::app()->createUrl('/project/delete', array('project'=>$data['id'])), array('confirm'=>'Удалить репозиторий проекта '.$data['id'].'?'));
		}
  }

  private function isEditAccess($owner, $group)
  {
		$retcode = $this->isDeleteAccess($owner);
		if (posix_getgrgid(posix_getpwnam(Yii::app()->user->name)['gid'])['name'] == $group) $retcode = TRUE;
		if (array_search($owner, posix_getgrnam($group)['members'])) $retcode = TRUE;
		return $retcode;
  }

  private function isDeleteAccess($owner)
  {
		$retcode = FALSE;
  	if ( Yii::app()->user->getId() == 0 ) $retcode = TRUE;
  	if ( $owner == Yii::app()->user->name ) $retcode = TRUE;

		return $retcode;
  }
}
