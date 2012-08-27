<?php
class SoapController extends CController
{      
   private $_ips = array(
       '192.168.56.1',
       '127.0.0.1',
       '192.168.56.101'
   );
   
   public function filters(){
      return array(
          'accessControl'
      );
   }
     
   public function accessRules(){
      return array(
          array('allow', 'users'=>array('*'), 'ips'=>$this->_ips),
          array('deny', 'message'=>'Необходима авторизация', 'users'=>array('*'))
      );
   }
   
   public function actionMaintenanceParts(){
      $server = new SoapServer(Yii::app()->basePath.'/../wsdl/maintenanceParts.wsdl');
      Yii::import('application.components.soap.MaintenancePartsSoapServer');
      $server->setClass('MaintenancePartsSoapServer');
      $server->handle();
   }        
}

?>
