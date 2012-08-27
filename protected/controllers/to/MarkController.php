<?php
class MarkController extends ToController
{	            
	public function actionIndex(){            
      $marks = new CActiveDataProvider('CarMark', array(
          'sort' => array('defaultOrder'=>'name ASC'),
          'pagination' => array('pageSize' => 10)
      ));      
      $this->render('application.views.to.mark.index', array('marks'=>$marks, 'test'=>'test'));      
   }
   
   public function actionUpdate($id){      
      $mark = CarMark::model()->with('Image')->findByPk($id);            
      $image = $mark->Image ? $mark->Image : new Image;
      
      if(!$mark)
         throw new CHttpException(404, 'Not found');      
      if(isset($_POST['CarMark'])){
         $mark->attributes = $_POST['CarMark'];
         if(isset($_POST['Image']) && $uploadedFile = CUploadedFile::getInstance($image, 'name')){                        
            if($uploadedFile && !$uploadedFile->getHasError()){
               $fileName = $uploadedFile->getName();               
               $oldName = $image->name;
               $image->name = $fileName;
               if($image->save()){
                  if(!empty($oldName))
                     unlink(Yii::app()->basePath.'/../images/'.$oldName);
                  $uploadedFile->saveAs(Yii::app()->basePath.'/../images/'.$fileName);
                  $mark->image_id = $image->id;
               }   
            } else {
               $image->addError('name', $uploadedFile->getError());
            }                       
         } 
         if($mark->save() && (!isset($_POST['Image']) || !$image->hasErrors()))              
            $this->redirect('/to');
      }                  
                  
      $this->render('application.views.to.mark.mark', array('mark'=>$mark, 'image'=>$image));
   }
   
   public function actionDelete($id){
      if(Yii::app()->request->isPostRequest){
         $this->loadModel($id)->delete();
      } else
         throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
   }
   
   public function actionCreate(){
      $mark = new CarMark;
      $image = new Image;
      if(isset($_POST['CarMark'])){         
         $mark->attributes = $_POST['CarMark'];
         if(isset($_POST['Image'])){
            $image->attributes = $_POST['Image'];
            $uploadedFile = CUploadedFile::getInstance($image, 'name');            
            if(!$uploadedFile->getHasError()){
               $fileName = $uploadedFile->getName();
               $image->name = $fileName;            
               if($image->save()){
                  $uploadedFile->saveAs(Yii::app()->basePath.'/../images/'.$fileName);
                  $mark->image_id = $image->id;
               }   
            } else {
               $image->addError('name', $uploadedFile->getError());
            }                       
         }         
         if($mark->save() && (!isset($_POST['Image']) || !$image->hasErrors()))              
            $this->redirect('/to');
      }                  
      $this->render('application.views.to.mark.mark', array('mark'=>$mark, 'image'=>$image));
   }
        
   public function actionView($id){
      $mark=CarMark::model()->findByPk($id);
		if($mark===null)
			throw new CHttpException(404,'Марка не найдена');
      
      $models = new CActiveDataProvider('CarModel', array(
          'criteria'=>array('condition'=>'mark_id=:mark_id', 'params'=>array(':mark_id'=>$mark->id)),
          'sort' => array('defaultOrder'=>'name ASC'),
          'pagination' => array('pageSize' => 10)
      ));
      
		$this->render('application.views.to.mark.models', array('mark'=>$mark, 'models'=>$models));
   }
   
   protected function loadModel($id)
	{
		$model=CarMark::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
