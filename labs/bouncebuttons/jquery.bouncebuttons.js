(function($) {
$.fn.bounceButtons = function(initArgs) {
    var args = $.extend({
        "color" : 'white'
    }, initArgs);
    
    $(this).each(function() {
        addHtml(this);
        bounce(this);
    });

    function addHtml(el) {
        $(el).
            wrap('<div class="bouncebutton" />').parent().
            prepend('<div class="bouncebutton-bg" />').
            css('position','relative').find(".bouncebutton-bg").css({
                position : 'absolute',
                background : args.color,
            }).parent().find("a").css({
                // 'position' : 'absolute',
                'outline' : 'none'
            }).focus(function() {
                this.hideFocus = true;
            });
    }

    function bounce(el) {
        var $bg = $(el).parent().find(".bouncebutton-bg");
        var $a = $(el);

        $bg.width($a.width()).css('top', ($a.height() / 2));


        $a.hover(
            function() {
                $bg.animate({
                    height : $a.height(),
                    top : ($bg.height() / 2)
                }, "fast");
            },
            function() {
                $bg.animate({
                    height : '0px',
                    top : ($bg.height() / 2)
                }, "fast");
            }
        );
    }

    return this;
} // $.fn.bounceButtons
})(jQuery);