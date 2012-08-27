SM_APP.LocStor = {
   add: function(key, value){ 
      try {
         if('localStorage' in window && window['localStorage'] !== null)
            localStorage.setItem(key, JSON.stringify(value));
      } catch (e) {
         
      }
   },
   get: function(key){
      try {
         if('localStorage' in window && window['localStorage'] !== null)
            if(localStorage.getItem(key)) 
               return JSON.parse(localStorage.getItem(key));         
      } catch (e) {
         
      }
      return false;
   }
}  

SM_APP.SesStor = {
   add: function(key, value){ 
      try {
         if('sessionStorage' in window && window['sessionStorage'] !== null)
            sessionStorage.setItem(key, JSON.stringify(value));
      } catch (e) { }
   },
   get: function(key){
      try {
         if('sessionStorage' in window && window['sessionStorage'] !== null)
            if(sessionStorage.getItem(key)) 
               return JSON.parse(sessionStorage.getItem(key));         
      } catch (e) { }
      return false;
   }
}   

SM_APP.models.Mark = Backbone.Model.extend({
   defaults: {
      id: '',
      name: ''      
   },
   url: function(){
      return SM_APP.baseUrl+'mark/'+this.get('id');
   }
});

SM_APP.models.Model = Backbone.Model.extend({
   defaults: {
      id: '',
      name: '',
      mark_id: ''
   },
   url: function(){
      return SM_APP.baseUrl+'model/'+this.get('id');
   }
});

SM_APP.models.Mod = Backbone.Model.extend({
   defaults: {
      id: '',
      name: '',
      model_id: ''
   },
   url: function(){
      return SM_APP.baseUrl+'mod/'+this.get('id');
   }
});

SM_APP.models.Maintenance = Backbone.Model.extend({
   defaults: {      
      mark_id: '',     
      model_id: '',
      mod_id: '',     
      maintenance_order: '',
      distance: 0
   },
   url: function(){}
});

SM_APP.models.Part = Backbone.Model.extend({
   defaults: {      
      name: '',
      article: '',
      amount: 1,
      comment: ''
   },
   url: function(){}
});


SM_APP.collections.Marks = Backbone.Collection.extend({
   model: SM_APP.models.Mark,
   url: function() {return SM_APP.baseUrl+'marks/';}
});

SM_APP.collections.Models = Backbone.Collection.extend({
   initialize: function(options){
      this.parentId = options.parentId;
   },
   model: SM_APP.models.Model,
   parentId: '',
   url: function() {return SM_APP.baseUrl+'mark/'+this.parentId+'/models';}
});

SM_APP.collections.Mods = Backbone.Collection.extend({
   initialize: function(options){
      this.parentId = options.parentId;
   },
   model: SM_APP.models.Mod,
   parentId: '',
   url: function() {return SM_APP.baseUrl+'model/'+this.parentId+'/mods';}
});

SM_APP.collections.Maintenances = Backbone.Collection.extend({
   initialize: function(options){
      this.parentId = options.parentId;
   },
   model: SM_APP.models.Maintenance,
   parentId: '',
   url: function() {return SM_APP.baseUrl+'mod/'+this.parentId+'/maintenances';}
});

SM_APP.collections.Parts = Backbone.Collection.extend({
   initialize: function(options){
      this.parentId = options.parentId;
      this.order = options.order;
   },
   model: SM_APP.models.Part,
   parentId: '',
   orederId: '',
   url: function() {return SM_APP.baseUrl+'mod/'+this.parentId+'/maintenance/'+this.order;}
});


//Models Views
SM_APP.views.Item = Backbone.View.extend({
   tagName: 'span',            
   render: function(){      
      $(this.el).html(this.model.get('name'));
      return this;
   }   
});

SM_APP.views.MarkView = SM_APP.views.Item.extend({   
   events: {
      'click': function(){ this.trigger('markClick', { mark: this.model.attributes } )}
   }
});

SM_APP.views.ModelView = SM_APP.views.Item.extend({
   events: {
      'click': function(){ this.trigger('modelClick', { model: this.model.attributes } )}      
   }
});

SM_APP.views.ModView = SM_APP.views.Item.extend({
   events: {
      'click': function(){ this.trigger('modClick', { mod: this.model.attributes, maintenance: {} } )}
   }
});

SM_APP.views.MaintenanceView = Backbone.View.extend({
   tagName: 'span', 
   render: function(){      
      $(this.el).html(this.model.get('maintenance_order'));
      return this;
   },  
   events: {
      'click': function(){ this.trigger('modClick', { maintenance: this.model.attributes } ) }
   }
});

