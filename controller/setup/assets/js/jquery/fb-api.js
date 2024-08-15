/**
 * jquery.fblogin - v1.1.3 (2016-09-14)
 * https://github.com/ryandrewjohnson/jquery-fblogin
 * Copyright (c) 2016 Ryan Johnson; Licensed MIT 
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a){a.extend({fblogin:function(b){var c,d,e,f;return b=b||{},d=!1,e=!1,f=a.Deferred(),c={init:function(){if(!b.fbId)throw new Error('Required option "fbId" is missing!');b.permissions=b.permissions||"",b.fields=b.fields||"",b.success=b.success||function(){},b.error=b.error||function(){},c.listenForFbAsync()},listenForFbAsync:function(){if(window.fbAsyncInit)var a=window.fbAsyncInit;return window.fbAsyncInit=function(){c.initFB(),d=!0,a&&a()},d||window.FB?void window.fbAsyncInit():void 0},initFB:function(){e||(window.FB.init({appId:b.fbId,cookie:!0,xfbml:!0,version:"v2.0"}),e=!0),f.notify({status:"init.fblogin"})},loginToFB:function(){window.FB.login(function(a){a.authResponse?f.notify({status:"authenticate.fblogin",data:a}):f.reject({error:{message:"User cancelled login or did not fully authorize."}})},{scope:b.permissions,return_scopes:!0})},getFbFields:function(a){window.FB.api("/me",{fields:b.fields},function(a){a&&!a.error?f.resolve(a):f.reject(a)})}},f.progress(function(a){"init.fblogin"===a.status?c.loginToFB():"authenticate.fblogin"===a.status?c.getFbFields(a.data.authResponse.accessToken):dfd.reject()}),f.done(b.success),f.fail(b.error),c.init(),f}})});