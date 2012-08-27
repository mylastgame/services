<? $this->widget('bootstrap.widgets.BootNavbar', array(
   'fixed'=>'top',
   'brand'=>'Web services',
   'brandUrl'=>'/#',
   'collapse'=>true,
   'items'=>array(       
       array(
           'class'=>'bootstrap.widgets.BootMenu',
           'items'=>$this->navbar
       ),
       array(
           'class'=>'application.components.LoginBar',
           'htmlOptions'=>array('class'=>'pull-right')
       ),              
   ) 
)); ?>