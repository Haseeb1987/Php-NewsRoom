<?php session_start();

include 'includes/DB.php';
if(!isset($_SESSION['Auth']['id'])){
        $logged_in=0;
		$user_id=0;
		$user_type=0;
		$login_time=0;
		$chat_color=0;
}
else { $logged_in=1;
 $user_id=$_SESSION['Auth']['id'];
$sql="SELECT login_time,type,chat_color FROM users WHERE id='$user_id' limit 1";
$result=$con->query($sql);
	$count=$result->rowCount();
	  while($row = $result->fetch(PDO::FETCH_ASSOC))
	  {
			$user_type=$row['type'];
			$login_time=$row['login_time'];
			$chat_color=$row['chat_color'];
	  }

 }
$sql="SELECT login_time FROM users WHERE chat_login='1'";
$result=$con->query($sql);
	$countu=$result->rowCount();
$sql="SELECT name FROM chatrooms WHERE type='public'";
$result=$con->query($sql);
	$countpb=$result->rowCount();
$sql="SELECT name FROM chatrooms WHERE type='private'";
$result=$con->query($sql);
	$countpr=$result->rowCount();
//$_SESSION['total_online_users']=$count;
?>
<?php include 'includes/functions.php'; ?>
<?php include('header.php'); ?>


<div id="wrapper">
<input type="hidden" id="total_online_users" value="<?php echo $countu; ?>" />
<input type="hidden" id="total_public" value="<?php echo $countpb; ?>" />
<input type="hidden" id="total_private" value="<?php echo $countr; ?>" />
<input type="hidden" id="new_room_id" value="" />
<div id="header">
				<div class="h1">
					<div class="h2">
						<div class="topnav">
							<div class="right"></div>
							<div class="center">
								<ul>
                                                                        	<li><div style="position:relative;background:rgb(255, 184, 39) no-repeat 188px 6px;border:none;border-radius:10px;font-size:15px;padding:6px;position:relative;top:25px;left:210px;width:200px;height:19px;color:rgba(255,255,255,.5)"><span class="searchText">Search <span class="jyrnofont">Jyrno</span></span><form action="/search/all"><input type="text" onBlur="searchFill();" onFocus="searchClear();" style="position:absolute;top:5px;width:173px;background:none;border:none;height:20px" name="search" class="searchInput"></form></div></li>
                                    	<?php if($logged_in==0) { ?><li style="position:relative;right:69px;"><a href="http://www.jyrno.com/register">Sign Up</a></li>
                                        <li style="position:relative;right:46px;"><a href="http://www.jyrno.com/auth/login">Login</a></li>
										<?php } else { ?>
<li><a href="http://www.jyrno.com/my-account/index">My Portfolio</a></li>
<li><a href="http://www.jyrno.com/my-account/edit">Edit Account</a></li>
                                        <li><a href="http://www.jyrno.com/auth/logout">Logout</a></li>
<?php } ?>
                                    								</ul>
							</div>
							<div class="left"></div>
						</div>
						<h1><a href="/">The College Press</a></h1>
					</div>
				</div>
			</div>
<div class="w1">
				<div class="w2">
					<div class="nav-place">
						<div class="nav-holder">
							<ul id="nav">
								<li><a href="/">Home</a></li>
								<li><a href="/about">About</a></li>
								<li><a href="/blog">Company Blog</a></li>
								<li><a href="/staff">Staff</a></li>
								<li><a href="/search/all">Archives</a></li>
								<li><a href="/contact">Contact</a></li>
							</ul>
						</div>
					</div>
					<div class="categories">
						<ul>
							<li class="world"><a href="/world">World</a></li><li class="health"><a href="/health">Health</a></li><li class="entertainment"><a href="/entertainment">Entertainment</a></li><li class="sports"><a href="/sports">Sports</a></li><li class="technology"><a href="/technology">Technology</a></li><li class="science"><a href="/science">Science</a></li><li class="politics"><a href="/politics">Politics</a></li><li class="travel"><a href="/travel">Travel</a></li><li class="opinion"><a href="/opinion">Opinion</a></li><li class="education"><a href="/education">Education</a></li>						</ul>
					</div>
					<div id="container">
						<div class="container-holder ">
							<div id="main">
<div class="chat_wrapper">
<div class="chat_header">
        	<div class="actlist" style="margin-top:30px;">
                		<span class="plug"><img src="images/plug.png" width="123" height="106" alt="image" /></span>
                    	<h2 class="txtStroke"><img src="images/plugTxt.png" width="556" height="57" alt="image" /></h2>
                	</div>
        </div>
				<?php if($logged_in!=1) { ?>
				<div class="login_prompt">
                	<p>You need to login first before joining Jyrno Chat</p>
                <div class="login_options">
                	<input type="button" class="chat_btn" style="background-color:#E49904; border-radius:5px; font-weight:bold; cursor:pointer" value="Login" onClick="needToConfirm = false; go_login();" id="submitmsg" rel="1"/>
					<input type="button" class="chat_btn" style="background-color:#1560A6; border-radius:5px;font-weight:bold; cursor:pointer" value="Register" onClick="needToConfirm = false; go_register();" />
                </div>
				</div>
				<?php } ?>
	<div class="chat_wrapper_container" <?php if($logged_in!=1){ ?> style="opacity:0.5" <?php } ?>>
    	
    	<div class="chat_container_left">
        <div class="heading_chat">
				     <ul class="tabs" id="tabs1">
    				<li><a href="#content_1">Online Users</a></li>
    				<li><a href="#content_1f">Friends</a></li>
					</ul>
            	
            </div>
        <div id="content_1" class="content tab_content_left">
