<?php
class ModController extends RestController
{
   public function filters()
   {
      return array();
   }
   //Actions
   public function actionList($modelId)
   {      
      $mods = CarMod::model()->findAllByAttributes(array('model_id' => $modelId));
      if($mods == null) 
         $this->_sendResponse(404, sprintf('Model with ID: %d doesn\'t exists', $modelId));
            
      foreach($mods as $mod)
         $data[] = $mod->attributes;
      $this->_sendResponse(200, $this->_formatResponse($data), 'text/html');       
   }
   
   public function actionView($modId)
   {     
      $mod = CarMod::model()->findByPk($modId);      
      if(empty($mod))
         $this->_sendResponse(404, sprintf('Mod with ID: %d doesn\'t exists', $modId));
     
      $this->_sendResponse(200, $this->_formatResponse($mod->attributes), 'text/html'); 
   } 
}

?>