SM_APP.views.PartView = Backbone.View.extend({
   initialize: function(options){
      this.on('searchPart', function(data){         
         if(window.location.pathname == '/main/search/')
            window.location = 'main/search/#mode=false&analogs=true&periodmin=-1&group=true&skeys='+data.article+'&prodid=-1&dirid=-1&currency=1&order_by=updated_price';
         else
            window.location = 'http://'+window.location.host+'/main/search/#mode=false&analogs=true&periodmin=-1&group=true&skeys='+data.article+'&prodid=-1&dirid=-1&currency=1&order_by=updated_price';
         
      });   
   },
   template: '<td class=\'sm_app-parts-article-cell\'><%= article %></td><td><%= name %></td><td><%= amount %></td><td><%= comment %></td>',   
   tagName: 'tr', 
   render: function(){            
      $(this.el).html(_.template(this.template, this.model.attributes));
      var that = this;
      $(this.el).find('td').first().click(function(){
         that.trigger('searchPart', {article: that.model.get('article')});
      });
      return this;
   }
});


//Collections views
SM_APP.views.CollectionView = Backbone.View.extend({   
   childClass: '',
   render: function(){            
      var that = this;        
      _(this._childViews).each(function(cV){             
         $(that.el).append(cV.render().el);
      });                              
      return this;
   }
});  

SM_APP.views.MarksView = SM_APP.views.CollectionView.extend({
   childClass: 'sm_app-items-inline',
   initialize: function(options){            
      var that = this;
      this._childViews = [];        
      this.collection.each(function(child){                  
         var mv = new SM_APP.views.MarkView({
            model: child,
            className: that.childClass            
         })
         that._childViews.push(mv);         
         mv.on('markClick', that.markClick);
      });
   },   
   markClick: function(data){
      SM_APP.controller.initialize(data);
   }
});

SM_APP.views.ModelsView = SM_APP.views.CollectionView.extend({
   childClass: 'sm_app-items-block',   
   initialize: function(options){  
      this.mark = options.mark;
      var that = this;
      this._childViews = [];        
      this.collection.each(function(child){                  
         var mv = new SM_APP.views.ModelView({
            model: child,
            className: that.childClass            
         })
         that._childViews.push(mv);         
         mv.on('modelClick', that.modelClick, that);
      });
   },   
   modelClick: function(data){      
      data.mark = this.mark.attributes;
      SM_APP.controller.initialize(data);
   }
});

SM_APP.views.ModsView = SM_APP.views.CollectionView.extend({
   childClass: 'sm_app-items-block',   
   initialize: function(options){    
      this.mark = options.mark;      
      this.model = options.model;      
      var that = this;
      this._childViews = [];        
      this.collection.each(function(child){                  
         var mv = new SM_APP.views.ModView({
            model: child,
            className: that.childClass            
         })
         that._childViews.push(mv);         
         mv.on('modClick', that.modClick, that);
      });
   },   
   modClick: function(data){
      data.mark = this.mark.attributes;
      data.model = this.model.attributes;
      SM_APP.controller.initialize(data);
   }
});

SM_APP.views.MaintenancesView = SM_APP.views.CollectionView.extend({    
   childClass: 'sm_app-maintenance',
   initialize: function(options){      
      this.mark = options.mark;      
      this.model = options.model;
      this.mod = options.mod;
      this.current = options.current;
      var that = this;
      this._childViews = [];              
      this.collection.each(function(child){                 
         if(that.current.get('maintenance_order') === child.get('maintenance_order'))
            that.childClass = 'sm_app-maintenance-current';
         else
            that.childClass = 'sm_app-maintenance';
         var mv = new SM_APP.views.MaintenanceView({
            model: child,
            className: that.childClass            
         })
         that._childViews.push(mv);         
         mv.on('modClick', that.modClick, that);
      });
   },   
   modClick: function(data){
      data.mark = this.mark.attributes;
      data.model = this.model.attributes;
      data.mod = this.mod.attributes;
      SM_APP.controller.initialize(data);
   }
});

SM_APP.views.PartsView = SM_APP.views.CollectionView.extend({
   childClass: 'sm_app-parts-row',
   tagName: 'table',
   initialize: function(options){            
      var that = this;
      this._childViews = [];        
      this.collection.each(function(child){             
         that._childViews.push(new SM_APP.views.PartView({
            model: child,
            className: that.childClass
         }));
      });
   }
});


//Page views
SM_APP.views.PageView = Backbone.View.extend({
   template: "<div id='sm_app-header'></div><div id='sm_app-collection'></div>",
   initialize: function(options){
      
   },   
   render: function(){        
      $(this.el).html(_.template(this.template, {}));         
      return this;
   }
});

SM_APP.views.IndexPageView = SM_APP.views.PageView.extend({
   template: "<div class='sm_app-header'>Выбирете марку автомобиля:</div><div id='sm_app-collection'></div>"
});

