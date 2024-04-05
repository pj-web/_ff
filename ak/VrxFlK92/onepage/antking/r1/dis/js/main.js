$(document).ready(function () {

    $('.toform').click(function(){
        $("html, body").animate({scrollTop: $("#form").offset().top-300}, 1500);
        return false;
    });

    var _currentDate = new Date();
    var count = 250; // 8 hours
    var _toDate = new Date(_currentDate.getFullYear(), _currentDate.getMonth(), _currentDate.getDate(), _currentDate.getHours(), _currentDate.getMinutes() + count, 1);

//    $('.timer').countdown({
//        until: _toDate,
//        format: 'HMS',
//        compact: true,
//        layout: $('.timer').html()
//
//    }).removeClass('hidden');

});

