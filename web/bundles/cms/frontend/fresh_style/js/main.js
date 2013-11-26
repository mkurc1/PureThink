//uruchom i ustaw baner
$(function(){

	$('#baner > .container').slidesjs({
        width: 1000,
        height: 296,
        play: {
          auto: true,
          interval: 8000,
          swap: true
        },
        navigation: {
          effect: "fade"
        },
        pagination: {
          effect: "fade"
        },
        effect: {
          fade: {
            speed: 400
          }
        }
      });

});