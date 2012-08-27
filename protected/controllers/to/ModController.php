<?php

class ModController extends ToController
{	
	public function actionUpdate($id){      
      $mod = CarMod::model()->with('CarModel.CarMark')->findByPk($id);            
      if(!$mod)
         throw new CHttpException(404, 'Not found');      
      if(isset($_POST['CarMod'])){
         $mod->attributes = $_POST['CarMod'];
         if($mod->save())
            $this->redirect('/to/model/'.$mod->CarModel->id);
      }      
                  
      $this->render('application.views.to.mod.mod', array('mod'=>$mod, 'mark'=>$mod->CarModel->CarMark, 'model'=>$mod->CarModel));
   }
   
   public function actionDelete($id){
      $mod=CarMod::model()->findByPk($id);
		if($mod===null)
			throw new CHttpException(404,'The requested page does not exist.');
      if(Yii::app()->request->isPostRequest){
         $mod->delete();
      } else
         throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
   }
   
   public function actionCreate($id){      
      $model = CarModel::model()->with('CarMark')->findByPk($id);            
      if(!$model)
         throw new CHttpException(404, 'Not found'); 
      
      $mod = new CarMod;                  
      if(isset($_POST['CarMod'])){
         $mod->attributes = $_POST['CarMod'];
         $mod->model_id = $model->id;
         if($mod->save())
            $this->redirect('/to/model/'.$model->id);
      }      
                  
      $this->render('application.views.to.mod.mod', array('mod'=>$mod, 'mark'=>$model->CarMark, 'model'=>$model));
   }
   
   public function actionView($id, $maintenance_order = false){
      $maintenance=CarMaintenance1::model()->with(array('CarModel', 'CarMark', 'CarMod'))->findByPk($id);
		if($maintenance===null){
         $mod=CarMod::model()->with(array('CarModel.CarMark'))->findByPk($id);
         if($mod===null)
            throw new CHttpException(404,'The requested page does not exist.');
         $maintenance = new CarMaintenance1;
         $maintenance->mod_id = $mod->id;
         $maintenance->model_id = $mod->CarModel->id;
         $maintenance->mark_id = $mod->CarModel->CarMark->id;
         $maintenance->save();
      }
      
      $maintenance_order = $maintenance_order ? $maintenance_order : 1;
      
      $criteria = new CDBCriteria;
      $criteria->condition = 'maintenance_id=:id AND maintenance_order=:order';            
      $criteria->params = array(':id'=>$maintenance->id, ':order'=>$maintenance_order);
      $criteria->with = 'CarPart';
      $parts = new CActiveDataProvider('MaintenancePart', array(
          'criteria'=>$criteria,
          'sort' => array('defaultOrder'=>'name ASC'),
          'pagination' => array('pageSize' => 100)
      ));      
      
      $criteria = new CDBCriteria;
      $criteria->condition = 'maintenance_id=:id AND maintenance_order=\'all\'';            
      $criteria->params = array(':id'=>$maintenance->id);
      $criteria->with = 'CarPart';
      $parts_all = new CActiveDataProvider('MaintenancePart', array(
          'criteria'=>$criteria,
          'sort' => array('defaultOrder'=>'name ASC'),
          'pagination' => array('pageSize' => 100)
      ));
            
      $this->render('application.views.to.mod.maintenance', array(
         'maintenance'=>$maintenance,
         'maintenance_json'=>CJSON::encode($maintenance),
         'parts'=>$parts,
         'parts_all'=>$parts_all,
         'maintenance_order'=>$maintenance_order,
         'maintenance_order_json'=>CJSON::encode($maintenance_order)
      ));
   }
}