SM_APP.views.MarkPageView = SM_APP.views.PageView.extend({
   template: "<div class='sm_app-header'><span class='sm_app-back-item' id='sm_app-back-item1'></span><br><span class='sm_app-header'>Выбирете модель автомобиля:</span></div><div id='sm_app-collection'></div>"
});

SM_APP.views.ModelPageView = SM_APP.views.PageView.extend({
   template: "<div class='sm_app-header'><span class='sm_app-back-item' id='sm_app-back-item1'></span> -> \n\
<span class='sm_app-back-item' id='sm_app-back-item2'></span><br>\n\
<span class='sm_app-header'>Выбирете модификацию автомобиля:</span></div>\n\
<div id='sm_app-collection'></div>"
});

SM_APP.views.ModPageView = SM_APP.views.PageView.extend({
   initialize: function(options){
      this.model = options.model;
   },
   template: "<div class='sm_app-header'><span class='sm_app-back-item' id='sm_app-back-item1'></span> -> \n\
<span class='sm_app-back-item' id='sm_app-back-item2'></span> -> \n\
<span class='sm_app-back-item' id='sm_app-back-item3'></span><br>\n\
</span>Выбирете номер ТО:</div><div id='sm_app-collection'></div>\n\
<div class='sm_app-header'>ТО №<%= order %>, пробег: <%= distance %> 000 км.</div>\n\
<table class='sm_app-parts-table' id='sm_app-parts-table'><tr><th>Код</th><th>Название</th><th>Количество</th><th>Комментарий</th></tr></table>\n\
<div class='sm_app-header'>Замена по мере износа:</div>\n\
<table class='sm_app-parts-table' id='sm_app-parts-table-all'><tr><th>Код</th><th>Название</th><th>Количество</th><th>Комментарий</th></tr></table>",
   render: function(){        
      $(this.el).html(_.template(this.template, {order: this.model.get('maintenance_order'), 
         distance: this.model.get('distance')}));         
      return this;
   }
});

//Other views
SM_APP.views.BackItemView = Backbone.View.extend({
   eventData: {},   
   initialize: function(options){
      this.eventData = options.eventData;
      this.on('backEvent', SM_APP.controller.initialize, SM_APP.controller);
   },          

   events: {
      'click': function(){this.trigger('backEvent', this.eventData)}
   },

   render: function(){
      $(this.el).html(this.model.get('name'));      
      return this;
   }   
});


//Layout
SM_APP.views.Layout = Backbone.View.extend({   
   tagName: 'div',      
   render: function(){                        
      return this;
   }
});


