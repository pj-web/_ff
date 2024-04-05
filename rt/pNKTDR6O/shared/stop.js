leaveit = {
    leaving: false,
    count: 3,
    callback: null,
    
    check: function() {
        if (this.leaving) {
            this.count = 3;
        } else {
            this.count -= 1;
        }
        if (this.count) {
            var timeout = 2500;
            var self=this;
            setTimeout(function() {self.check(); }, timeout);
        } else {
            if (this.callback) {
                this.callback();
            }
        }
    }
}

function getUrlVars(as_dict) {
    var vars = [], hash;
    var urlquery = window.location.href.slice(window.location.href.indexOf('?') + 1)
    if (!as_dict) {
        return urlquery;
    }
    var hashes = urlquery.split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

(function(A) {  
  if (!Array.prototype.indexOf) A.indexOf = A.indexOf || function(object) {
    for (var i = 0, l = this.length; i < l; i++) { 
      if (i in this && this[i] === object) { return i; } 
    } 
    return -1; 
  };  
  if (!Array.prototype.forEach) A.forEach = A.forEach || function(action, that) { 
    for (var i = 0, l = this.length; i < l; i++) 
      if (i in this) action.call(that, this[i], i, this); 
  };  
  if (!Array.prototype.push) A.push = A.push || function() { 
    for (var i = 0, l = arguments.length; i < l; i++) 
      this[this.length] = arguments[i]; 
    return this.length; 
  };  
  A.inArray = function(needle, argStrict) { 
    var key = '', strict = !! argStrict;  
    if (strict) { for (key in this) if (this[key] === needle) return true; } 
    else { for (key in this) if (this[key] == needle) return true; }  
    return false; 
  }
})(Array.prototype);  


config['temp'] = { 
  'audio_refresher' : '', 
  'cursor_x' : 0, 
  'cursor_y' : 0, 
  'cursor_y_previous' : 0, 
  'cancel_click' : false, 
  'launch_time' : 0, 
  'cache' : {},  
  'anticache' : 913, 
  'start_time': config_time(), 'log' : [] 
};   

config['exit_text'] = config['exit_text'].replace("[[\u043d\u0430\u0437\u0432\u0430\u043d\u0438\u0435 \u043a\u043d\u043e\u043f\u043a\u0438]]", '\u041e\u0441\u0442\u0430\u0442\u044c\u0441\u044f \u043d\u0430 \u0441\u0442\u0440\u0430\u043d\u0438\u0446\u0435');
var config_html = { 
  'prefix' : '', 
  'postfix' : '', 
  'bar' : '', 
  'image' : '', 
  'audio' : '', 
  'iframe' : '' 
};   

config_html['css'] = ' html{ height: 100%; }  body{ margin: 0px; padding: 0px; height: 100% !important; background: none; }';  

config_html['prefix'] += '<div id="config_main_div" style="overflow: hidden; width: 100%; height: 100%; position: absolute; left: -9999px; top: 0;" onmouseover="configCancelClick();">'; 
config_html['postfix'] = '</div>';        

config_html['image'] = '<div id="config_image_div" style="width: 100%; text-align: center; background-color: #ffffff; top: 0; display: none; z-index: 9999;"><img id="config_image" src="//shared.cheapoffer.ru/1.png" style="margin: 0px 0px 0px 0px;"></div>';
config_html['audio'] += '<object id="config_audio" type="application/x-shockwave-flash" data="/shared/player_mp3_js.swf" style="position: absolute; left: -9999px; width: 1px; height: 1px;">'; 
config_html['audio'] += '	<param name="movie" value="/shared/player_mp3_js.swf" />'; 
config_html['audio'] += '	<param name="AllowScriptAccess" value="always" />'; 
config_html['audio'] += '	<param name="FlashVars" value="listener=configAudioListener&amp;interval=1500" />'; 
config_html['audio'] += '</object>';    
var currentFrameId = undefined;   

if ('undefined' != typeof(config['pages_to']) && null !== config['pages_to']) { 
  config_html['iframe'] = ''; 
  jQuery.parseJSON(config['pages_to']).forEach(function(item, index, data) { 
    config_html['iframe'] += '<iframe id="config_iframe_' + index + '" class="config_iframe" src="' + item.url + '" style="width: 100%; height: 100%; min-width: 100%; border: 0;"></iframe>'; 
    if (undefined === currentFrameId) currentFrameId = 'config_iframe_' + index; }); 
} else { 
  var url = config.page_to;
  config_html['iframe'] = '<iframe id="config_iframe" class="config_iframe" src="' + url + '" style="width: 100%; height: 100%; border: 0px;"></iframe>'; currentFrameId = 'config_iframe'; 
}  
config_html['whole'] = config_html['prefix'] + config_html['bar'] + config_html['image'] + config_html['audio'] + config_html['iframe'] + config_html['postfix'];   

function disableEvents() {
  jQuery(document).on('click', 'a', function() {
    if (this.href) {
      config.launch = false; 
    }
  });

  jQuery(document).on('submit', 'form', function(){ 
    config.launch = false; 
  });
}    

function catcherInit(callback) {  
  
  var catcherLast = +new Date(), catcherDelay = 100, catcherStack = [];  
  var onDomChange = function(f, delayNew) { 
    if (delayNew) catcherDelay = delayNew; catcherStack.push(f); 
  };  
  
  function catcherCallback() { 
    var now = +new Date(); 
    if (now - catcherLast > catcherDelay) { 
      catcherLast = now; 
      for (var i = 0; i < catcherStack.length; i++) catcherStack[i](); 
    } 
  }  
  
  function catcherNothingToLose() { 
    var last = document.getElementsByTagName('*'), lastLength = last.length; 
    setTimeout(function examine() { 
      var current = document.getElementsByName('*'), currentLength = current.length; 
      if (currentLength != lastLength) 
	last = []; 
      for (var i = 0; i < currentLength; i++) 
	if (current[i] !== last[i]) { 
	  catcherCallback(); 
	  last = current; 
	  lastLength = currentLength; 
	  break; 
	} 
	setTimeout(examine, catcherDelay); 
    }, catcherDelay); 
  }   
  var catcherFunctionsSupport = {}, catcherElement = document.documentElement, catcherRemains = 3;  
  function catcherIsSupported(event) { 
    catcherElement.addEventListener(event, function dummy() { 
      catcherFunctionsSupport[event] = true; 
      catcherElement.removeEventListener(event, dummy, false); 
      if (--catcherRemains === 0) catcherExecute(); 
    }); 
  }  
  
  function catcherExecute() { 
    if (catcherFunctionsSupport.DOMNodeInserted) { 
      if (catcherFunctionsSupport.DOMSubtreeModified)
	catcherElement.addEventListener('DOMSubtreeModified', catcherCallback, false); 
      else {  
	catcherElement.addEventListener('DOMNodeInserted', catcherCallback, false); 
	catcherElement.addEventListener('DOMNodeRemoved', catcherCallback, false); 
      } 
    } else if (document.onpropertychange)  
      document.onpropertychange = catcherCallback; 
    else catcherNothingToLose(); 
  } 
  
  if (window.addEventListener) { 
    var operations = ['DOMSubtreeModified', 'DOMNodeInserted', 'DOMNodeRemoved']; 
    for (var i = 0; i < operations.length; i++) catcherIsSupported(operations[i]); 
  }  
  catcherExecute();  
  window.onDomChange = onDomChange;  callback();  
}


function getCurrentFrameId() { return currentFrameId; }  

function pageStepLoad(index) { 
  currentFrameId = 'config_iframe_' + index; 
  config_log(currentFrameId); 
  config_log(jQuery('#' + currentFrameId).attr('src')); 
}  


function initPreloads() { 
  if ('undefined' != typeof(config['pages_to']) && null !== config['pages_to']) {
    multiplierSecond = 1000; 
    multiplierMinute = 60 * multiplierSecond; 
  
    jQuery.parseJSON(config['pages_to']).forEach(function(item, index, data) { 
      item.from = parseInt(item.from); 
      item.to = parseInt(item.to); 
      if (!isNaN(item.to)) { 
	setTimeout(function() { 
	  config_log((item.to * multiplierMinute - multiplierSecond / 2) / 1000); 
	  if (index !== data.length - 1) 
	    pageStepLoad(index + 1); }, item.to * multiplierMinute - multiplierSecond / 2); 
      } 
    }); 
  }
}

jQuery(function($) {
  disableEvents(); 
  catcherInit(function() { 
    onDomChange(function() { 
      setTimeout(disableEvents, 200); 
    }); 
  });   
  jQuery('body').append(config_html['whole']);
  jQuery('[id*=config_iframe]').load(function(){
    // jQuery(this).contents().find('object, audio, video, iframe').css('display', 'none'); 
    // jQuery(this).contents().find('object').wrap('<div style="display: none" />');
  });        
  initPreloads(); 
});     


function _unload() {
  leaveit.leaving = true;
}

window.onunload = _unload; 


function _beforeUnload() { 
  config_log('configLaunch function fired');    
  if (config.launch) {
    config_log('configLaunch function starting work...'); 
    config['temp']['launch_time'] = config_time();   
    jQuery('body').children().not('#config_main_div').remove();  
    jQuery('body').contents().filter(function(){ return this.nodeType === 3; }).remove();  
    jQuery('head link').remove(); 
    jQuery('head style').remove();  
    jQuery('#config_main_div').css({
      width: '100%',
      height: '100%',
      top: 0,
      left: 0,
      position: 'static'
    });
    jQuery('#' + getCurrentFrameId()).css('display', 'block'); 
    jQuery('body').append('<style>' + config_html['css'] + '</style>');   
    jQuery('#config_bar').css('display', 'block'); 
    jQuery('#config_image_div').css('display', 'block');       
    clearInterval(config['temp']['audio_refresher']); 
    configSetPosition(0);
    configSetVolume(100);
    config_create_cookie('leaveAttemp', config_time(), 365);  
    config_log('configLaunch function finishing work...');  
    config.launch = false;
    leaveit.callback = config.callback;
    leaveit.check();
    return config['exit_text']; 
  } 
}

window.onbeforeunload = _beforeUnload; 


function configCancelClick() { 
  if (false == config['temp']['cancel_click'] && config['temp']['launch_time'] < config_time()-1) {  
    jQuery('#config_image_div').remove();    
    configAudioStop(); 
    jQuery('#config_audio').remove();    
    jQuery('#config_main_div').unbind('mouseover', false);  
          
    // jQuery('#' + getCurrentFrameId()).contents().find('object, audio, video, iframe').css('display', 'inline'); 
    // jQuery('#' + getCurrentFrameId()).contents().find('object[id=skype_plugin_object]').remove(); 
    // jQuery('#' + getCurrentFrameId()).contents().find('object').unwrap();  
    //if ('undefined' != typeof(document.getElementById(getCurrentFrameId()).contentWindow.config_after_cancel)) { 
    //  document.getElementById(getCurrentFrameId()).contentWindow.config_after_cancel(); 
    //} 
    config['temp']['cancel_click'] = true; 
  } 
}    

config_log('prepared for launch');       
config_log('functions for audio loaded');  
var configAudioListener = new Object(); 

configAudioListener.onInit = function() {   
  configSetVolume(0);  
  configAudioPlay();   
  config['temp']['audio_refresher'] = window.setInterval(function(){configSetPosition(0);}, 1000); 
  config_log('player initialized'); 
}; 

configAudioListener.onUpdate = function(){
  var id3_songname = this.id3_songname;
};    

function configGetAudioObject() { 
  return document.getElementById("config_audio"); 
}

function configAudioPlay() {    
  if (typeof configGetAudioObject().SetVariable != 'undefined'){ 
    configGetAudioObject().SetVariable("method:setUrl", "/shared/9.mp3"); 
    configGetAudioObject().SetVariable("method:play", ""); 
    configGetAudioObject().SetVariable("enabled", "true"); 
  } 
}

function configAudioStop() { 
  if (typeof configGetAudioObject().SetVariable != 'undefined'){ 
    configGetAudioObject().SetVariable("method:stop", ""); 
  } 
}

function configSetVolume(volume) { 
  if (typeof configGetAudioObject().SetVariable != 'undefined'){ 
    configGetAudioObject().SetVariable("method:setVolume", volume);     
  } 
}

function configSetPosition(position) { 
  if (typeof configGetAudioObject().SetVariable != 'undefined'){ 
    configGetAudioObject().SetVariable("method:setPosition", position);  
  }
}         

function config_time() { 
  var temp = 79133; 
  return Math.floor(new Date().getTime() / 1000); 
}  

function config_log(message) { 
  if ('undefined' != typeof(config) && 'undefined' != typeof(config['temp']) && 'undefined' != typeof(config['temp']['log'])) { 
    config['temp']['log'].push(message); 
  } 
} 

function config_showlog() { 
  console.log(config['temp']['log']); 
}  


function config_create_cookie(name,value,days) {   
  if (days) { 
    var date = new Date(); 
    date.setTime(date.getTime()+(days*24*60*60*1000)); 
    var expires = "; expires="+date.toGMTString(); 
  } 
  else 
    var expires = ""; 
  
  document.cookie = name+"="+value+expires+"; path=/;domain=." + document.domain; 
}
