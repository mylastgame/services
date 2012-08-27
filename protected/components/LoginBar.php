<?php
class LoginBar extends CWidget
{
   public $htmlOptions;
   
   public function run(){
      if(Yii::app()->user->isGuest){
         $user = new User;            
         $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
             'type'=>'inline',
             'action'=>'/login',
             'htmlOptions'=>array(
                 'class'=>'navbar-form pull-right',
                 'style'=>'margin: 0',
                 'action'=>'/login'
                 )
         ));
         echo $form->textFieldRow($user, 'username', array('class'=>'span2'));
         echo ' ';
         echo $form->passwordFieldRow($user, 'password', array('class'=>'span2'));
         $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'icon'=>'arrow-right', 'label'=>'Войти', 'htmlOptions'=>array('style'=>'margin: 5px 0 0 5px')));
         $this->endWidget();      
      } else {
         echo '<div class="navbar-form pull-right">
            <span class="valign-middle"><i class="icon-user icon-white"></i> '.Yii::app()->user->name,
           ' <span class="big">|</span> </span>';               
         $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
             'type'=>'inline',
             'action'=>'/logout',
             'htmlOptions'=>array('class'=>'inline-block margin0')                 
         ));
         $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'icon'=>'arrow-right', 'label'=>'Выход', 'htmlOptions'=>array('style'=>'margin: 5px 0 0 5px')));
         $this->endWidget();
         echo '</div>';
      }
   }
}

?>