SM_APP.controller = {   
   layout: {},
   items: {},   
   layoutEl: '',

   initialize: function(data){      
      this.items = {};
      this.off('pageRendered');  
             
      if(_.isEmpty(this.layout)){  
         this.layout = new SM_APP.views.Layout({
            el: this.layoutEl,
            tagName: 'div'            
         });         
      }      
      $(this.layout.el).empty();           
      this.layout.render();      
            
      
      if(data.mod){this.modPage(data);}
      else if(data.model){this.modelPage(data);}
      else if(data.mark){this.markPage(data);}       
      else {this.indexPage();}
      
      SM_APP.SesStor.add('data', data);
      SM_APP.LocStor.add('data', data);
   },

   indexPage: function(data){      
      this.items.collection = new SM_APP.collections.Marks;     

      this.items.collection.on('sync', function(){                           
         SM_APP.controller.items.view = new SM_APP.views.IndexPageView;                      
         SM_APP.controller.trigger('initPage');                  
      });
      
      this.on('pageRendered', function(){           
         this.items.marksView = new SM_APP.views.MarksView({           
            el: '#sm_app-collection',
            tagName: 'div',
            collection: this.items.collection
         }, SM_APP.controller).render();           
      });

      this.items.collection.fetch({
         success: function(collection, response){
            collection.trigger('sync');
         }
      });                      
   },

   markPage: function(data){            
      var mark = new SM_APP.models.Mark(data.mark);
      this.items.collection = new SM_APP.collections.Models({
         parentId: mark.get('id')
      });           
      
      this.items.collection.on('sync', function(){                           
         SM_APP.controller.items.view = new SM_APP.views.MarkPageView;                      
         SM_APP.controller.trigger('initPage');                  
      });
      
      this.on('pageRendered', function(){           
         this.items.modelsView = new SM_APP.views.ModelsView({           
            el: '#sm_app-collection',
            tagName: 'div',     
            mark: mark,
            collection: this.items.collection            
         }, SM_APP.controller).render();       
         
         this.items.backIndexView = new SM_APP.views.BackItemView({
            eventData: {},
            model: mark,            
            el: '#sm_app-back-item1'
         }).render();
      });

      this.items.collection.fetch({
         success: function(collection, response){
            collection.trigger('sync');
         }
      });    
   },

   modelPage: function(data){  
      var mark = new SM_APP.models.Mark(data.mark);
      var model = new SM_APP.models.Model(data.model);
      
      this.items.collection = new SM_APP.collections.Mods({
         parentId: model.get('id')
      });           
      
      this.items.collection.on('sync', function(){                           
         SM_APP.controller.items.view = new SM_APP.views.ModelPageView;                      
         SM_APP.controller.trigger('initPage');                  
      });
      
      this.on('pageRendered', function(){         
         this.items.modsView = new SM_APP.views.ModsView({           
            el: '#sm_app-collection',
            tagName: 'div',            
            mark: mark,
            model: model,
            collection: this.items.collection                        
         }, SM_APP.controller).render();       
                           
         this.items.backIndexView = new SM_APP.views.BackItemView({
            eventData: {},
            model: mark,
            el: '#sm_app-back-item1'
         }).render();
         
         this.items.backMarkView = new SM_APP.views.BackItemView({
            eventData: {mark: mark.attributes},
            model: model,
            el: '#sm_app-back-item2'
         }).render();
      });

      this.items.collection.fetch({
         success: function(collection, response){
            collection.trigger('sync');
         }
      });  
   },

   modPage: function(data){          
      var mark = new SM_APP.models.Mark(data.mark);
      var model = new SM_APP.models.Model(data.model);
      var mod = new SM_APP.models.Mod(data.mod);       
      if(!_.isEmpty(data.maintenance))
         var maintenance = new SM_APP.models.Maintenance(data.maintenance);
      else
         var maintenance = {};
      
      this.items.collection = new SM_APP.collections.Maintenances({
         parentId: mod.get('id')
      });                
      
      this.items.collection.on('sync', function(){ 
         if(_.isEmpty(maintenance))
            maintenance = this.first();                  
         
         SM_APP.controller.items.parts_collection = new SM_APP.collections.Parts({
            parentId: mod.get('id'),
            order: maintenance.get('maintenance_order')
         });
         
         SM_APP.controller.items.parts_collection.on('sync', function(){
            
            SM_APP.controller.items.parts_all_collection = new SM_APP.collections.Parts({
               parentId: mod.get('id'),
               order: 'all'
            });
            
            SM_APP.controller.items.parts_all_collection.on('sync', function(){
               SM_APP.controller.items.view = new SM_APP.views.ModPageView({
                  model: maintenance
               });                                                    
               SM_APP.controller.trigger('initPage');    
            });
            
            SM_APP.controller.items.parts_all_collection.fetch({
               success: function(collection, response){
                  collection.trigger('sync');
               }
            });               
         });
         
         SM_APP.controller.items.parts_collection.fetch({
            success: function(collection, response){
               collection.trigger('sync');
            }
         });                 
      }, this.items.collection);
      
      this.on('pageRendered', function(){         
         this.items.maintenancesView = new SM_APP.views.MaintenancesView({           
            el: '#sm_app-collection',
            tagName: 'div',            
            mark: mark,
            model: model,
            mod: mod,
            collection: this.items.collection, 
            current: maintenance 
         }, SM_APP.controller).render();                
         
         this.items.backIndexView = new SM_APP.views.BackItemView({
            eventData: {},
            model: mark,
            el: '#sm_app-back-item1'
         }).render();
         
         this.items.backMarkView = new SM_APP.views.BackItemView({
            eventData: { mark: mark.attributes },
            model: model,
            el: '#sm_app-back-item2'
         }).render();
         
         this.items.backModelView = new SM_APP.views.BackItemView({
            eventData: { mark: mark.attributes, model: model.attributes },
            model: mod,
            el: '#sm_app-back-item3'
         }).render();
         
         this.items.partsViewTable = new SM_APP.views.PartsView({
            collection: this.items.parts_collection,
            el: '#sm_app-parts-table'
         }).render();
         
         this.items.partsAllViewTable = new SM_APP.views.PartsView({
            collection: this.items.parts_all_collection,
            el: '#sm_app-parts-table-all'
         }).render();
      });
      
      this.items.collection.fetch({
         success: function(collection, response){
            collection.trigger('sync');
         }
      });  
   }
};
         
SM_APP.start = function(el){       
   _.extend(SM_APP.controller, Backbone.Events);   
   SM_APP.controller.on('initPage', function(){      
      $(this.layout.el).html(SM_APP.controller.items.view.render().el);                     
      this.trigger('pageRendered');            
   }, SM_APP.controller);
   
   SM_APP.controller.layoutEl = el;           
   
   SM_APP.controller.initialize(SM_APP.SesStor.get('data') || SM_APP.LocStor.get('data') || {});  
};

SM_APP.stop = function(){
   SM_APP.controller.items = {};
   SM_APP.controller.layout = {};
   SM_APP.controller.off();     
}