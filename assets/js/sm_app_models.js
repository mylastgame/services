SM_APP.models.Mark = Backbone.Model.extend({
   defaults: {
      id: '',
      name: '',
      models: {}
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