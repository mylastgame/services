<? Yii::app()->clientScript->registerCss('dropdownOverflow', '.dropdown-menu { max-height: 400px; overflow-y: auto; overflow-x: hidden;}'); ?>
<script>
var maintenances = [];

$().ready(function(){   
   maintenances = $('#MaintenancePart_maintenance_order').val().split(',');   
   $('#CarPart_name').typeahead({           
      items: 1000,
      source: function(typeahead, query){         
         if(query.length > 2){            
            $.ajax({
               url: '/to/part/findbyname',
               data: {data: query},
               type: 'POST',
               success: function(data){                  
                  typeahead.process(JSON.parse(data).source);
               }
            });
         } else {
            typeahead.process([]);
         }
      },
      property: 'part',
      onselect: function(obj){
         var part = obj.part.split(',');
         $('#CarPart_article').val(part[0]);
         $('#CarPart_name').val(part[1]);
      }
   });
   
   $('#CarPart_article').typeahead({           
      items: 1000,
      source: function(typeahead, query){         
         if(query.length > 2){            
            $.ajax({
               url: '/to/part/findbyarticle',
               data: {data: query},
               type: 'POST',
               success: function(data){                  
                  typeahead.process(JSON.parse(data).source);
               }
            });
         } else {
            typeahead.process([]);
         }
      },
      property: 'part',
      onselect: function(obj){
         var part = obj.part.split(',');
         $('#CarPart_article').val(part[0]);
         $('#CarPart_name').val(part[1]);
      }
   });
      
  
   $('div.controls > div.btn-group > a').each(function(i, e){
      $(e).click(function(event){
         var order = $(e).attr('value');            
         if($(e).hasClass('active')){
            if(order == 'whole'){
               $('div.controls > div.btn-group > a').each(function(index, el){
                  var order = $(el).attr('value');
                  if(order != 'whole' && order != 'all' && order != 'even'){
                     $(el).removeClass('active');
                     maintenances.indexOf(order) != -1 ? maintenances.splice(maintenances.indexOf(order), 1) : '' ;
                  }
               });
            } else if(order == 'even') {                  
               $('div.controls > div.btn-group > a').each(function(index, el){
                  var order = $(el).attr('value');
                  if(order != 'whole' && order != 'all' && order != 'even'){
                     if(order%2 == 0){
                        $(el).removeClass('active');
                        maintenances.indexOf(order) != -1 ? maintenances.splice(maintenances.indexOf(order), 1) : '' ;
                     }                                        
                  }
               });
            } else {                  
               if(order != 'all'){$('#checkboxButton-whole').removeClass('active');}
               maintenances.indexOf(order) != -1 ? maintenances.splice(maintenances.indexOf(order), 1) : '' ;
            }
         } else {
            if(order == 'whole'){
               $('div.controls > div.btn-group > a').each(function(index, el){
                  var order = $(el).attr('value');
                  if(order == 'even')
                     $(el).removeClass('active');
                  if(order != 'whole' && order != 'all' && order != 'even'){
                     $(el).addClass('active');
                     maintenances.indexOf(order) == -1 ? maintenances.push(order) : '' ;
                  }
               });
            } else if(order == 'even'){
               $('div.controls > div.btn-group > a').each(function(index, el){
                  var order = $(el).attr('value');
                  if(order == 'whole')
                     $(el).removeClass('active');
                  if(order != 'all' && order != 'even' && order != 'whole'){
                     if(order%2 == 0){
                        $(el).addClass('active');
                        maintenances.indexOf(order) == -1 ? maintenances.push(order) : '' ;
                     } else {
                        $(el).removeClass('active');
                        maintenances.indexOf(order) != -1 ? maintenances.splice(maintenances.indexOf(order), 1) : '' ;
                     }                     
                  }
               });
            } else {
               maintenances.indexOf(order) == -1 ? maintenances.push(order) : '' ;
            }
         }                     
         $('#MaintenancePart_maintenance_order').val(maintenances.slice(','));
      });
   });        
   $('#CarPart_name').tooltip({
      animation: true,
      placement: 'right',
      title: 'Введите название запчасти'
   });
   $('#CarPart_article').tooltip({
      animation: true,
      placement: 'right',
      title: 'Введите артикул запчасти'
   })
   
});

