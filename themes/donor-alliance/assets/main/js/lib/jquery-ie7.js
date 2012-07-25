(function($){
   $(function(){
      var message = 'This site does not support Internet Explorer 7 or below. Please <a href="http://windows.microsoft.com/en-US/windows-vista/Update-Internet-Explorer" target="_blank">update Internet Explorer</a> or consider using <a href="http://www.getfirefox.com" target="_blank">Firefox</a>.',
          div = $('<div id="ie-warning"></div>').html(message).css({
                   'height': '50px',
                   'line-height': '50px',
                   'background-color':'#f9db17',
                   'text-align':'center',
                   'font-family':'Arial, Helvetica, sans-serif',
                   'font-size':'12px',
                   'font-weight':'bold',
                   'color':'black'
                }).hide().find('a').css({color:'#333', textDecoration:'underline'}).end();
      div.prependTo(document.body).slideDown(500);
    });
})(jQuery);