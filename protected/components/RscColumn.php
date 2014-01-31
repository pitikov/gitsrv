<?php

class RscColumn extends CDataColumn {

  protected function renderDataCellContent($row, $data)
  {
		echo CHtml::link($data['id'], "/ressource/{$data['id']}", array('project'=>$data['id']), array('title'=>'Загрузить файл '.$data['id']));
  }
  
}