</script>
<? $this->breadcrumbs=array(
	'Запчасти для ТО'=>'/to',
   'Автомобили'=>'/to',
   $maintenance->CarMark->name=>'/to/mark/'.$maintenance->CarMark->id,
   $maintenance->CarModel->name=>'/to/model/'.$maintenance->CarModel->id,
   $maintenance->CarMod->name=>'/to/mod/'.$maintenance->id,
   'Редактирование информации о ТО'
); ?>
<?php $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array('type'=>'horizontal', 'htmlOptions'=>array('class'=>'well span8', 'autocomplete'=>'off')));?>
<?php echo $form->errorSummary($maintenancePart, 'Не правильный формат данных:'); ?>
<?php echo $form->errorSummary($part, 'Не правильный формат данных:'); ?>
<? echo $form->textFieldRow($part, 'name', array('data-provider'=>'typeahead', 'rel'=>'tooltip', 'title'=>'Введите наименование запчасти')); ?>
<? echo $form->textFieldRow($part, 'article', array('data-provider'=>'typeahead','rel'=>'tooltip', 'title'=>'Введите артикул запчасти')); ?>  
<?php echo $form->textFieldRow($maintenancePart, 'amount', array('class'=>'span1')); ?>    
<?php echo $form->textFieldRow($maintenancePart, 'comment', array('class'=>'span6')); ?>    
<div class="control-group ">
<?php echo CHtml::label('Номер ТО', 'MaintenancePart_maintenance', array('class'=>'control-label')); ?>   
<div class="controls">
<?php 
$this->widget('bootstrap.widgets.BootButtonGroup', array(       
   'toggle' => 'checkbox',
   'buttons' => array(
      array('label'=>'Все', 'htmlOptions'=>array('id'=>'checkboxButton-whole', 'value'=>'whole')),
      array('label'=>'Каждое 2-е', 'htmlOptions'=>array('id'=>'checkboxButton-even', 'value'=>'even'))
   )
));
$orders = explode(',', $maintenancePart->maintenance_order);
for($i=1, $j=1; $i<=$maintenance->number; $i++, $j++){   
   if(in_array($i, $orders))
      $buttons[] = array('label'=>$i, 'active'=>true,'htmlOptions'=>array('id'=>'checkboxButton-'.$i, 'value'=>$i));
   else
      $buttons[] = array('label'=>$i, 'htmlOptions'=>array('id'=>'checkboxButton-'.$i, 'value'=>$i));      
      
   if($j == 10){
      $this->widget('bootstrap.widgets.BootButtonGroup', array(       
         'toggle' => 'checkbox',
         'buttons' => $buttons,
         'htmlOptions'=>array('style'=>'margin:0')
      ));
      $buttons = array();
      $j = 0;
  } 
}
if(!empty($buttons))
   $this->widget('bootstrap.widgets.BootButtonGroup', array(       
      'toggle' => 'checkbox',
      'buttons' => $buttons,
      'htmlOptions'=>array('style'=>'margin:0')
   ));
if(in_array('all', $orders))
   $b = array('label'=>'По мере износа', 'active'=>true,'htmlOptions'=>array('id'=>'checkboxButton-all', 'value'=>'all'));
else
   $b = array('label'=>'По мере износа', 'htmlOptions'=>array('id'=>'checkboxButton-all', 'value'=>'all'));
$this->widget('bootstrap.widgets.BootButtonGroup', array(       
   'toggle' => 'checkbox',
   'buttons' => array($b),
   'htmlOptions'=>array('style'=>'margin:0')
));
?>
<? echo $form->error($maintenancePart, 'maintenance_order'); ?>
</div>
</div>
<? echo $form->hiddenField($maintenancePart, 'maintenance_order'); ?>
<div class="form-actions">
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok', 'label'=>'Сохранить', 'htmlOptions'=>array(''))); ?>
</div>
<?php $this->endWidget();?>
<?php Yii::app()->bootstrap->registerTooltip('#MaintenancePart_part', array('placement'=>'right', 'trigger'=>'hover')); ?>