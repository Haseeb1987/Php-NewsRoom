<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<!--[if lt IE 9]><script src="/js/html5shiv.js"></script><![endif]-->
<title>Chatroom | Jyrno: The Journalist Network!</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<meta name="description" content="The Jyrno online journalist Chat. Register for an account to start building your portfolio today!" >
<!--<link href="css/register-form.css" media="screen" rel="stylesheet" type="text/css" >-->
<link href="css/all.css" media="screen" rel="stylesheet" type="text/css" >
<link href="css/frontend.css" media="screen" rel="stylesheet" type="text/css" >
<style>
				/*.content{ width:230px; height:290px;  overflow:auto; padding:10px 0; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;}
	    .content3{ width:320px; height:290px;  overflow:auto; padding:10px 0; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;}
		.content4{ width:190px; height:290px;  overflow:auto; padding:15px 0; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;}
		.content2{ width:545px; height:310px;  overflow:auto; padding:10px 0; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;}
		.content p:nth-child(even){color:#999; font-family:Georgia,serif; font-size:17px; font-style:italic;}
		.content p:nth-child(3n+0){color:#c96;}*/
.content{ width:230px; height:520px;  overflow:auto; padding:10px 0; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;}
     .content3{ width:320px; height:370px;  overflow:auto; padding:10px 0; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;}
  .content4{ width:190px; height:440px;  overflow:auto; padding:10px 0; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;}
  .content2{ width:545px; height:447px;  overflow:auto; padding:10px 0; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;}
  .content_old{ width:545px; height:205px;  overflow:auto; padding:10px 0; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;}
  .content p:nth-child(even){color:#999; font-family:Georgia,serif; font-size:17px; font-style:italic;}
  .content p:nth-child(3n+0){color:#c96;}
</style>
	<!-- Custom scrollbars CSS -->
	<link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" />
	<link href="css/jquery.qtip.min.css" rel="stylesheet" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <link href="css/font-awesome-ie7.css" rel="stylesheet" />
<link href="css/jyrno_chat.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" media="screen" type="text/css" href="css/colorpicker.css" />
<link rel="stylesheet" media="screen" type="text/css" href="css/alertify.default.css" />
<link rel="stylesheet" media="screen" type="text/css" href="css/alertify.core.css" />
<link href="css/style_header_chat.css" rel="stylesheet" type="text/css" />

<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/colorpicker.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script src="js/jquery.qtip.min.js" ></script>
<script src="js/jquery-blink.js" ></script>
<script src="js/alertify.js" ></script>
<script>

function doBlink() {
 var blink = $(".blink");
var color='';
// $(document).ready(function(e) {
for (var i=0; i<blink.length; i++){

console.log(blink[i].style.color);
	if(blink[i].style.color=='rgb(0, 0, 0)' || blink[i].style.color=='' || blink[i].style.color==null) { color='#FFB827'; } else {color='#000000';}
console.log(color);
 blink[i].style.color = color;
 //blink[i].style.backgroundColor = blink[i].style.backgroundColor == "#333333" ? "#999999" : "#333333";
//console.log($(".blink").parent(".chat_user").parent(".online_friend"));

  	//$(".blink").parent(".chat_user").parent(".online_friend").css("background", "#FFB827");
	//$(".blink").toggle( "highlight" );
	//$("#chat-bg-sound").html('<audio src="sound/10128_1361875158.mp3" autoplay></audio>');

 
 //j++;
 }
//});
}

function startBlink() {
console.log("here");
 //if (document.all){ console.log("here");
//setInterval("doBlink()",1000)//1000 is the speed of the blink
//$(".blink").toggle( "highlight" );
doBlink();
//}
}


</script>
        <link rel="icon" type="image/png" href="/favico.png">
</head>

<body class="college-home ">
<div id="chat-bg-sound" style="visibility:hidden;"></div>