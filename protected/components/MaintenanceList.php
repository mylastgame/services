<?php
class MaintenanceList extends CWidget
{
   public $maintenance;
   public $maintenance_order;
         
   public function run(){            
      $buttons = array();
      for($i=1; $i<=$this->maintenance->number; $i++){                                      
         $htmlOptions = $this->maintenance_order == $i ? array('class'=>'active') : array();
         $buttons[] = array('label'=>$i, 'url'=>'/to/mod/'.$this->maintenance->id.'/order/'.$i, 'htmlOptions'=>$htmlOptions);
      }
      echo '<div style="margin:10px 0"><span style="vertical-align:8px;padding-right:5px">№ ТО:</span>';
      $this->widget('bootstrap.widgets.BootButtonGroup', array(
         'buttons'=>$buttons,         
         'toggle' => 'radio',
         'htmlOptions'=>array('class'=>'inline-block')
      ));
      echo '</div>';
   }  
}
?>
