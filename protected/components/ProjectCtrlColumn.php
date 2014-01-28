<?php

class ProjectCtrlColumn extends CDataColumn {

  protected function renderDataCellContent($row, $data)
  {
		echo /*CHtml::link('view', Yii::app()->createUrl('/project/view', array('project'=>$data['id'])))*/ CHtml::link('edit', Yii::app()->createUrl('/project/edit', array('project'=>$data['id']))).' '.CHtml::link('del', Yii::app()->createUrl('/project/delete', array('project'=>$data['id'])), array('confirm'=>'Удалить репозиторий проекта '.$data['id'].'?'));
  }
  
}
