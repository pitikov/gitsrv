<?php


class GroupCtrlColumn extends CDataColumn {
  protected function renderDataCellContent($row, $data)
  {
			echo CHtml::link('<img src="/images/delete.png" title="удалить группу"/>', Yii::app()->createUrl('/developer/deleteGroup', array('group'=>$data['id'])), array('confirm'=>'Удалить группу '.$data['id'].'?'));
  }
}