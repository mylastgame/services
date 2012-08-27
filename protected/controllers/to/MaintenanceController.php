<?php

class MaintenanceController extends ToController
{	
	public function actionUpdate($id){
      $mod=CarMod::model()->with(array('CarMaintenance1', 'CarModel.CarMark'))->findByPk($id);
		if($mod===null)
			throw new CHttpException(404,'The requested page does not exist.');     
      
      if(Yii::app()->request->isPostRequest){
         $maintenance = $mod->CarMaintenance1 ? $mod->CarMaintenance1 : new CarMaintenance1;
         $maintenance->attributes = $_POST['CarMaintenance1'];         
         $maintenance->mod_id = $mod->id;
         $maintenance->model_id = $mod->CarModel->id;
         $maintenance->mark_id = $mod->CarModel->CarMark->id;
         if($maintenance->save())
            $this->redirect('/to/mod/'.$maintenance->id);            
      }
      
      $this->render('application.views.to.maintenance.update', array('maintenance'=>$mod->CarMaintenance1));
   }      
   
   public function actionPartCreate($id, $maintenance_order){
      $maintenance=CarMaintenance1::model()->with(array('CarModel','CarMark','CarMod', 'MaintenancePart.CarPart'))->findByPk($id);
		if($maintenance===null || $maintenance_order != 'all' && $maintenance->number < $maintenance_order)
			throw new CHttpException(404,'The requested page does not exist.');     

      $maintenancePart = new MaintenancePart;
      $maintenancePart->maintenance_id = $maintenance->id;
      $maintenancePart->maintenance_order = $maintenance_order;
      $part = new CarPart;
      
      if(Yii::app()->request->isPostRequest){        
         $maintenancePart->amount =  $_POST['MaintenancePart']['amount'];
         $maintenancePart->comment = $_POST['MaintenancePart']['comment'];         
         $maintenancePart->validate(array('amount', 'comment'));         
                  
         $part->attributes = $_POST['CarPart'];        
         
         if($part->validate(array('article', 'name'))){            
            $p = CarPart::model()->findByAttributes(array('article'=>$part->article, 'name'=>$part->name));                              
            $p == false? $part->addError('id', 'Запчасть не найдена') : $part = $p;                           
         } else            
            $part->addError('id', 'Запчасть не найдена');         
                  
         
         $orders = explode(',', $_POST['MaintenancePart']['maintenance_order']);
         $a = array();
         for($i=1; $i<=$maintenance->number; $i++)
            $a[] = $i;
         $a[] = 'all';
         foreach($orders as $o){                        
            if(!in_array($o, $a)){               
               $maintenancePart->addError('maintenance_order', 'Не правильный формат номера ТО');
               break;
            }               
         }
         
         if(!$maintenancePart->hasErrors() && !$part->hasErrors()){
            $c = new CDBCriteria;
            $c->condition = 'maintenance_id=:maintenance_id AND part_id=:part_id';
            $c->params = array(':maintenance_id'=>$maintenancePart->maintenance_id,':part_id'=>$part->id);
            $maintenancePart->deleteAll($c);                        
            
            foreach($orders as $order){               
               $mp = new MaintenancePart;                                           
               $mp->attributes = $maintenancePart->attributes;               
               $mp->comment = $maintenancePart->comment;               
               $mp->maintenance_order = $order;  
               $mp->part_id = $part->id;
               $mp->save();                              
            }            
            $this->redirect('/to/mod/'.$maintenance->id);
         }                              
            
      }
                              
      $this->render('application.views.to.maintenance.part', array('maintenance'=>$maintenance, 'maintenancePart'=>$maintenancePart, 'part'=>$part));      
   }
   
