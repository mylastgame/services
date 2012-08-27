<?php
class MaintenancePartsSoapServer 
{   
   public function getMarks(){                
      $data = array();
      $marks = CarMark::model()->with('Image')->carBrand()->findAll();
      
      if(empty($marks))
         return new SoapFault('Server', 'Marks not found');
      
      foreach($marks as $mark)
         $data[] = array('id'=>$mark->id, 'name'=>$mark->name, 'image'=>$mark->Image->name);
      
      return $data;
   }
   
   public function getMark($mark_id){            
      $mark = CarMark::model()->carBrand()->findByPk($mark_id);            
      if(!$mark)
         return new SoapFault ('Client', 'Mark with specified id doesnt exist');
      return $mark->attributes;
   }
   
   public function getModels($mark_id){      
      $data = array();
      $models = CarModel::model()->findAllByAttributes(array('mark_id'=>$mark_id));
      
      if(empty($models))
         return new SoapFault ('Client', 'Models of specified mark doesnt exist');
      
      foreach($models as $model)
         $data[] = $model->attributes;
         
      return $data;
   }
   
   public function getModel($id){            
      $item = CarModel::model()->findByPk($id);            
      if(!$item)
         return new SoapFault ('Client', 'Model with specified id doesnt exist');
      return $item->attributes;
   }
   
   public function getMods($model_id){
      $data = array();
      $mods = CarMod::model()->findAllByAttributes(array('model_id'=>$model_id));
      foreach($mods as $mod)
         $data[] = $mod->attributes;
      
      return $data;
   }
   
   public function getMod($id){            
      $item = CarMod::model()->findByPk($id);            
      if(!$item)
         return new SoapFault ('Client', 'Modification with specified id doesnt exist');
      return $item->attributes;
   }
   
   public function getMaintenance($mod_id){            
      $item = CarMaintenance1::model()->findByAttributes(array('mod_id'=>$mod_id));            
      if(!$item)
         return new SoapFault ('Server', 'Maintenance with specified id doesnt exist');
      return $item->attributes;
   }
   
   public function getParts($maintenance_id, $order){            
      $items = MaintenancePart::model()->with('CarPart')->findAllByAttributes(array('maintenance_id'=>$maintenance_id, 'maintenance_order'=>$order));                  
      if(!$items)
         return new SoapFault ('Client', 'Parts with specified id doesnt exist');
      $data = array();
      foreach ($items as $item)
         $data[] = array('name'=>$item->CarPart->name, 'article'=>$item->CarPart->article, 'comment'=>$item->comment, 'amount'=>$item->amount);
      return $data;
   }
}

?>
