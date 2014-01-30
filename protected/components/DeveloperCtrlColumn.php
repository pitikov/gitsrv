<?php


class DeveloperCtrlColumn extends CDataColumn {
  protected function renderDataCellContent($row, $data)
  {
			echo CHtml::link('<img src="/images/delete.png" title="удалить учетную запись"/>', Yii::app()->createUrl('/developer/deleteDeveloper', array('login'=>$data['id'])), array('confirm'=>'Удалить учетную запись '.$data['id'].'?'));
  }
}