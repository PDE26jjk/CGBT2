<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<title>404 - Lost in the space?  </title>
	<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
	<meta http-equiv="content-language" content="en">
	<meta name="description" content="javascript+canvas starfield">
	<meta name="keywords" content="starfield, star,3d,effect,visual,javascript,canvas,dhtml,webdesign,google,chrome">
	<meta name="author" content="REZ">
	<meta name="generator" content="REZ">
	<meta name="version" content="2.1">
	<meta name="copyright" content="REZ 2007-2009">
	<meta name="robots" content="all">
	<meta name="viewport" content="width=device-width,user-scalable=0,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
	<style type="text/css">
	body  {margin:0;padding:0;background-color:#000000;font-size:0;overflow:hidden}
	div   {margin:0;padding:0;position:absolute;line-height: 0;overflow: hidden;width: 100%;z-index: 999;font-size: 80px;color: #fff;text-align: center;top: 35%;font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;}
	canvas{background-color:#000000;overflow:hidden}
	</style>
</head>

<script type="text/javascript">
function $i(id) { return document.getElementById(id); }
function $r(parent,child) { (document.getElementById(parent)).removeChild(document.getElementById(child)); }
function $t(name) { return document.getElementsByTagName(name); }
function $c(code) { return String.fromCharCode(code); }
function $h(value) { return ('0'+Math.max(0,Math.min(255,Math.round(value))).toString(16)).slice(-2); }
function _i(id,value) { $t('div')[id].innerHTML+=value; }
function _h(value) { return !hires?value:Math.round(value/2); }

function get_screen_size()
	{
	var w=document.documentElement.clientWidth;
	var h=document.documentElement.clientHeight;
	return Array(w,h);
	}

var url=document.location.href;

var flag=true;
var test=true;
var n=parseInt((url.indexOf('n=')!=-1)?url.substring(url.indexOf('n=')+2,((url.substring(url.indexOf('n=')+2,url.length)).indexOf('&')!=-1)?url.indexOf('n=')+2+(url.substring(url.indexOf('n=')+2,url.length)).indexOf('&'):url.length):512);
var w=0;
var h=0;
var x=0;
var y=0;
var z=0;
var star_color_ratio=0;
var star_x_save,star_y_save;
var star_ratio=256;
var star_speed=2;
var star_speed_save=0;
var star=new Array(n);
var color;
var opacity=0.1;

var cursor_x=0;
var cursor_y=0;
var mouse_x=0;
var mouse_y=0;

var canvas_x=0;
var canvas_y=0;
var canvas_w=0;
var canvas_h=0;
var context;

var key;
var ctrl;

var timeout;
var fps=0;

function init()
	{
	var a=0;
	for(var i=0;i<n;i++)
		{
		star[i]=new Array(5);
		star[i][0]=Math.random()*w*2-x*2;
		star[i][1]=Math.random()*h*2-y*2;
		star[i][2]=Math.round(Math.random()*z);
		star[i][3]=0;
		star[i][4]=0;
		}
	var starfield=$i('starfield');
	starfield.style.position='absolute';
	starfield.width=w;
	starfield.height=h;
	context=starfield.getContext('2d');
	//context.lineCap='round';
	context.fillStyle='rgb(0,0,0)';
	context.strokeStyle='rgb(255,255,255)';
	}

function anim()
	{
	mouse_x=cursor_x-x;
	mouse_y=cursor_y-y;
	context.fillRect(0,0,w,h);
	for(var i=0;i<n;i++)
		{
		test=true;
		star_x_save=star[i][3];
		star_y_save=star[i][4];
		star[i][0]+=mouse_x>>4; if(star[i][0]>x<<1) { star[i][0]-=w<<1; test=false; } if(star[i][0]<-x<<1) { star[i][0]+=w<<1; test=false; }
		star[i][1]+=mouse_y>>4; if(star[i][1]>y<<1) { star[i][1]-=h<<1; test=false; } if(star[i][1]<-y<<1) { star[i][1]+=h<<1; test=false; }
		star[i][2]-=star_speed; if(star[i][2]>z) { star[i][2]-=z; test=false; } if(star[i][2]<0) { star[i][2]+=z; test=false; }
		star[i][3]=x+(star[i][0]/star[i][2])*star_ratio;
		star[i][4]=y+(star[i][1]/star[i][2])*star_ratio;
		if(star_x_save>0&&star_x_save<w&&star_y_save>0&&star_y_save<h&&test)
			{
			context.lineWidth=(1-star_color_ratio*star[i][2])*2;
			context.beginPath();
			context.moveTo(star_x_save,star_y_save);
			context.lineTo(star[i][3],star[i][4]);
			context.stroke();
			context.closePath();
			}
		}
	timeout=setTimeout('anim()',fps);
	}

function move(evt)
	{
	evt=evt||event;
	cursor_x=evt.pageX-canvas_x;
	cursor_y=evt.pageY-canvas_y;
	}

function key_manager(evt)
	{
	evt=evt||event;
	key=evt.which||evt.keyCode;
	//ctrl=evt.ctrlKey;
	switch(key)
		{
		case 27:
			flag=flag?false:true;
			if(flag)
				{
				timeout=setTimeout('anim()',fps);
				}
			else
				{
				clearTimeout(timeout);
				}
			break;
		case 32:
			star_speed_save=(star_speed!=0)?star_speed:star_speed_save;
			star_speed=(star_speed!=0)?0:star_speed_save;
			break;
		case 13:
			context.fillStyle='rgba(0,0,0,'+opacity+')';
			break;
		}
	top.status='key='+((key<100)?'0':'')+((key<10)?'0':'')+key;
	}

function release()
	{
	switch(key)
		{
		case 13:
			context.fillStyle='rgb(0,0,0)';
			break;
		}
	}

function mouse_wheel(evt)
	{
	evt=evt||event;
	var delta=0;
	if(evt.wheelDelta)
		{
		delta=evt.wheelDelta/120;
		}
	else if(evt.detail)
		{
		delta=-evt.detail/3;
		}
	star_speed+=(delta>=0)?-0.2:0.2;
	if(evt.preventDefault) evt.preventDefault();
	}

function start()
	{
	resize();
	anim();
	}

function resize()
	{
	w=parseInt((url.indexOf('w=')!=-1)?url.substring(url.indexOf('w=')+2,((url.substring(url.indexOf('w=')+2,url.length)).indexOf('&')!=-1)?url.indexOf('w=')+2+(url.substring(url.indexOf('w=')+2,url.length)).indexOf('&'):url.length):get_screen_size()[0]);
	h=parseInt((url.indexOf('h=')!=-1)?url.substring(url.indexOf('h=')+2,((url.substring(url.indexOf('h=')+2,url.length)).indexOf('&')!=-1)?url.indexOf('h=')+2+(url.substring(url.indexOf('h=')+2,url.length)).indexOf('&'):url.length):get_screen_size()[1]);
	x=Math.round(w/2);
	y=Math.round(h/2);
	z=(w+h)/2;
	star_color_ratio=1/z;
	cursor_x=x;
	cursor_y=y;
	init();
	}

document.onmousemove=move;
document.onkeypress=key_manager;
document.onkeyup=release;
document.onmousewheel=mouse_wheel; if(window.addEventListener) window.addEventListener('DOMMouseScroll',mouse_wheel,false);

setTimeout(function(){window.location.href = "/"},5000);
</script>

<body onload="start()" onresize="resize()" onorientationchange="resize()" onmousedown="context.fillStyle='rgba(0,0,0,'+opacity+')'" onmouseup="context.fillStyle='rgb(0,0,0)'">
<canvas id="starfield" style="background-color:#000000"></canvas>
<div>
	<p>404</p>
	<p style="font-size:24px;color:#48A9DA;">This is not the space for your destination.</p>
</div>
</body>


</html>