   public function actionPartDelete($id, $maintenance_order){      
      $maintenance=CarMaintenance1::model()->with(array('CarModel','CarMark','CarMod'))->findByPk($id);
		if($maintenance===null || $maintenance_order != 'all' && $maintenance->number < $maintenance_order)
			throw new CHttpException(404,'The requested page does not exist.');     
      
      if(Yii::app()->request->isPostRequest){         
         if($_POST['part_id'] && is_numeric($_POST['part_id'])){
            $c = new CDbCriteria;
            $c->condition = 'part_id=:part_id AND maintenance_id=:maintenance_id';
            $c->params = array(':part_id'=>$_POST['part_id'], ':maintenance_id'=>$maintenance->id);            
            echo $_POST['all'];
            if($_POST['all'] != 'all'){               
               $c->addCondition('maintenance_order=:maintenance_order');
               $c->params[':maintenance_order']=$maintenance_order;
            }
            
            $parts = MaintenancePart::model()->findAll($c);            
            foreach($parts as $part)
               $part->delete();
            
            echo 'success';            
         }
      }
      Yii::app()->end();
   }
   
   public function actionPartEdit($id, $part_id){
      $maintenance=CarMaintenance1::model()->with(array('CarModel','CarMark','CarMod'))->findByPk($id);
		if(!$maintenance)
			throw new CHttpException(404,'The requested page does not exist.');     

      $maintenancePart = MaintenancePart::model()->with('CarPart')->findByAttributes(array('maintenance_id'=>$maintenance->id, 'part_id'=>$part_id));
      if(!$maintenancePart)
         throw new CHttpException(404,'The requested page does not exist.');  
                  
      $orders = Yii::app()->db->createCommand()
              ->select('maintenance_order')
              ->from('maintenance_part')
              ->where('maintenance_id = :maintenance_id AND part_id=:part_id', array(':maintenance_id'=>$maintenance->id, ':part_id'=>$part_id))              
              ->queryAll();      
     
      $data = array();
      foreach($orders as $o)
         $data[] =  $o['maintenance_order'];         
      $maintenancePart->maintenance_order = implode(',', $data);                          
      $part = $maintenancePart->CarPart;
      
      if(Yii::app()->request->isPostRequest){        
         $maintenancePart->amount =  $_POST['MaintenancePart']['amount'];
         $maintenancePart->comment = $_POST['MaintenancePart']['comment'];         
         $maintenancePart->validate(array('amount', 'comment'));         
                  
         $part->attributes = $_POST['CarPart'];        
         
         if($part->validate(array('article', 'name'))){            
            $p = CarPart::model()->findByAttributes(array('article'=>$part->article, 'name'=>$part->name));                              
            $p == false? $part->addError('id', 'Запчасть не найдена') : $part = $p;                           
         } else            
            $part->addError('id', 'Запчасть не найдена');         
                  
         
         $orders = explode(',', $_POST['MaintenancePart']['maintenance_order']);
         $a = array();
         for($i=1; $i<=$maintenance->number; $i++)
            $a[] = $i;
         $a[] = 'all';
         foreach($orders as $o){                        
            if(!in_array($o, $a)){               
               $maintenancePart->addError('maintenance_order', 'Не правильный формат номера ТО');
               break;
            }               
         }
         
         if(!$maintenancePart->hasErrors() && !$part->hasErrors()){
            $c = new CDBCriteria;
            $c->condition = 'maintenance_id=:maintenance_id AND part_id=:part_id';
            $c->params = array(':maintenance_id'=>$maintenancePart->maintenance_id,':part_id'=>$part->id);
            $maintenancePart->deleteAll($c);                        
            
            foreach($orders as $order){               
               $mp = new MaintenancePart;                                           
               $mp->attributes = $maintenancePart->attributes;               
               $mp->comment = $maintenancePart->comment;               
               $mp->maintenance_order = $order;  
               $mp->part_id = $part->id;
               $mp->save();                              
            }            
            $this->redirect('/to/mod/'.$maintenance->id);
         }                              
            
      }
                              
      $this->render('application.views.to.maintenance.part', array('maintenance'=>$maintenance, 'maintenancePart'=>$maintenancePart, 'part'=>$maintenancePart->CarPart));                         
   }
}
