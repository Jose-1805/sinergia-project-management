$(document).ready(function() {
  var preInput = ''; // for communicating between event handlers
  var paletteHTML = generateHTML(); //cached array of fully printed html for the palettes
  var selection = 1; //default palette selected

  function fetchPalette() {
    var palettes = new Array();

      //288 Colores en total -> 8 arrays de 12 campos

    palettes[0] = [
        ["e3e3e7","e5e5e6","ecdfec","e6dfec","dfdfe6","dfe6e6","dfe6df","e8e8e0","f9f2df","f4e9df","ecdfdf","e5e4e2"],
        ["c7c7cf","cacbcd","d9bfd9","ccbfd9","bfbfcc","bfcccc","bfccbf","d1d1c0","f2e6bf","e9d4bf","d9bfbf","ccc8c5"],
        ["ababb7","b0b1b4","c69fc6","b39fc6","9f9fb3","9fb3b3","9fb39f","babaa1","ecd99f","ddbe9f","c69f9f","b2ada7"],
        ["8f8f9f","96979b","b380b3","9980b3","808099","809999","809980","a4a481","e6cc80","d2a980","b38080","99928a"],
        ["727287","7b7d81","9f609f","80609f","606080","608080","608060","8d8d62","dfbf60","c79360","9f6060","7f766d"],
        ["56566f","616368","8c408c","66408c","404066","406666","406640","767642","d9b340","bc7d40","8c4040","655b50"],
        ["3a3a57","46494f","792079","4d2079","20204d","204d4d","204d20","5f5f23","d2a620","b06820","792020","4c3f32"],
        ["1e1e3f","2c2f36","660066","330066","000033","003333","003300","484803","cc9900","a55200","660000","322415"]
    ];




    palettes[1] = [
        ["f2dfec","ece6f2","dfdff2","e6ecf9","dfecec","e6ece6","f2f2df","fff9df","fceddf","f2dfdf","ece6df","ffffff"],
        ["e6bfd9","d9cce6","bfbfe6","ccd9f2","bfd9d9","ccd9cc","e6e6bf","fff2bf","f8dabf","e6bfbf","d9ccbf","d8d8d8"],
        ["d99fc6","c6b3d9","9f9fd9","b3c6ec","9fc6c6","b3c6b3","d9d99f","ffec9f","f5c89f","d99f9f","c6b39f","b6b6b6"],
        ["cc80b3","b399cc","8080cc","99b3e6","80b3b3","99b399","cccc80","ffe680","f2b580","cc8080","b39980","929292"],
        ["bf609f","9f80bf","6060bf","809fdf","609f9f","809f80","bfbf60","ffdf60","eea360","bf6060","9f8060","6d6d6d"],
        ["b3408c","8c66b3","4040b3","668cd9","408c8c","668c66","b3b340","ffd940","eb9040","b34040","8c6640","494949"],
        ["a62079","794da6","2020a6","4d79d2","207979","4d794d","a6a620","ffd220","e77e20","a62020","794d20","242424"],
        ["990066","663399","000099","3366CC","006666","336633","999900","FFCC00","E46B00","990000","663300","000000"]
    ];

    palettes[2] = [
        ["fbdbee","ffdfff","f2dfff","ecdfff","dfdff9","e6ecff","dff2f2","dff2df","f2f9df","ffffdf","ffecdf","ffdfdf"],
        ["ffbfe6","ffbfff","e6bfff","d9bfff","bfbff2","ccd9ff","bfe6e6","bfe6bf","e6f2bf","ffffbf","ffd9bf","ffbfbf"],
        ["ff9fd9","ff9fff","d99fff","c69fff","9f9fec","b3c6ff","9fd9d9","9fd99f","d9ec9f","ffff9f","ffc69f","ff9f9f"],
        ["ff80cc","ff80ff","cc80ff","b380ff","8080e6","99b3ff","80cccc","80cc80","cce680","ffff80","ffb380","ff8080"],
        ["ff60bf","ff60ff","bf60ff","9f60ff","6060df","809fff","60bfbf","60bf60","bfdf60","ffff60","ff9f60","ff6060"],
        ["ff40b3","ff40ff","b340ff","8c40ff","4040d9","668cff","40b3b3","40b340","b3d940","ffff40","ff8c40","ff4040"],
        ["ff20a6","ff20ff","a620ff","7920ff","2020d2","4d79ff","20a6a6","20a620","a6d220","ffff20","ff7920","ff2020"],
        ["ff0099","ff00ff","9900ff","6600ff","0000cc","3366ff","009999","009900","99cc00","ffff00","ff6600","ff0000"]
    ];

    //Material  Colors

    palettes[3] = [
        ["ffebee","ffcdd2","ef9a9a","e57373","ef5350","f44336","e53935","d32f2f","c62828","b71c1c","ff8a80","ff5252","ff1744","d50000"],
        ["fce4ec","f8bbd0","f48fb1","f06292","ec407a","e91e63","d81b60","c2185b","ad1457","880e4f","ff80ab","ff4081","f50057","c51162"],
        ["f3e5f5","e1bee7","ce93d8","ba68c8","ab47bc","9c27b0","8e24aa","7b1fa2","6a1b9a","4a148c","ea80fc","e040fb","d500f9","aa00ff"],
        ["ede7f6","d1c4e9","b39ddb","9575cd","7e57c2","673ab7","5e35b1","512da8","4527a0","311b92","b388ff","7c4dff","651fff","6200ea"],
        ["ffebee","ffcdd2","ef9a9a","e57373","ef5350","f44336","e53935","d32f2f","c62828","b71c1c","ff8a80","ff5252","ff1744","d50000"],
        ["fce4ec","f8bbd0","f48fb1","f06292","ec407a","e91e63","d81b60","c2185b","ad1457","880e4f","ff80ab","ff4081","f50057","c51162"],
        ["f3e5f5","e1bee7","ce93d8","ba68c8","ab47bc","9c27b0","8e24aa","7b1fa2","6a1b9a","4a148c","ea80fc","e040fb","d500f9","aa00ff"],
        ["ede7f6","d1c4e9","b39ddb","9575cd","7e57c2","673ab7","5e35b1","512da8","4527a0","311b92","b388ff","7c4dff","651fff","6200ea"],
        ["e8eaf6","c5cae9","9fa8da","7986cb","5c6bc0","3f51b5","3949ab","303f9f","283593","1a237e","8c9eff","536dfe","3d5afe","304ffe"],
        ["e3f2fd","bbdefb","90caf9","64b5f6","42a5f5","2196f3","1e88e5","1976d2","1565c0","0d47a1","82b1ff","448aff","2979ff","2962ff"],
        ["e1f5fe","b3e5fc","81d4fa","4fc3f7","29b6f6","03a9f4","039be5","0288d1","0277bd","01579b","80d8ff","40c4ff","00b0ff","0091ea"],
        ["e0f7fa","b2ebf2","80deea","4dd0e1","26c6da","00bcd4","00acc1","0097a7","00838f","006064","84ffff","18ffff","00e5ff","00b8d4"],
        ["e0f2f1","b2dfdb","80cbc4","4db6ac","26a69a","009688","00897b","00796b","00695c","004d40","a7ffeb","64ffda","1de9b6","00bfa5"],
        ["e8f5e9","c8e6c9","a5d6a7","81c784","66bb6a","4caf50","43a047","388e3c","2e7d32","1b5e20","b9f6ca","69f0ae","00e676","00c853"],
        ["f1f8e9","dcedc8","c5e1a5","aed581","9ccc65","8bc34a","7cb342","689f38","558b2f","33691e","ccff90","b2ff59","76ff03","64dd17"],
        ["f9fbe7","f0f4c3","e6ee9c","dce775","d4e157","cddc39","c0ca33","afb42b","9e9d24","827717","f4ff81","eeff41","c6ff00","aeea00"],
        ["fffde7","fff9c4","fff59d","fff176","ffee58","ffeb3b","fdd835","fbc02d","f9a825","f57f17","ffff8d","ffff00","ffea00","ffd600"],
        ["fff8e1","ffecb3","ffe082","ffd54f","ffca28","ffc107","ffb300","ffa000","ff8f00","ff6f00","ffe57f","ffd740","ffc400","ffab00"],
        ["fff3e0","ffe0b2","ffcc80","ffb74d","ffa726","ff9800","fb8c00","f57c00","ef6c00","e65100","ffd180","ffab40","ff9100","ff6d00"],
        ["fbe9e7","ffccbc","ffab91","ff8a65","ff7043","ff5722","f4511e","e64a19","d84315","bf360c","ff9e80","ff6e40","ff3d00","dd2c00"],
        ["efebe9","d7ccc8","bcaaa4","a1887f","8d6e63","795548","6d4c41","5d4037","4e342e","3e2723"],
        ["fafafa","f5f5f5","eeeeee","e0e0e0","bdbdbd","9e9e9e","757575","616161","424242","212121"],
        ["eceff1","cfd8dc","b0bec5","90a4ae","78909c","607d8b","546e7a","455a64","37474f","263238","000000","ffffff"]
    ];

    return palettes;
  }

  function generateHTML() {
    var palettes = fetchPalette();
    var html = new Array();

    for (var palette in palettes) {
      html[palette] = '<div class="kolorpicker-palette">\
             <ul class="palette-select">\
              <li id="0">Dark</li>\
              <li id="1">Neutral</li>\
              <li id="2">Bright</li>\
              <li id="3">Material</li>\
             </ul>\
            </div>\
            <div class="x-close-box">X</div>\
            <table id="palette-table" cellpadding="0" cellspacing="2" style="border-collapse: separate; border-spacing: 2px; padding: 0px;margin:0; width: 290px;">';

      for (var row in palettes[palette]) {
        html[palette] += '<tr>';
        for (var col in palettes[palette][row]) {
          html[palette] += "<td class='tile' style='font-size:12px;padding:0;margin:0;border:1px solid #333333;cursor:pointer;background:#"+palettes[palette][row][col]+"' id='"+palettes[palette][row][col]+"'>&nbsp</td>";
        }
        html[palette] += '</tr>';
      }

      html[palette] += '</tbody></table>';
    }

   return html;
  }
	
  function displayPicker(input) {
    var parent = $(input).parent();

    if ($(parent).find('div').filter('#kolorPicker').size() == 0) {

      $(input).css('z-index','100');

      $(input).wrap('<div class="kolorPicker-wrapper" style="z-index: 10;" />');

      $('.kolorPicker-wrapper').append('<div id="kolorPicker"></div>');

      $('#kolorPicker').html(paletteHTML[selection]);

      $('li#' + selection).addClass('kolorpicker-palette-select');

      //reset the default auto value that IE sets (0) to 10 so that the picker works in IE
      $(parent).css('z-index','10');

      $('.kolorPicker-wrapper .kolorPicker').focus();

      $('<div/>').attr('class','kolorPickerUI').appendTo('body');
    }
  }

  function cleanPicker() {
    $('.kolorPicker').removeAttr('style'); 
            
    $('#kolorPicker').unwrap();

    $('.kolorPicker-wrapper').remove();
    $('#kolorPicker').remove();
    $('.kolorPickerUI').remove();

    $('.kolorPicker').parent().removeAttr('style');

    $('body').unbind('click.kp');
  }

  $(document).on("click", '.kolorPicker', function () { 
    $('body').bind('click.kp', function (ev) {
      if (!($(ev.target).parents().is(".kolorPicker-wrapper") || $(ev.target).is(".kolorPicker-wrapper"))) {
        cleanPicker();
      }
    });

    displayPicker(this);
  });

  $(document).on("input", '.kolorPicker', function () {
    if ($(this).val().charAt(0) != '#') {
      $(this).val('#' + $(this).val());
    }

    var check = /^#[0-9A-Fa-f]*$/;

    if (!check.test($(this).val())) {
      $(this).val(preInput); // if this value is invalid, restore it to what was valid
    }

    if ($(this).val().length > 7) {
      $(this).val(preInput); // if this value is invalid, restore it to what was valid
    }

    // call the change event on $(this) if you may have an assumed valid hex code
    if ( ($(this).val().length != preInput.length) && ($(this).val().length =  7) ) {
      $(this).change();
    }
  });

  $(document).on("keypress", '.kolorPicker', function (e) {
    preInput = $(this).val(); //catch this value for comparison in keyup

    return true;
  });

  $(document).on("click", '.tile', function(){	
    //get a handle to the div that wraps the input field
    var wrap_div = $(this).parent().parent().parent().parent().parent();

    //get handle to input field to propogate update event
    var input = $(wrap_div).find('input').filter('.kolorPicker');

    //grab from the tile's id
    var color = '#' + $(this).attr('id');

    //unhook ourselves from the page
    cleanPicker();

    //$(input).val(color);
    $(input).parent().children("#background-color").eq(0).val(color);
    $(input).parent().children("#color").eq(0).val(color);
    $(input).parent().children("#border-color").eq(0).val(color);
    $(input).parent().children(".view-color-background").eq(0).css({"background-color":color});
    $(input).parent().children(".view-color").eq(0).css({"background-color":color});
    $(input).parent().children(".view-border-color").eq(0).css({"background-color":color});

    $(input).change();
  });

  $(document).on("click", 'ul.palette-select li', function(){
    selection = $(this).attr('id'); //note which palette we selected

    $('#kolorPicker').html(paletteHTML[selection]);
    $('li#' + selection).addClass('kolorpicker-palette-select');
  });

  $(document).on("click", '.x-close-box', function(){
    cleanPicker();
  });
});