<div class="loading"><img src="images/ajax-loader.gif"  class="loadingimg"/></div>
		</div>
        <div id="content_1f" class="content tab_content_left">
		</div>
        </div>
        <div class="chat_container_right">
			<?php if($user_type==1){ ?> <div id="view_old" style="text-align:center;height:20px;padding-top:3px;width:50%; margin:3px auto; background:#ccc;"><a href="" id="view_old_messages">Load old conversations</a><a href="" id="hide_old_messages" style="display:none">Hide old conversations</a></div> <?php } ?>
			 <div class="color-choices"><div id="colorbox" style="position:relative; float:left; height: 30px;width: 30px; cursor:pointer;" rel="<?php echo $chat_color; ?>">
<script>
function chup(){
if(!mute){
document.getElementById('volume').style.display= 'none';
document.getElementById('mute').style.display= 'block';
mute = true;
}
else{
document.getElementById('mute').style.display= 'none';
document.getElementById('volume').style.display= 'block';
mute = false;
}
}
</script>
<div style=" <?php if ($chat_color!="") echo "background: ".$chat_color.";" ?>height: 25px;
    left: 3px;
    position: absolute;
    top: 3px;
    width: 25px;border:1px dashed"></div></div><a id="change_color_button" href="#" style="float:left; margin-top:10px;margin-left: 5px;padding-right:15px;"><img src="images/done.png" width="12px" height="12px"/></a>
<div style="float: left; width: 400px; border-right:2px solid;border-left:2px solid; height:27px; padding-top: 8px;font-weight: bold;" id="curr_room_msg"></div>
<div style="float:left; margin-left:15px"><a id="sound_toggle" href="#"  rel="on"><img id="volume" onclick="chup();" src="images/son.png" width="32px" height="32px"/> <img id="mute" onclick="chup();" src="images/son1.png" style="display:none;" width="32px" height="32px"/></a></div><!--<div style="margin-left:176px">
			<a href="#" class="choice" id="gray" title="Default"></a><a href="#" class="choice" id="black" title="Black"></a><a href="#" class="choice" id="yellow" title="Yellow"></a><a href="#" class="choice" id="green" title="Green"></a><a href="#" class="choice" id="red" title="Red"></a><a href="#" class="choice" id="blue" title="Blue"></a><a href="#" class="choice" id="pink" title="Pink"></a></div>--></div>
        	 <div id="content_2" class="content2" <?php if($user_type==1){ ?> style="height:435px <?php } ?>">
				<div id="chatbox">
                <div class="loading"><img src="images/ajax-loader.gif"  class="loadingimg"/></div>
				</div>
				            </div> <!-- End of content_2 -->
             <div class="chat_input">
				<form name="sendmsg" id="sendmsg">
				<?php if($logged_in==1){ ?>
				
             	<div class="chat_message_input">
                	<input type="text" class="message_chat" id="usermsg" placeholder="type your message here..."/>
                </div>
                <div class="send_btn_chat">
                	<input type="submit" class="chat_btn" value="Send" id="submitmsg" rel="1"/>
                </div>
				<?php } ?>
			<p id="emptymsgerror">Come On.....Type Something!</p>
 				</form>
             </div> <!-- End of chat_input -->
        </div> <!-- End of chat_container_right -->
        <div class="chat_container_groups">
            <div class="heading_group">
                   <ul class="tabs" id="tabs2">
    				<li><a href="#content_4">Public</a></li>
    				<li><a href="#content_5">Private <span id="request" style="display:none">0</span></a></li>
					</ul>
            </div>
            <div id="content_4" class="content4 tab_content" title="Public Groups Display">
			<div class="chat_group">
                    <div class="loading"><img src="images/ajax-loader.gif"  class="loadingimg"/></div> 
             </div>
			</div><!-- End of content_4 -->
            <div id="content_5" class="content4 tab_content" title="Private Groups Display">
			</div><!-- End of content_5 -->      
            <div class="create_public_group">
                <div id="trigger_public_group_popup"><a href="#" rel="popup2" class="popup"><p style="float:left; margin:0;"><i class="icon-edit icon-2x"></i></p><P style="float:left; margin-top:5px">Create Public Chat Room</P>
                </a></div>               
            </div>
            <div class="creat_group">
            	<div id="trigger"><a href="#" rel="popup1" class="popup"><p style="float:left; margin:0;"><i class="icon-edit icon-2x"></i></p><P style="float:left; margin-top:5px">Create Private Chat Room</p>
                </a></div>               
            </div>
		</div> <!-- End of chat_container_groups -->
    </div>
</div>
</div></div>
<?php require_once('footer.php'); ?>
<?php require_once('create_group_popup.php') ;?> 
</div>
</div>
<div id="fade"></div>
</div></div>
<?php require_once('contents_slider_script.php') ;?>
<?php require_once('jyrno_chat_script.php') ;?>
</body>
</html>
