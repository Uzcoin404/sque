(function($){
    $.fn.extend({ 
        autoresize: function() {
            return this.each(function() {
                hiddenDiv = $(document.createElement('div'));
                content = null;
                $(this).addClass('txtstuff');
                hiddenDiv.addClass('hiddendiv common');
                $('body').append(hiddenDiv);
                content = $(this).val();
                content = content.replace(/\n/g, '<br>');
                hiddenDiv.html(content + "<br class='lbr'>");
                $(this).css('height', hiddenDiv.height()+5);
                $(this).on('keyup', function() {
                    content = $(this).val();
                    content = content.replace(/\n/g, '<br>');
                    hiddenDiv.html(content + "<br class='lbr'>");
                    $(this).css('height', hiddenDiv.height()+5);
                });
            });
        }
    });
})(jQuery);
$('textarea').autoresize();

