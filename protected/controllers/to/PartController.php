<?php
class PartController extends Controller
{
   public $layout = 'layout';
   public $navbar = array(
         array('label'=>'Главная', 'url'=>'/#'),
         array('label'=>'Запчасти для ТО', 'url'=>'#', 'active'=>true, 'items'=>array(
            array('label'=>'Автомобили и ТО', 'url'=>'/to'),
            array('label'=>'Запчасти', 'url'=>'/to/part', 'active'=>true)
         ))
      );
   
   public function filters(){
      return array('accessControl');
   }
   
   public function accessRules(){
      return array(
          array('allow', 'users'=>array('admin', 'partsManager'), 'message'=>'Необходима авторизация'),
          array('deny', 'users'=>array('*'), 'message'=>'Необходима авторизация')
      );
   }
   
   public function actionIndex(){
      $parts_model = new CarPart('search');
      $parts_model->unsetAttributes();    
      if(isset($_GET['CarPart']))
         $parts_model->attributes = $_GET['CarPart'];
      
      $marks_data = CarMark::model()->partBrand()->findAll();
      $marks = array();
      foreach ($marks_data as $mark)
         $marks[$mark->id] = $mark->name;
            
      $this->render('application.views.to.part.index', array('model'=>$parts_model, 'marks'=>$marks));
   }
   
   public function actionCreate(){
      $part = new CarPart;        
      $marks_data = CarMark::model()->partBrand()->findAll();
      $marks = array();
      foreach ($marks_data as $mark)
         $marks[$mark->id] = $mark->name;
         
      if(Yii::app()->request->isPostRequest){
         $part->attributes = $_POST['CarPart'];
         if($part->save())
            $this->redirect('/to/part');
      }      
      $this->render('application.views.to.part.part', array('part'=>$part, 'marks'=>$marks));        
   }
   
   public function actionUpdate($id){
      $part = CarPart::model()->findByPk($id);      
      if(!$part)
         throw new CHttpException(404, 'Not found'); 
      
      $marks_data = CarMark::model()->partBrand()->findAll();
      $marks = array();
      foreach ($marks_data as $mark)
         $marks[$mark->id] = $mark->name;
      
      if(Yii::app()->request->isPostRequest){
         $part->attributes = $_POST['CarPart'];
         if($part->save())
            $this->redirect('/to/part');
      }
      
      $this->render('application.views.to.part.part', array('part'=>$part, 'marks'=>$marks));        
   }
   
   public function actionDelete($id){
      if(Yii::app()->request->isPostRequest){
         $part = CarPart::model()->findByPk($id);
         if(!$part)
            throw new CHttpException(404, 'Not found'); 
         else
            $part->delete();
      } else
         throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
   }
   
   public function actionFindByname(){
      if(!Yii::app()->request->isPostRequest || !$_POST['data'])
         throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
      
      $part = new CarPart;
      $part->name = $_POST['data'];
      if(!$part->validate(array('name'))){         
         echo CJSON::encode(array(0=>array('')));
         Yii::app()->end();
      }
      
      $str = strtr($part->name, array('%'=>'\%', '_'=>'\_'));
        
      
      $parts = Yii::app()->db->createCommand()
              ->select('*')
              ->from('car_part')
              ->where(array('like', 'name', '%'.$str.'%'))
              ->queryAll();
      
      $data = array();
      foreach($parts as $p)
            $data[] = array('part'=>$p['article'].','.$p['name'], 'id'=>$p['id']);      
      
      echo CJSON::encode(array(
          'source'=>$data
      ));
      
      Yii::app()->end();
   }
   
   public function actionFindByArticle(){
      if(!Yii::app()->request->isPostRequest || !$_POST['data'])
         throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
      
      $part = new CarPart;
      $part->article = $_POST['data'];
      if(!$part->validate(array('article'))){         
         echo CJSON::encode(array(0=>array('')));
         Yii::app()->end();
      }
      
      $str = strtr($part->article, array('%'=>'\%', '_'=>'\_'));
              
      $parts = Yii::app()->db->createCommand()
              ->select('*')
              ->from('car_part')
              ->where(array('like', 'article', $str.'%'))
              ->queryAll();
      
      $data = array();
      foreach($parts as $p)
            $data[] = array('part'=>$p['article'].','.$p['name'], 'id'=>$p['id']);      
      
      echo CJSON::encode(array(
          'source'=>$data
      ));
      
      Yii::app()->end();
   }
}
?>
