<script>
var mute = false;

window.playSound = function() {
if(!mute){
document.getElementById('newMessage').play();

}
}

var sound = document.createElement('audio');
 sound.setAttribute("src","sound.wav");
 sound.id="newMessage";
 
 document.body.appendChild(sound);
</script>
<script>
window.playSoundUser = function() {
if(!mute){
  document.getElementById('newUser').play();

}
}

var sound2 = document.createElement('audio');
 sound.setAttribute("src","10128_1361875158.mp3");
 sound.id="newUser";
 
 document.body.appendChild(sound);
</script>
        <script type="text/javascript">
var needToConfirm = true;
function go_login()
{
needToConfirm = false;
window.location.href='http://www.jyrno.com/auth/login'
}
function go_register()
{
needToConfirm = false;
window.location.href='http://www.jyrno.com/register'
}
       $(function()
        {
            $(window).load(function(event) {
                //$.post('chat_login.php?user_id=<?php echo $user_id; ?>', {});
            });
window.onbeforeunload = function(e) {
if (needToConfirm){
    $.post('chat_logout.php?user_id=<?php echo $user_id; ?>', {});
return "You are going away from Jyrno Newsroom.";
}
};
        });
        </script>
<script>
$('#colorbox').ColorPicker({
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('#colorbox div').css('backgroundColor', '#' + hex);
		$('#colorbox').attr("rel",'#'+hex);
	}
});
</script>
<script type="text/javascript">
// jQuery Document
var load_old="no";var cc='0';
var current_private='0';
$(document).ready(function(){
$.post('chat_login.php?user_id=<?php echo $user_id; ?>', {});
/*$('.public_chatroom').filter(function(){
    return $(this).text() == "current";
}).parent().addClass('disabled');
$(".public_chatroom#1").parent().addClass("current");*/
loadLog();
loadUsers();
loadFriends();
loadPublicChatrooms();

loadPrivateChatrooms();
var displayOverlay = false;
$(".popup_close").click(function() {
$('#fade , #popup1 , #popup2 , #popup3').fadeOut();
});
$('body').children().ajaxStart(function(){
    if(displayOverlay){
        $('.ajax-loading').show();
    }
});
 
$('body').children().ajaxStop(function(){
    displayOverlay = false;
    $('.ajax-loading').hide();
});
$(".tab_content_left").hide(); //Hide all content
 $("ul#tabs1 li:first").addClass("active").show(); //Activate first tab
 $(".tab_content_left:first").show(); //Show first tab content
 
 //On Click Event
 $("ul#tabs1 li").click(function() {
 
  $("ul#tabs1 li").removeClass("active"); //Remove any "active" class
  $(this).addClass("active"); //Add "active" class to selected tab
  $(".tab_content_left").hide(); //Hide all tab content
 
  var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
  $(activeTab).fadeIn(); //Fade in the active ID content
  return false;
 });
$(".tab_content").hide(); //Hide all content
 $("ul#tabs2 li:first").addClass("active").show(); //Activate first tab
 $(".tab_content:first").show(); //Show first tab content
 
 //On Click Event
 $("ul#tabs2 li").click(function() {
 
  $("ul#tabs2 li").removeClass("active"); //Remove any "active" class
  $(this).addClass("active"); //Add "active" class to selected tab
  $(".tab_content").hide(); //Hide all tab content
 
  var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
  $(activeTab).fadeIn(); //Fade in the active ID content
  return false;
 });
	function post_last_message()
	{
		var oldscrollHeight = $("#content_2").get(0).scrollHeight - 20;
		var current_chatroom=$("#submitmsg").attr("rel");
		$.ajax({
			url: "post_last_message.php",
			data : 'id='+current_chatroom,
			cache: false,
			success: function(html){
				$("#chatbox").append(html);
				var newscrollHeight = $("#content_2").get(0).scrollHeight - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#content_2").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}
				}
		});
	}
	$("#view_old_messages").click(function(){
		load_old="yes";
		$(this).hide();
		$("#hide_old_messages").show();
		return false;
	});
	$("#check_pass").click(function(){
		var pass = $("#private_pass").val();
		var room = $("#private_room_id").val();
		if(pass=='') { $("#emptypasserror").show(); return false; }
		else $("#emptypasserror").hide();
		$.ajax({
			url: "check_password.php",
			cache: false,
			data : 'room='+room+'&password='+pass,
			success: function(html){
						if(html=="correct") {
current_private=room;
loadUsers();
		$("#wrongpasserror").hide();
		$('.private_chatroom').removeClass("current");
		$('.public_chatroom').removeClass("current");
		$('.private_chatroom#'+room).parent().addClass("current");
		cc=$('.private_chatroom#'+room).text();
		var curr_room_text='You have now entered chat room "'+cc+'"';
		$("#curr_room_msg").html(curr_room_text);
		$('#fade , #popup1 , #popup2 , #popup3').fadeOut();
		$("#submitmsg").attr("rel",room);
		var oldscrollHeight = $("#content_2").get(0).scrollHeight - 20;
		$.ajax({
			url: "get_chatroom_messages.php",
			data : 'id='+room,
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				
			//Auto-scroll			
				var newscrollHeight = $("#content_2").get(0).scrollHeight - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#content_2").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		}); 
						 }
						else{ $("#private_pass").val(''); $("#wrongpasserror").show();
								return false;
							}
						
				}
		});	
		return false;
	});
	$("#hide_old_messages").click(function(){
		load_old="no";
		$(this).hide();
		$("#view_old_messages").show();
		return false;
	});
	//If user submits the form
	$("#submitmsg").click(function(){

		var clientmsg = $("#usermsg").val();
	if(clientmsg=='' || $.trim(clientmsg).length==0) { $("#emptymsgerror").show(); return false; }
	else $("#emptymsgerror").hide();
		var current_chatroom=$("#submitmsg").attr("rel");
		$.post("post_message.php?user_id=<?php echo $user_id; ?>", {text: clientmsg , chatroom_id : current_chatroom});			
		$("#usermsg").attr("value", "");
		$("#usermsg").val('');
		if($('#notify').length > 0) { $('#notify').hide();  }
		//post_last_message();
		return false;
	});
	$("#change_color_button").click(function(){
		var color = $("#colorbox").attr('rel');
		//$(".choice").removeClass("selected");
		//$('#'+color).addClass("selected");
		$.post("change_color.php?user_id=<?php echo $user_id; ?>", {color: color});			
		return false;
	});
	$("#create_public_room").click(function(){
		var public_chatroom_name = $("#public_chatroom_name").val();
		var public_chatroom_description = $("#public_chatroom_description").val();

		if(public_chatroom_name=='') { $("#nameexisterrorpu").hide(); $("#emptynameerrorpu").show();return false; }
		else $("#emptynameerrorpu").hide();
		$.ajax({
			url: "checkname.php",
			cache: false,
			data : 'name='+public_chatroom_name,
			success: function(html){
						if(html>0) { $("#emptynameerrorpu").hide(); $("#nameexisterrorpu").show(); return false; }
						else{ $("#nameexisterrorpu").hide(); $("#emptynameerrorpu").hide();
		$.post("create_public_chatroom.php?user_id=<?php echo $user_id; ?>", {text: public_chatroom_name, description: public_chatroom_description});				
		$("#public_chatroom_name").attr("value", "");
		$("#public_chatroom_name").val('');
		$('#fade , #popup1 , #popup2 , #popup3').fadeOut();
		loadPublicChatrooms();
//cc=$("a.public_chatroom").first().text();
var msg="Congrats! You have created a new room, click here to go to it!";
alertify.confirm(msg, function (e) {
    if (e) {
 cc=$("a.public_chatroom").first().text(); 
console.log(cc);      
		displayOverlay = true;
		var chatroom_id = $("a.public_chatroom").first().attr('id');
		$('.public_chatroom').parent().removeClass("current");
		$("a.public_chatroom").first().parent().addClass("current");
		$("#submitmsg").attr("rel",chatroom_id);
		var oldscrollHeight = $("#content_2").get(0).scrollHeight - 20;
		$.ajax({
			url: "get_chatroom_messages.php",
			data : 'id='+chatroom_id+'&load_old='+load_old+'&user_id='+<?php echo $user_id; ?>,
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				
			//Auto-scroll			
				var newscrollHeight = $("#content_2").get(0).scrollHeight - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#content_2").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
    } else {
        // user clicked "cancel"
    }
});
		return false; }
						
				}
		});
	});
	$("#create_private_room").click(function(){
		var private_chatroom_name = $("#private_chatroom_name").val();
		var private_chatroom_description = $("#private_chatroom_description").val();
		var private_password = $("#private_password").val();
		if(private_chatroom_name=='') { $("#nameexisterrorpr").hide(); $("#emptypasserrorpr").hide(); $("#emptynameerrorpr").show(); return false; }
		else{ $("#nameexisterrorpr").hide(); }
		if(private_password=='') { $("#nameexisterrorpr").hide(); $("#emptynameerrorpr").hide(); $("#emptypasserrorpr").show(); return false; }
		else $("#nameexisterrorpr").hide();
		$.ajax({
			url: "checkname.php",
			cache: false,
			data : 'name='+private_chatroom_name,
			success: function(html){
						if(html>0) { $("#emptynameerrorpr").hide(); $("#nameexisterrorpr").show(); return false; }
						else{ $("#nameexisterrorpr").hide(); $("#emptynameerrorpr").hide(); $("#emptypasserrorpr").hide();
		var users = $('input[name=add_private_user]:checked').map(function() {
        return $(this).val();
    	}).get();
		var data = {
    		text: private_chatroom_name,
			description: private_chatroom_description,
			private_password : private_password,
    		'users[]': users,
    	};
		users.push("<?php echo $user_id; ?>");
		$.post("create_private_chatroom.php?user_id=<?php echo $user_id; ?>", data);				
		$("#private_chatroom_name").attr("value", "");
		$("#private_chatroom_name").val('');
		$("#private_chatroom_description").val('');
		$('#pass').show();
		$("#success_pass").hide();
		$('#fade , #popup1 , #popup2 , #popup3').fadeOut();
		loadPrivateChatrooms();
var msg="Congrats! You have created a new room, click here to go to it!";
alertify.confirm(msg, function (e) {
    if (e) {
 cc=$("a.private_chatroom").first().text(); 
console.log(cc);      
		displayOverlay = true;
		var chatroom_id = $("a.private_chatroom").first().attr('id');
		$('.private_chatroom').parent().removeClass("current");
		$("a.private_chatroom").first().parent().addClass("current");
		$("#submitmsg").attr("rel",chatroom_id);
		var oldscrollHeight = $("#content_2").get(0).scrollHeight - 20;
		$.ajax({
			url: "get_chatroom_messages.php",
			data : 'id='+chatroom_id+'&load_old='+load_old+'&user_id='+<?php echo $user_id; ?>,
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				
			//Auto-scroll			
				var newscrollHeight = $("#content_2").get(0).scrollHeight - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#content_2").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
    } else {
        // user clicked "cancel"
    }
});
		return false; }
						
				}
		});
	});
	function post()
	{
		var clientmsg = $("#usermsg").val();
		$.post("post_message.php?user_id=<?php echo $user_id; ?>", {text: clientmsg});				
		$("#usermsg").attr("value", "");
		$("#usermsg").val('');
		//post_last_message();
		return false;
	}
});
	function loadUsers(){		
		var oldscrollHeight = $("#content_1").get(0).scrollHeight - 20;
		$.ajax({
			url: "get_users.php?current_private="+current_private,
			data : 'place=content_1',
			cache: false,
			success: function(html){		
				$("#content_1").html(html); //Insert chat log into the #chatbox div	
				//startBlink();
				
			//Auto-scroll			
				var newscrollHeight = $("#content_1").get(0).scrollHeight - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#content_1").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
function countUsers(){	
			var count=$('#total_online_users').val();
		$.ajax({
			url: "count_users.php",
			data : 'total_online='+count,
			cache: false,
			success: function(html){		
				if(html!=count){ console.log("dssd"); $('#total_online_users').val(html);  loadUsers(); playSoundUser(); startBlink();  }
				/*else { $(".blink").className = '';$(".chat_user a").removeClass(); }*/
		  	},
		});
	}
var countusers = setInterval (countUsers, 1000); 
function countpublic(){	
			var count=$('#total_public').val();
		$.ajax({
			url: "count_public.php",
			data : 'total_public='+count,
			cache: false,
			success: function(html){		
				if(html!=count){console.log("dssdccc"); $('#total_public').val(html);  loadPublicChatrooms(); playSoundUser(); startBlink(); }
		  	},
		});
	}
var countPublic = setInterval (countpublic, 1000);
function countprivate(){	
			var count=$('#total_private').val();
		$.ajax({
			url: "count_private.php",
			data : 'total_private='+count,
			cache: false,
			success: function(html){		
				if(html!=count){console.log("dssdccc"); $('#total_private').val(html);  loadPublicChatrooms(); playSoundUser(); startBlink(); }
		  	},
		});
	}
var countPrivate = setInterval (countprivate, 1000);
	//Load the file containing the chat log
	function loadLog(){		
		var oldscrollHeight = $("#content_2").get(0).scrollHeight - 20;
		var current_chatroom=$("#submitmsg").attr("rel");
		$.ajax({
			url: "get_chatroom_messages.php",
			data : 'id='+current_chatroom+'&load_old='+load_old+'&user_id='+<?php echo $user_id; ?>,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				
			//Auto-scroll			
				var newscrollHeight = $("#content_2").get(0).scrollHeight - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					playSound();
					$("#content_2").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
var loadmsgs = setInterval (loadLog, 1000); 
	//Load the file containing the chat log

	function loadFriends(){		
		var oldscrollHeight = $("#content_1f").get(0).scrollHeight - 20;
		$.ajax({
			url: "get_friends.php",
			data : 'user_id='+<?php echo $user_id; ?>,
			cache: false,
			success: function(html){		
				$("#content_1f").html(html); //Insert chat log into the #chatbox div	
				
			//Auto-scroll			
				var newscrollHeight = $("#content_1f").get(0).scrollHeight - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#content_1f").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
var loadfriends = setInterval (loadFriends, 10000);

	function loadPublicChatrooms(){		
		//var oldscrollHeight = $("#content_4").get(0).scrollHeight - 20;
		$.ajax({
			url: "get_public_chatrooms.php",
			data : 'user_id='+<?php echo $user_id; ?>,
			cache: false,
			success: function(html){		
				$("#content_4").html(html); //Insert chat log into the #chatbox div	
if(cc=='0'){
				$('.public_chatroom').filter(function(){
    return $(this).text() == "general";
}).parent().addClass('current');
console.log(cc);
$("#curr_room_msg").html('You have now entered chat room "General"');
}
else
{
				$('.public_chatroom').filter(function(){
    return $(this).text() == cc;
}).parent().addClass('current');
console.log(cc);
//$("#curr_room_msg").html('You have now entered chat room "General"');
 var curr_room_text='You have now entered chat room "'+cc+'"';
$("#curr_room_msg").html(curr_room_text);
}			
		  	},
		});
	}
var loadpublicchatrooms = setInterval (loadPublicChatrooms, 1000); 
	function loadPrivateChatrooms(){		
		$.ajax({
			url: "get_private_chatrooms.php",
			data : 'user_id='+<?php echo $user_id; ?>,
			cache: false,
			success: function(html){		
				$("#content_5").html(html); //Insert chat log into the #chatbox div	
if(cc!='0'){
$('.private_chatroom').filter(function(){
    return $(this).text() == cc;
}).parent().addClass('current');
}				
		  	},
		});
	}	
var loadprivatechatrooms = setInterval (loadPrivateChatrooms, 50000);
	function loadRequests(){
		$.ajax({
			url: "get_requests.php",
			data : 'user_id='+<?php echo $user_id; ?>,
			cache: false,
			success: function(html){
				if(html==0) $("#request").hide();	
				else $("#request").html(html).show(); //Insert chat log into the #chatbox div				
		  	},
		});
	}
var loadrequests = setInterval (loadRequests, 5000);
		$("#content_4").on('click', 'a.public_chatroom', function(event) {
		event.preventDefault();
		cc=$(this).text();
		displayOverlay = true;
		var chatroom_id = $(this).attr('id');
		$('.public_chatroom').parent().removeClass("current");
		$(this).parent().addClass("current");
		$("#submitmsg").attr("rel",chatroom_id);
		var oldscrollHeight = $("#content_2").get(0).scrollHeight - 20;
		$.ajax({
			url: "get_chatroom_messages.php",
			data : 'id='+chatroom_id+'&load_old='+load_old+'&user_id='+<?php echo $user_id; ?>,
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				
			//Auto-scroll			
				var newscrollHeight = $("#content_2").get(0).scrollHeight - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#content_2").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
		return false;
	});
		$("#content_5").on('click', 'a.private_chatroom', function(event) {
		event.preventDefault();
		//cc=$(this).text();
		var chatroom_id = $(this).attr('id');
		$("#private_room_id").val(chatroom_id);
		$("#wrongpasserror").hide();
		$("#emptypasserror").hide();
		var popupid = "popup3";
		$('#' + popupid).fadeIn();
		
		$('body').append('<div id="fade"></div>');
		$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
		 
		var popuptopmargin = ($('#' + popupid).height() + 10) / 2;
		var popupleftmargin = ($('#' + popupid).width() + 10) / 2;
		$('#' + popupid).css({
		'margin-top' : -popuptopmargin,
		'margin-left' : -popupleftmargin
		});
		/*displayOverlay = true;
		var chatroom_id = $(this).attr('id');
		$('.private_chatroom').parent().removeClass("current");
		$(this).parent().addClass("current");
		$("#submitmsg").attr("rel",chatroom_id);
		var oldscrollHeight = $("#content_2").get(0).scrollHeight - 20;
		$.ajax({
			url: "get_chatroom_messages.php",
			data :'id='+chatroom_id+'&load_old='+load_old+'&user_id='+<?php echo $user_id; ?>,
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				
			//Auto-scroll			
				var newscrollHeight = $("#content_2").get(0).scrollHeight - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#content_2").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},*/
		//});
		return false;
	});
$("#content_5").on('click', 'input.accept', function(event) {
		event.preventDefault();
		var chatroom_id = $(this).attr('rel');
		var that=$(this);
cc=$(".chatroom_name#prc"+chatroom_id).text();
console.log(cc);
		$.ajax({
			url: "handle_request.php",
			data : 'id='+chatroom_id+'&action=accepted&user_id='+<?php echo $user_id; ?>,
			cache: false,
			success: function(html){
		$('.private_chatroom').removeClass("current");
		$('.public_chatroom').removeClass("current");
		$(".chatroom_name#prc"+chatroom_id).addClass("current");
		$("#submitmsg").attr("rel",chatroom_id);
		var oldscrollHeight = $("#content_2").get(0).scrollHeight - 20;
		$.ajax({
			url: "get_chatroom_messages.php",
			data :'id='+chatroom_id+'&load_old='+load_old+'&user_id='+<?php echo $user_id; ?>,
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				
			//Auto-scroll			
				var newscrollHeight = $("#content_2").get(0).scrollHeight - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#content_2").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});		
				loadPrivateChatrooms();
				loadRequests();
		  	},
		});
		return false;
	});
$("#content_5").on('click', 'input.reject', function(event) {
		event.preventDefault();
		var chatroom_id = $(this).attr('rel');
		$.ajax({
			url: "handle_request.php",
			data : 'id='+chatroom_id+'&action=rejected&user_id='+<?php echo $user_id; ?>,
			cache: false,
			success: function(html){		
				loadPrivateChatrooms();
				loadRequests();
		  	},
		});
		return false;
	});
		$("#content_4").on('click', 'a.delete_chatroom', function(event) {
		event.preventDefault();
		displayOverlay = true;
		var chatroom_id = $(this).attr('id');
		$.ajax({
					url: "can_delete_chatroom.php",
					data : 'id='+chatroom_id,
					cache: false,
					success: function(html){
						if(html=="yes")	{
							  var agree=confirm("Are you sure you want to delete this chatroom permanently?");
							  if (agree){
									  $.ajax({
										  url: "delete_chatroom.php",
										  data : 'id='+chatroom_id,
										  cache: false,
										  success: function(html){		
											  //loadPrivateChatrooms();	
											  loadPublicChatrooms();				
										  },
									  });
							  }else
							  { return false;}	
							 }
							else alert("This chatroom is being used this time, Please try Later");		
					},
				});
		
	});
		$("#content_5").on('click', 'a.delete_chatroom', function(event) {
		event.preventDefault();
		displayOverlay = true;
		var chatroom_id = $(this).attr('id');
		$.ajax({
					url: "can_delete_chatroom.php",
					data : 'id='+chatroom_id,
					cache: false,
					success: function(html){
						if(html=="yes")	{
							  var agree=confirm("Are you sure you want to delete this chatroom permanently?");
							  if (agree){
									  $.ajax({
										  url: "delete_chatroom.php",
										  data : 'id='+chatroom_id,
										  cache: false,
										  success: function(html){		
											  loadPrivateChatrooms();	
											  //loadPublicChatrooms();				
										  },
									  });
							  }else
							  { return false;}	
							 }
							else alert("This chatroom is being used this time, Please try Later");		
					},
				});
	});
$("#content_4").on('mouseover', '.info_chatroom', function(event) {

    // Bind the qTip within the event handler
	var text=$(this).next('div').text();
    $(this).qtip({
        overwrite: false, // Make sure the tooltip won't be overridden once created
        content: text,
style: {
        classes: 'qtip-blue qtip-tipsy'
    },
        show: {
            event: event.type, // Use the same show event as the one that triggered the event handler
            ready: true // Show the tooltip as soon as it's bound, vital so it shows up the first time you hover!
        }
    }, event); // Pass through our original event to qTip
}).each(function(i) {
    $.attr(this, 'oldtitle', $.attr(this, 'title'));
    this.removeAttribute('title');
});
 $('.chatroom_name:first').addClass("current");
$("#content_5").on('mouseover', '.info_chatroom', function(event) {
    // Bind the qTip within the event handler
	var text=$(this).next('div').text();
    $(this).qtip({
        overwrite: false, // Make sure the tooltip won't be overridden once created
        content: text,
		    style: {
        classes: 'qtip-blue qtip-tipsy'
    },
        show: {
            event: event.type, // Use the same show event as the one that triggered the event handler
            ready: true // Show the tooltip as soon as it's bound, vital so it shows up the first time you hover!
        }
    }, event); // Pass through our original event to qTip
}).each(function(i) {
    $.attr(this, 'oldtitle', $.attr(this, 'title'));
    this.removeAttribute('title');
});
//var loadchatrooms = setInterval (loadChatrooms, 15000);
	function get_last_message_time(){		
		$.ajax({
			url: "get_last_message_time.php",
			data : 'user_id='+<?php echo $user_id; ?>,
			cache: false,
			success: function(html){		
				if(html=="logout"){ $.post('chat_logout.php?user_id=<?php echo $user_id; ?>', {}); $("#chatbox").html("your chat session has been expired");}		
		  	},
		});
	}	
var get_last_message_time = setInterval (get_last_message_time, 300000);
</script>