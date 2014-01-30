<?php

class DeveloperColumn extends CDataColumn {

  protected function renderDataCellContent($row, $data)
  {
		if ($data['uid']>=Yii::app()->params['min_uid']) echo CHtml::link($data['id'], Yii::app()->createUrl('/developer/editDeveloper', array('login'=>$data['id'])), array('title'=>'Редактировать учетную запись '.$data['id']));
		else echo $data['id'];
  }
  
}
