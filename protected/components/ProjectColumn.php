<?php

class ProjectColumn extends CDataColumn {

  protected function renderDataCellContent($row, $data)
  {
		echo CHtml::link($data['id'], Yii::app()->createUrl('/project/webgit', array('project'=>$data['id'])), array('title'=>'Просмотр репозитория проекта '.$data['id']));
  }
  
}
