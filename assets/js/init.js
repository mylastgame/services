SM_APP = {
   baseUrl: 'http://services/REST/maintenance/',
   models: {},
   collections: {},
   views: {},
   loaded: false
};

SM_APP.load_scripts = function(scripts, callback){
   if(scripts.length == 1){      
      $.getScript(scripts.shift(), callback);      
   }
   if(scripts.length > 0){
      $.getScript(scripts.shift(), function(){
         SM_APP.load_scripts(scripts, callback);
      });
   }
}

SM_APP.load_styles = function(styles){
   for(var i=0; i<styles.length; i++){
      $('head').append('<link id="sm_app-css" rel="stylesheet" href="'+styles[i]+'">');         
   }   
}

SM_APP.init = function(){         
   if(!this.loaded){      
      $.getScript('http://services/assets/js/json2.js');
      $.getScript('http://services/assets/js/jquery-ui-1.8.21.custom.min.js');      
      SM_APP.load_styles([
         'http://services/assets/css/sm_app.css'
      ]);

      SM_APP.load_scripts([                  
         'http://services/assets/js/jquery.jsonp-2.3.1.min.js',
         'http://services/assets/js/underscore-min.js',
         'http://services/assets/js/backbone.js',
         'http://services/assets/js/sm_app.js'
         ], function(){                             
            $('body').append("<div id='sm_app-wrap'><div id='sm_app-button-open'></div><div id='sm_app-window'></div></div>"); 
            $('#sm_app-button').hide();
            SM_APP.start('#sm_app-window');
            $('#sm_app-wrap').show('slide', { direction: 'right' }, 800);                        
            $('#sm_app-button-open').one('click', function(){               
               $('#sm_app-button').show();
               $('#sm_app-wrap').hide('slide', { direction: 'right', distance: 645 }, 800, function(){
                  SM_APP.stop();
                  $('#sm_app-wrap').remove();
               });                           
            });                                    
         }
      );        
      this.loaded = true;
   } else {                  
      $('body').append("<div id='sm_app-wrap'><div id='sm_app-button-open'></div><div id='sm_app-window'></div></div>"); 
      $('#sm_app-button').hide();
      SM_APP.start('#sm_app-window');
      $('#sm_app-wrap').show('slide', { direction: 'right' }, 800);      
      $('#sm_app-button-open').one('click', function(){
         $('#sm_app-button').show();
         $('#sm_app-wrap').hide('slide', { direction: 'right', distance: 645 }, 800, function(){
            SM_APP.stop();
            $('#sm_app-wrap').remove();
         });                                 
      });
   }
}

$(document).ready(function(){   
   $('head').append('<link rel="stylesheet" href="http://services/assets/css/sm_app-init.css">');
   $('body').append('<div id="sm_app-button"></div>');
   $('#sm_app-button').click(SM_APP.init);   
});

