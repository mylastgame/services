<?php

class ModelController extends ToController
{		
	public function actionUpdate($id){      
      $model = CarModel::model()->with('CarMark')->findByPk($id);            
      if(!$model)
         throw new CHttpException(404, 'Not found');      
      if(isset($_POST['CarModel'])){
         $model->attributes = $_POST['CarModel'];
         if($model->save())
            $this->redirect('/to/mark/'.$model->CarMark->id);
      }      
                  
      $this->render('application.views.to.model.model', array('model'=>$model, 'mark'=>$model->CarMark));
   }
   
   public function actionDelete($id){
      $model=CarModel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
      if(Yii::app()->request->isPostRequest){
         $model->delete();
      } else
         throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
   }
   
   public function actionCreate($id){      
      $mark = CarMark::model()->findByPk($id);            
      if(!$mark)
         throw new CHttpException(404, 'Not found'); 
      
      $model = new CarModel;                  
      if(isset($_POST['CarModel'])){
         $model->attributes = $_POST['CarModel'];
         $model->mark_id = $mark->id;
         if($model->save())
            $this->redirect('/to/mark/'.$mark->id);
      }      
                  
      $this->render('application.views.to.model.model', array('model'=>$model, 'mark'=>$mark));
   }
   
   public function actionView($id){
      $model=CarModel::model()->with('CarMark')->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
      
      $mods = new CActiveDataProvider('CarMod', array(
          'criteria'=>array('condition'=>'model_id=:model_id', 'params'=>array(':model_id'=>$model->id)),
          'sort' => array('defaultOrder'=>'name ASC'),
          'pagination' => array('pageSize' => 10)
      ));
      
		$this->render('application.views.to.model.mods', array('mark'=>$model->CarMark, 'model'=>$model, 'mods'=>$mods));
   }
}
