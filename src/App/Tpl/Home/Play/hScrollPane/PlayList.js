$(".container").hScrollPane({
	mover:".press", //指定container对象下的哪个元素需要滚动位置 | 必传项;
	showArrow:true, //指定是否显示左右箭头，默认不显示 | 可选项;
	//moverW:function(){return $(".press").width();}(), //传入水平滚动对象的长度值,不传入的话默认直接获取mover的宽度值 | 可选项;
	//handleMinWidth:100,//指定handle的最小宽度,要固定handle的宽度请在css中设定handle的width属性（如 width:28px!important;），不传入则不设定最小宽度 | 可选项;
	//dragable:true, //指定是否要支持拖动效果，默认可以拖动 | 可选项;
	//easing:true, //滚动是否需要滑动效果,默认有滑动效果 | 可选项;
	handleCssAlter:"draghandlealter", //指定拖动鼠标时滚动条的样式，不传入该参数则没有变化效果 | 可选项;
	mousewheel:{bind:true,moveLength:500} //mousewheel: bind->'true',绑定mousewheel事件; ->'false',不绑定mousewheel事件；moveLength是指定鼠标滚动一次移动的距离,默认值：{bind:true,moveLength:300} | 可选项;
});

$("#showhide").click(function(){
	$(".container:last").show().hScrollPane({
		mover:".press",
		handleCssAlter:"draghandlealter"
	});
	return false;
});

$(".container2").hScrollPane({
	mover:"ul",
	moverW:function(){return $(".container2 li").length*207-24;}(),
	showArrow:true,
	handleCssAlter:"draghandlealter",
	mousewheel:{moveLength:207}
});