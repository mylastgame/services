<?php
class SiteController extends Controller
{      
   public $layout = 'layout';
   public $navbar = array(
         array('label'=>'Главная', 'url'=>'/#', 'active'=>true),
         array('label'=>'Запчасти для ТО', 'url'=>'#', 'items'=>array(
            array('label'=>'Автомобили и ТО' , 'url'=>'/to',),
            array('label'=>'Запчасти', 'url'=>'/to/part')
         ))
      );
      
   public function filters(){
      return array(
          'postOnly + login, logout'
      );
   }
   
   public function actionIndex(){
      $this->render('index');      
   }
   
   public function actionError()
   {
      if($error=Yii::app()->errorHandler->error)
      {
         if(Yii::app()->request->isAjaxRequest)
            echo $error['message'];
         else
            $this->render('error', $error);
      }
   }
   
   public function actionLogin(){
      $user = new User;
      $user->attributes = $_POST['User'];
      if($user->validate(array('username', 'password'))){
         $identity=new UserIdentity($user->username,$user->password);
         if($identity->authenticate()){
            Yii::app()->user->login($identity, 3600*24*7);            
            $this->redirect(Yii::app()->user->returnUrl);
         }
      }
      Yii::app()->user->setFlash('error', 'Не верный логин или пароль!');
      $this->redirect('/');      
   }
   
   public function actionLogout(){
      Yii::app()->user->logout();
      $this->redirect('/');
   }

   public function actionAuthm(){
      $auth=Yii::app()->authManager;
      $auth->createOperation('manageMParts','Manage maintenance parts');
            
      $role=$auth->createRole('mpartsManager');
      $role->addchild('manageMParts');
      
      $auth->assign('mpartsManager', 1);
      $auth->assign('mpartsManager', 3);
   }
   
}

?>
