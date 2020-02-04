<?php
function insert_message_to_db($chatroom_id,$user_id,$text,$con)
{
	$ip1= @$REMOTE_ADDR;
	$ip=GetHostByName($ip1);
	$d=strtotime("now");
	$sql1=" INSERT INTO messages (user_id,datetime,message,ipaddress,chatroom_id) VALUES ('$user_id','$d','$text','$ip','$chatroom_id') ";
	if(!mysql_query($sql1,$con))
	{
		die('Error: ' . mysql_error());
	}
	
}

function create_public_chatroom($user_id,$text,$con)
{
	$d=strtotime("now");
	$sql1=" INSERT INTO chatrooms VALUES ('','$text','public','$user_id','$d') ";
	if(!mysql_query($sql1,$con))
	{
		die('Error: ' . mysql_error());
	}

}
function create_private_chatroom($user_id,$users,$text,$con)
{
	$d=strtotime("now");
	$sql1=" INSERT INTO chatrooms VALUES ('','$text','private','$user_id','$d') ";
	if(!mysql_query($sql1,$con))
	{
		die('Error: ' . mysql_error());
	}
	else{
		$new_chatroom_id=mysql_insert_id();
		 foreach($users as $user){
			if($user_id==$user) $sql2=" INSERT INTO private_chatroom_users VALUES ('','$new_chatroom_id','$user','accepted') ";
			else $sql2=" INSERT INTO private_chatroom_users VALUES ('','$new_chatroom_id','$user','requested') ";
			if(!mysql_query($sql2,$con))
			{
				die('Error: ' . mysql_error());
			}
		}
	}

}
function post_last_message($chatroom_id,$con)
{
	$sql="SELECT * FROM messages WHERE chatroom_id='$chatroom_id' order by message_id desc limit 1";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count>0){
	  while($row = mysql_fetch_array($result))
	  {
		  $userquery="SELECT username FROM users WHERE user_id='".$row['user_id']."' limit 1";
		  $userresult=mysql_query($userquery);
		  while($userrow = mysql_fetch_array($userresult))
	  	  { $username= $userrow['username'];}
		  echo '<div class="chat_message">
                    <div class="sender_name">'.$username.'</div>
                    <div class="chat_time">'.date("g:i A",$row['datetime']).'</div>
                    <div class="display_chat">'.$row['message'].'</div>
                   
                </div>
                 <div class="seprator_chat"></div>';
	  }
	}
}

/*function show_messages($chatroom_id,$con)
{
	$sql="SELECT * FROM messages WHERE chatroom_id='$chatroom_id' order by message_id asc limit 200";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count>0){
	  while($row = mysql_fetch_array($result))
	  {
		  $userquery="SELECT username FROM users WHERE user_id='".$row['user_id']."' limit 1";
		  $userresult=mysql_query($userquery);
		  while($userrow = mysql_fetch_array($userresult))
	  	  { $username= $userrow['username'];}
		  echo '<div class="chat_message">
                    <div class="sender_name">'.$username.'</div>
                    <div class="chat_time">'.date("g:i A",$row['datetime']).'</div>
                    <div class="display_chat">'.$row['message'].'</div>
                   
                </div>
                 <div class="seprator_chat"></div>';
	  }
	}
}*/
function show_online_users($place,$con)
{ 
$login_users=mysql_query("select * from users where is_login='1' order by login_time asc");
if(mysql_num_rows($login_users)>=1){
	while ($user = mysql_fetch_array($login_users)) { 
	$full_name=$user['firstname']." ".$user['lastname'];
		if($place=='content_1'){
 ?>
            <div class="online_friend">
            	<div class="image_chat_icon">
                	<img src="images/chat_jyrno_08.png" />
              </div>
                <div class="chat_user"><a href="#"><?php echo $full_name ;?></a></div>
                <div class="status_user">
                	
                </div>
            </div>
<?php 	}else{ if($_SESSION['user_id']!=$user['user_id']){ ?>	
			<div class="popup_online_friends">
            	<div class="image_chat_icon">
                	<img src="images/chat_jyrno_03.png" />
                </div>
                <div class="chat_user"><a href="#"><?php echo $full_name ;?></a></div>
                <div class="popup_status_user">
 <input type="checkbox" name="add_private_user" id="add_private_user" value="<?php echo $user['user_id']; ?>"/>
                </div>
            </div>
		<?php }}
}}
else
{ ?>
<div class="online_friend">
                    <div class="chat_user">No Users Online</div>  
                </div>   

<?php }
}
function get_chatrooms($con)
{ 
$chat_groups=mysql_query("select * from chatrooms where type='public' order by created_date asc");
if(mysql_num_rows($chat_groups)>=1){
while ($chat_group = mysql_fetch_array($chat_groups)) { 
 ?>
<div class="chat_group">
                    <div class="chat_user"><a href="#" id="<?php echo $chat_group['chatroom_id']; ?>" rel="<?php echo $chat_group['created_by']; ?>" class="public_chatroom"><?php echo $chat_group['name'] ;?></a></div>  
                </div>   
<?php }}
else
{ ?>
<div class="chat_group">
                    <div class="chat_user">No Public Groups Found</div>  
                </div>   

<?php }


}

