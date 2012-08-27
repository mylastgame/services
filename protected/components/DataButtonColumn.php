<?php
Yii::import('bootstrap.widgets.BootButtonColumn');
class DataButtonColumn extends BootButtonColumn{
   protected function renderButton($id,$button,$row,$data)
	{
      if(isset($button['options']['data'])){
         foreach($button['options']['data'] as $k=>$v)
            $button['options'][$k] = $data->CarPart->$v;
         unset($button['options']['data']);
      }
      parent::renderButton($id, $button, $row, $data);
	}   
}

?>
