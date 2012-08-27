<?php
class ModelController extends RestController
{
   public function filters()
   {
      return array();
   }
   //Actions
   public function actionList($markId)
   {      
      $models = CarModel::model()->findAllByAttributes(array('mark_id' => $markId));
      if($models == null) 
         $this->_sendResponse(404, sprintf('Mark with ID: %d doesn\'t exists', $markId));
            
      foreach($models as $model)
         $data[] = $model->attributes;
      $this->_sendResponse(200, $this->_formatResponse($data), 'text/html');       
   }
   
   public function actionView($modelId)
   {     
      $model = CarModel::model()->findByPk($modelId);      
      if(empty($model))
         $this->_sendResponse(404, sprintf('Model with ID: %d doesn\'t exists', $modelId));
     
      $this->_sendResponse(200, $this->_formatResponse($model->attributes), 'text/html'); 
   } 
}

?>