function get_private_chatrooms($user_id,$con)
{ 
$chat_groups=mysql_query("select a.chatroom_id,name,created_by,a.state from chatrooms a,private_chatroom_users b where type='private' AND b.state!='rejected' AND user_id='".$user_id."' AND a.chatroom_id=b.chatroom_id order by created_date asc");
if(mysql_num_rows($chat_groups)>=1){
	while ($chat_group = mysql_fetch_array($chat_groups)) { 
		if($chat_group['state']=="requested"){
?>
			<div class="chat_group">
    		<div class="chat_user"><a href="#" id="<?php echo $chat_group['chatroom_id']; ?>" rel="<?php echo $chat_group['created_by']; ?>" class="private_chatroom"><?php echo $chat_group['name'] ;?></a><div style="float:right"><input type="button" name="accept" class="accept" value="accept" rel="<?php echo $chat_group['chatroom_id']; ?>" /><input type="button" class="reject" name="reject" value="reject" rel="<?php echo $chat_group['chatroom_id']; ?>"/></div></div>  
             </div>   
		<?php }else{ ?>
		<div class="chat_group">
    		<div class="chat_user"><a href="#" id="<?php echo $chat_group['chatroom_id']; ?>" rel="<?php echo $chat_group['created_by']; ?>" class="private_chatroom"><?php echo $chat_group['name'] ;?></a></div>  
             </div>  
<?php }}
}
else
{ ?>
<div class="chat_group">
                    <div class="chat_user">No Private Groups Found</div>  
                </div>   

<?php }

}
function get_requests($user_id,$con)
{ 
$chat_groups=mysql_query("select a.chatroom_id from chatrooms a,private_chatroom_users b where type='private' AND state='requested' AND user_id='".$user_id."' AND a.chatroom_id=b.chatroom_id order by created_date asc");
echo mysql_num_rows($chat_groups);
}
function handle_request($user_id,$chatroom_id,$action,$con)
{
mysql_query("update private_chatroom_users set state='$action' where user_id='$user_id' AND chatroom_id='$chatroom_id'");

}
function chat_login($user_id,$time,$con)
{
mysql_query("update users set chat_login='1', chat_login_time='$time' where user_id='$user_id' ");
echo "ffd";

}
function chat_logout($user_id,$time,$con)
{
mysql_query("update users set chat_login='0', chat_login_time='0' where user_id='$user_id' ");
echo "ffd";

}
function get_chatroom_messages($id,$con)
{ 
$sql="SELECT * FROM messages WHERE chatroom_id='$id' order by message_id asc limit 200";
$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count>0){
	  while($row = mysql_fetch_array($result))
	  {
		  $userquery="SELECT username FROM users WHERE user_id='".$row['user_id']."' limit 1";
		  $userresult=mysql_query($userquery);
		  while($userrow = mysql_fetch_array($userresult))
	  	  { $username= $userrow['username'];}
		  echo '<div class="chat_message">
                    <div class="sender_name">'.$username.'</div>
                    <div class="chat_time">'.date("g:i A",$row['datetime']).'</div>
                    <div class="display_chat">'.$row['message'].'</div>
                   
                </div>
                 <div class="seprator_chat"></div>';
	  }
	}
	else
	{
		echo '<div class="chat_message" id="notify"><div class="display_chat">No Messages in this chatroom yet</div></div>';
	}

}
function get_last_message_time($user_id,$con)
{
$now=strtotime("now");
$befor=$now-1500;
$sql="SELECT datetime FROM messages WHERE user_id='$user_id' order by message_id desc limit 1";
$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count>0){
	  while($row = mysql_fetch_array($result))
	  {
			if($row['datetime']>$befor) echo "keepin"; else echo "logout";
	  }
	}
	else { echo "logout"; }
}
?>