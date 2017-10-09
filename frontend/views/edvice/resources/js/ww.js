(function () {
    var $window = $(window);
	$('.article_slider').slick({
        arrows: true,
        dots: true,
        asNavFor: '.article_slider_description'
    });

    $('.article_slider_description').slick({
        arrows: false,
        dots: false,
        asNavFor: '.article_slider',
        fade: true
    });

    $window.load(function() {
      equalheight('.team_list .team_item');
    });


    $window.resize(function(){
      equalheight('.team_list .team_item');
    });

    var $readMore = $('.read_more');
    $readMore.on('click', function (e) {
        e.preventDefault();
        var $height = $(this).prev().find('.t_info_inner').height();
        if($(this).hasClass('open')){
            $height = 75;
        }
        $(this).toggleClass('open');
        $(this).prev().animate({
            'height': $height + 'px'
        })
    });

})();