// JavaScript Document (for the invitational page)
document.getElementById('logoarea').style.opacity='.5';
var width= screen.width;
var w= width*.75;
var h = 265.6;
document.getElementById('logoarea').style.height='265.6px';
document.getElementById('logoarea').style.zIndex='-1';
var xper = 15+Math.round(43*Math.random());
var yper = 15+Math.round(43*Math.random());
var zper = xper+Math.round(15*Math.random());
var qper = yper+Math.round(15*Math.random());



var x = (xper/100)*w;
var y = (yper/100)*h;
var z = (zper/100)*w;
var q = (qper/100)*h;

var colorxdark = 10+Math.round(Math.random()*30)+'%';
var colorx = 'hsla(200,100%,'+colorxdark+',1.00)';

var colorydark = 10+Math.round(Math.random()*30)+'%';
var colory = 'hsla(190,100%,'+colorydark+',1.00)';

var colorzdark = 10+Math.round(Math.random()*30)+'%';
var colorz = 'hsla(230,100%,'+colorzdark+',1.00)';

var colorqdark = 10+Math.round(Math.random()*30)+'%';
var colorq = 'hsla(215,100%,'+colorqdark+',1.00)';


document.getElementById('logotria').style.borderTop =y+"px solid transparent";
document.getElementById('logotria').style.borderBottom =h-y+"px solid transparent";
document.getElementById('logotria').style.borderLeft = x+"px solid "+colorx;

document.getElementById('logotrib').style.borderTop =y+"px solid "+colory;
document.getElementById('logotrib').style.borderLeft =x+"px solid transparent";
document.getElementById('logotrib').style.borderRight = w-x+"px solid transparent";

document.getElementById('logotric').style.borderTop =q+"px solid transparent";
document.getElementById('logotric').style.borderBottom =h-q+"px solid transparent";
document.getElementById('logotric').style.borderRight = w-z+"px solid "+colorq;
document.getElementById('logotric').style.right = '0%';

document.getElementById('logotrid').style.borderBottom =h-q+"px solid "+colorz;
document.getElementById('logotrid').style.borderLeft =z+"px solid transparent";
document.getElementById('logotrid').style.borderRight = w-z+"px solid transparent";
document.getElementById('logotric').style.bottom = '0%';



document.getElementById("scriptfail").innerHTML = "";