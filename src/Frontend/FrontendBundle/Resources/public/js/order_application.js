$(document).ready(function(){
		var tb=$(".seven_container").superseven({
			width:270,
			height:400,
			autoplay:true,
			interval:5,
			fullwidth:false,
			responsive:false,
			progressbar:true,
			progressbartype:'linear',
			swipe:false,
			keyboard:false,
			scrollmode:false,
			animation:144,
			caption_animation: 0,
			bullets:false,
			thumbnail:false,
			repeat_mode:true,
			skin:'sharp',
			lightbox:false,
			pause_on_hover:true	,
			onanimstart:function(){},
			onanimend:function(){},
			onvideoplay:function(){},
			onslidechange:function(){}						
		});
		
	});