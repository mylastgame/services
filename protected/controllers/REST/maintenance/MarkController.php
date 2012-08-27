<?php
class MarkController extends RestController
{
   public function filters()
   {
      return array();
   }
   //Actions
   public function actionList()
   {          
      $marks = CarMark::model()->carBrand()->findAll();      
      
      if(empty($marks)){
         $this->_sendResponse(200, 'No items for model');         
      } else {
         $data = array();
         foreach($marks as $mark)
            $data[] = $mark->attributes;
         $this->_sendResponse(200, $this->_formatResponse($data), 'text/html'); 
      }
   }   
   
   public function actionView($markId)
   {     
      $mark = CarMark::model()->carBrand()->findByPk($markId);      
      if(empty($mark))
         $this->_sendResponse(404, sprintf('Mark with ID: %d doesn\'t exists', $markId));
     
      $this->_sendResponse(200, $this->_formatResponse($mark->attributes), 'text/html');
   }         
}
?>