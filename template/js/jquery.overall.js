/* 点击input后Val值消失
--------------------------------------------------------------------*/
function inputTipText(){ 
	$("input[class*=grayTips]") //所有样式名中含有grayTips的input
	.each(function(){
	   var oldVal=$(this).val();     //默认的提示性文本
	   $(this)
	   .css({"color":"#888"})     //灰色
	   .focus(function(){
		if($(this).val()!=oldVal){$(this).css({"color":"#000"})}else{$(this).val("").css({"color":"#888"})}
	   })
	   .blur(function(){
		if($(this).val()==""){$(this).val(oldVal).css({"color":"#888"})}
	   })
	   .keydown(function(){$(this).css({"color":"#000"})})
	})
};
$(document).ready(function(){
	inputTipText();
});


/* 当dbTable的第一个td是checkbox的时添加样式
--------------------------------------------------------------------*/
$(document).ready(function(){
	var c = $('.dbTable').find('tr');
	var d = c.find('td:first');
	var e = d.find('input[type="checkbox"]');
	if (e.length > 0){
		d.css('width','30px');
		
		// 当选中checkbox的时候为所在行添加背景颜色
		e.click(function(){
			var f = $(this).parent('td').parent('tr').find('td');
			if($(this).attr('checked')){
				f.addClass('tr-hover');
			}
			else{
				f.removeClass('tr-hover');
			}
		});
				
		// 当浏览器为ie6时添加此样式
		if ($.browser.msie && ($.browser.version == "6.0") && !$.support.style) {
			c.find('td').css('padding','7px 10px');
			c.find('th').css('padding','7px 10px');
		};
	};
});


/* 全局jquery效果
--------------------------------------------------------------------*/
$(document).ready(function(){
	// 为元素添加clearfix清除浮动
	$('#header, #header-top, #content, #indexMain, #footer, .tab tab-label, .tab .tab-main, .title').addClass('clearfix');
	// 去除a标签及submit按钮的虚线边框	   
	$('a,input[type="submit"]').bind('focus',function(){if(this.blur)this.blur();});
	// 定义所有单选和复选的宽度为auto
	$(':checkbox').css({'width':'auto','vertical-align':'middle','display':'inline-block'});
	$(':radio').css({'width':'auto','vertical-align':'middle','display':'inline-block'});
	// 为表格的偶数行添加隔行变色的背景   
	$('.dbList').find('tbody').find('tr:odd').css('background-color','#f9f9f9');
	// 将表格中每行的最后一个td标签内的文字居右对齐	   
	$('.dbList').find('tbody').find('tr').find('td:last').css('text-align','right');
	// 将表格中每行的最后一个td的宽度统一设置为220像素	   
	$('.dbTable').find('tbody').find('tr').find('td:last').css('width','220px');
	// 选项卡最后一个li加右边框
	$('.tab').find('.tab-label').find('li:last > a').css('border-right','1px #bdbdbd solid');
	// 表单列表分隔线添加外边距
	$('.formList').find('.line').next('tr').find('td').css('padding-top','15px');
	// 表单列表分隔线添加外边距
	$('.formList').find('.form-name').next('tr').find('td').css('padding-top','15px');
});


/* 全局hover效果
--------------------------------------------------------------------*/
$(document).ready(function(){
	// 左边栏app   
	$(".lc-app-main").find('li').hover(function() { 
		$(this).addClass("li-hover");}, function() {
		$(this).removeClass("li-hover");
	});
    // 左边栏app标题
	$(".lc-app-title").hover(function() { 
		$(this).addClass("lc-app-title-hover");}, function() {
		$(this).removeClass("lc-app-title-hover");
	});
    // 右边栏app
	$(".rc-app-main").find('li').hover(function() { 
		$(this).addClass("li-hover");}, function() {
		$(this).removeClass("li-hover");
	});
	// 数据表格的行变色
	$('.dbTable').find('tbody').find('tr').hover(function() { 
		$(this).addClass("tr-hover");}, function() {
		$(this).removeClass("tr-hover");
	});
	// 数据列表的行变色
	$('.dbList').find('tbody').find('tr').hover(function() { 
		$(this).addClass("tr-hover");}, function() {
		$(this).removeClass("tr-hover");
	});
	// 选项卡变色
	$('.tab').find('.tab-label').find('li').hover(function() { 
		$(this).addClass("li-hover");}, function() {
		$(this).removeClass("li-hover");
	});
	// sBtn变色
	$('.sBtn').hover(function() { 
		$(this).find('.left').addClass("left-hover");
		$(this).find('.right').addClass("right-hover");}, function() {
		$(this).find('.left').removeClass("left-hover");
		$(this).find('.right').removeClass("right-hover");
	});
	// sBtn-cancel变色
	$('.sBtn-cancel').hover(function() { 
		$(this).find('.left').addClass("left-hover");
		$(this).find('.right').addClass("right-hover");}, function() {
		$(this).find('.left').removeClass("left-hover");
		$(this).find('.right').removeClass("right-hover");
	});
	// sBtn-cancel变色
	$('#JQtree').find('div').hover(function() { 
		$(this).addClass("JQtreeOrange");}, function() {
		$(this).removeClass("JQtreeOrange");
	});
});