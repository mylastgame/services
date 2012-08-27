Backbone.$ = jQuery || Zepto || ender;

Backbone.sync = function(method, model, options){
   var methodMap = {
      'create': 'POST',
      'update': 'PUT',
      'delete': 'DELETE',
      'read':   'GET'
   };
   
   var type = methodMap[method];

   options || (options = {});

   var params = {type: type, dataType: 'json'};

   if (!options.url) {
      params.url = getValue(model, 'url') || urlError();
   }

   if (!options.data && model && (method == 'create' || method == 'update')) {
      params.contentType = 'application/json';
      params.data = JSON.stringify(model);
   }

   if (Backbone.emulateJSON) {
      params.contentType = 'application/x-www-form-urlencoded';
      params.data = params.data ? {model: params.data} : {};
   }

   if (Backbone.emulateHTTP) {
      if (type === 'PUT' || type === 'DELETE') {
        if (Backbone.emulateJSON) params.data._method = type;
        params.type = 'POST';
        params.beforeSend = function(xhr) {
          xhr.setRequestHeader('X-HTTP-Method-Override', type);
        };
      }
   }

   if (params.type !== 'GET' && !Backbone.emulateJSON) {
      params.processData = false;
   }
   
   /* Custom changes. Adding LocalStorage facility */
   
   
   /* Custom changes. Adding JSONP facility */
   //return Backbone.ajax(_.extend(params, options));   
   options = _.extend(options, {
      callback: 'callback'
   });   
   
   console.log(options);
   return $.jsonp(_.extend(params, options));      
};

Backbone.ajax = function() {
   return Backbone.$.ajax.apply(Backbone.$, arguments);   
};

var getValue = function(object, prop) {
   if (!(object && object[prop])) return null;
   return _.isFunction(object[prop]) ? object[prop]() : object[prop];
};