<?php
class MaintenanceController extends RestController 
{
   public function actionCount($modId){
      /* use old model CarMaintenance
      $criteria = new CDbCriteria;
      $criteria->select = array('mark_id', 'model_id', 'mod_id', 'maintenance_order', 'distance');
      $criteria->distinct = true;
      $criteria->condition = 'mod_id=:mod_id AND maintenance_order != \'all\'';
      $criteria->params = array(':mod_id' => $modId);      
      $criteria->order = 'abs(maintenance_order)';
      $data = CarMaintenance::model()->findAll($criteria);              
      if($data == null)
         $this->_sendResponse(404, sprintf('Modification %d doesn\'t have maintenances!', $modId));      
      
      $this->_sendResponse(200, $this->_formatResponse($data), 'text/html'); 
      */
      
      $maintenance = CarMaintenance1::model()->findByAttributes(array('mod_id' => $modId));      
      if($maintenance == null)
         $this->_sendResponse(404, sprintf('Modification %d doesn\'t have maintenances!', $modId));      
      
      $data = array();
      for($i=1; $i <= $maintenance->number; $i++){                  
         $d = array();
         $d['mark_id'] = $maintenance['mark_id'];
         $d['model_id'] = $maintenance['model_id'];
         $d['mod_id'] = $maintenance['mod_id'];
         $d['maintenance_order'] = $i;
         $d['distance'] = $i*$maintenance['maintenance_interval'];
         $data[] = $d;
      }       
      if(empty($data))         
         $this->_sendResponse(404, sprintf('Modification %d doesn\'t have maintenances!', $modId));          
      $this->_sendResponse(200, $this->_formatResponse($data), 'text/html'); 
      
      
   }
   
   public function actionView($modId, $maintOrder){   
      /* use old model CarMaintenance
      $data = CarMaintenance::model()->with(array('CarPart' => array('select' => 'name, article')))->findAllByAttributes(array('mod_id' => $modId, 'maintenance_order' => $maintOrder),
              array('select' => 'amount, comment'));            
      if($data == null)
         $this->_sendResponse(404, sprintf('Modification %d doesn\'t have maintenances!', $modId));      
      $rdata = array();
      foreach($data as $k=>$v){ $rdata[] = array_merge($data[$k]->attributes, $v->CarPart->attributes); }      
      $this->_sendResponse(200, $this->_formatResponse($rdata), 'text/html'); 
      */
      
      $maintenance = CarMaintenance1::model()->findByAttributes(array('mod_id' => $modId));
      if($maintenance == null)
         $this->_sendResponse(404, sprintf('Modification %d doesn\'t have maintenances!', $modId));
      
      $maintenanceParts = MaintenancePart::model()->with(array('CarPart'=>array('select'=>'name, article')))
              ->findAllByAttributes(array('maintenance_id'=>$maintenance->id, 'maintenance_order'=>$maintOrder),array('select'=>'amount, comment'));
      if($maintenanceParts == null)
         $this->_sendResponse(404, sprintf('Modification %d doesn\'t have maintenances!', $modId));
      
      $rdata = array();
      foreach($maintenanceParts as $k=>$v)
         $rdata[] = array_merge($maintenanceParts[$k]->attributes, $v->CarPart->attributes); 
      
      $this->_sendResponse(200, $this->_formatResponse($rdata), 'text/html');
   }
}

?>
