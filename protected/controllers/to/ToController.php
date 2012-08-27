<?php
class ToController extends Controller
{
   public $layout = 'layout';
   public $navbar = array(
         array('label'=>'Главная', 'url'=>'/#'),
         array('label'=>'Запчасти для ТО', 'url'=>'#', 'active'=>true, 'items'=>array(
            array('label'=>'Автомобили и ТО' , 'url'=>'/to', 'active'=>true),
            array('label'=>'Запчасти', 'url'=>'/to/part')
         ))
      );   
   
   public function filters(){
      return array(
          'accessControl'
      );
   }
     
   public function accessRules(){
      return array(
          array('allow', 'users'=>array('admin', 'partsManager'), 'message'=>'Необходима авторизация'),
          array('deny', 'message'=>'Необходима авторизация', 'users'=>array('*'))
      );
   }
}

?>
