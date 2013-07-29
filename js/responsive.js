jQuery(function($){

	$(window).on('resize', function(){
		if ($(this).width() > 600) {
			$('ul.menu-tmp').remove();
			$('ul.menu').show();
		}
	});

	$('.menu li > ul').parent('li').on('click', function(){
		console.log('Hello World!');
	});

	var liParent = $('ul.menu li > ul').parent('li');

	liParent.children('a').append(' &raquo;')

	liParent.each(function(){
		$(this).children('a').on('click', function(){
			var liLinkOriginalHTML = '<a href="'+$(this).attr('href')+'">'+$(this).text().replace($(this).text().substr(-1), '')+'</a>';

			var ulChildren = $(this).next('ul');
			var content = $(this).parent('li').children('a').next().html();

			$('ul.menu').hide();
			$('.menu-main-container').append('<ul class="menu-tmp"><li><a href="#" class="menu-back-live">&laquo; Voltar</a></li><li>'+liLinkOriginalHTML+'</li>'+content+'</ul>');

			return false;
		});
	});

	$('.menu-back-live').live('click', function(){
		$('.menu-tmp').fadeOut('fast');
		$('.menu-tmp').remove();

		$('.menu').fadeIn();

		return false;
	});

	$('.menu-toggle').live('click', function(event){
		if($('.menu-tmp').length > 0) {
			$('.menu-tmp').remove();
		}
	});
});