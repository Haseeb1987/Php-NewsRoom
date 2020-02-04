<?php
function insert_message_to_db($chatroom_id,$user_id,$text,$con)
{
	$ip1= @$REMOTE_ADDR;
	$ip=GetHostByName($ip1);
	$d=strtotime("now");
	$sql1=" INSERT INTO jyrno_chat_messages (user_id,datetime,message,ipaddress,chatroom_id) VALUES ('$user_id','$d','$text','$ip','$chatroom_id') ";
	try {
	$con->exec($sql1);
	} catch(PDOException $ex) {
		echo "error accoured";
}
	
}

function create_public_chatroom($user_id,$text,$desc,$con)
{
	$d=strtotime("now");
	$sql1="INSERT INTO chatrooms (name,type,created_by,created_date,description) VALUES ('$text','public','$user_id','$d','$desc') ";
try {
	$con->exec($sql1);
	echo "dd";
	} catch(PDOException $ex) {
		echo "error accoured";
}

}
function create_private_chatroom($user_id,$users,$text,$desc,$private_password,$con)
{
	$d=strtotime("now");
	$sql1=" INSERT INTO chatrooms (name,type,created_by,created_date,description,password) VALUES ('$text','private','$user_id','$d','$desc','$private_password') ";
	try {
		$con->exec($sql1);
		//$new_chatroom_id=$con->lastInsertId();
		$sql3="SELECT * FROM chatrooms order by chatroom_id desc limit 1";
		$result3=$con->query($sql3);
		while($row = $result3->fetch(PDO::FETCH_ASSOC))
	  	{
			echo "dd".$new_chatroom_id=$row['chatroom_id'];
		}
		 foreach($users as $user){
			if($user_id==$user) $sql2=" INSERT INTO private_chatroom_users (chatroom_id,user_id,state) VALUES ('$new_chatroom_id','$user','accepted') ";
			else $sql2=" INSERT INTO private_chatroom_users (chatroom_id,user_id,state) VALUES ('$new_chatroom_id','$user','requested') ";
			$con->exec($sql2);
		}
	} catch(PDOException $ex) {
		echo "error accoured";
}

}
function post_last_message($chatroom_id,$con)
{
	$sql="SELECT * FROM messages WHERE chatroom_id='$chatroom_id' order by message_id desc limit 1";
	$result=$con->query($sql);
	$count=$result->rowCount();
	if($count>0){
	  while($row = $result->fetch(PDO::FETCH_ASSOC))
	  {
		  $userquery="SELECT username FROM users WHERE user_id='".$row['user_id']."' limit 1";
		  $userresult=$con->query($userquery);
		  while($userrow = $userresult->fetch(PDO::FETCH_ASSOC))
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
function show_online_users($place,$con)
{ 
$login_users=$con->query("select id,firstname,avatar,lastname,chat_login_time from users where chat_login='1' order by chat_login_time asc");
$row_count = $login_users->rowCount();
if($row_count>=1){
	while ($user = $login_users->fetch(PDO::FETCH_ASSOC)) { 
	$full_name=ucfirst($user['firstname'])." ".ucfirst($user['lastname']);
	//$full_name=$user['username'];
		if($place=='content_1'){
 ?>
            <div class="online_friend">
            	<div class="image_chat_icon">
								<?
			if((($user['avatar'])!='')&&(($user['avatar'])!=NULL)) {
			?>
					<?php if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/uploads/users/'.$user['avatar'])) { ?>
								<img src="http://www.jyrno.com/uploads/users/<?=$user['avatar']?>" width="27" height="27" style="width:27px; height:27px">
					<?php } else  { ?>
										<?php if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/register/profile/uploads/'.$user['avatar'])) { ?>

														<img src="http://www.jyrno.com/register/profile/uploads/<?=$user['avatar']?>" width="27" height="27" alt="Profile pic" style="width:27px; height:27px"/>
												<?php } else  { ?>
												<img src="http://www.jyrno.com/images/profilepic.jpg" width="27" height="27" alt="profile pic" style="width:27px; height:27px"/>
												<?php } ?>
					 <?php } ?>
			<? } else { ?>
			<img src="http://www.jyrno.com/images/profilepic.jpg" width="27" height="27" style="width:27px; height:27px"/>
			<? } ?>
              </div>
                <div class="chat_user"><a href="http://www.jyrno.com/profile/index/u/<?php echo $user['id']; ?>" target="_blank"  <?php if((time()-$user['chat_login_time']) < 10) { echo 'class="blink"'; } ?>><?php echo $full_name;?></a>                <div class="status_user">
                	
                </div></div>
            </div>
<?php 	}else{ if($_SESSION['Auth']['id']!=$user['id']){ ?>	
			<div class="popup_online_friends" style="margin-top:0px">
            	<div class="image_chat_icon">
                	<?
			if((($user['avatar'])!='')&&(($user['avatar'])!=NULL)) {
			?>
					<?php if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/uploads/users/'.$user['avatar'])) { ?>
								<img src="http://www.jyrno.com/uploads/users/<?=$user['avatar']?>" width="27" height="27" style="width:27px; height:27px">
					<?php } else  { ?>
										<?php if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/register/profile/uploads/'.$user['avatar'])) { ?>

														<img src="http://www.jyrno.com/register/profile/uploads/<?=$user['avatar']?>" width="27" height="27" alt="Profile pic" style="width:27px; height:27px"/>
												<?php } else  { ?>
												<img src="http://www.jyrno.com/images/profilepic.jpg" width="27" height="27" alt="profile pic" style="width:27px; height:27px"/>
												<?php } ?>
					 <?php } ?>
			<? } else { ?>
			<img src="http://www.jyrno.com/images/profilepic.jpg" width="27" height="27" style="width:27px; height:27px"/>
			<? } ?>
                </div>
                <div class="chat_user" style="border:0px"><a href="#"><?php echo $full_name ;?></a></div>
                <div class="popup_status_user">
 <input type="checkbox" name="add_private_user" id="add_private_user" value="<?php echo $user['id']; ?>"/>
                </div>
            </div>
		<?php }}
}}
else
{ ?>
<div class="online_friend">
                    <div class="chat_user" style="border:0px">No Users Online</div>  
                </div>   

<?php }
}
function show_room_users($room,$place,$con)
{ 
$room_users=$con->query("select user_id from private_chatroom_users where chatroom_id='".$room."' order by chat_login_time asc");
$row_count = $room_users->rowCount();
if($row_count>=1){
while ($user = $room_users->fetch(PDO::FETCH_ASSOC)) {
$login_users=$con->query("select id,firstname,avatar,lastname,chat_login_time from users where id='".$room_users['user_id']."' order by chat_login_time asc");
	while ($user = $login_users->fetch(PDO::FETCH_ASSOC)) { 
	$full_name=ucfirst($user['firstname'])." ".ucfirst($user['lastname']);
	//$full_name=$user['username'];
		if($place=='content_1'){
 ?>
            <div class="online_friend">
            	<div class="image_chat_icon">
								<?
			if((($user['avatar'])!='')&&(($user['avatar'])!=NULL)) {
			?>
					<?php if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/uploads/users/'.$user['avatar'])) { ?>
								<img src="http://www.jyrno.com/uploads/users/<?=$user['avatar']?>" width="27" height="27" style="width:27px; height:27px">
					<?php } else  { ?>
										<?php if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/register/profile/uploads/'.$user['avatar'])) { ?>

														<img src="http://www.jyrno.com/register/profile/uploads/<?=$user['avatar']?>" width="27" height="27" alt="Profile pic" style="width:27px; height:27px"/>
												<?php } else  { ?>
												<img src="http://www.jyrno.com/images/profilepic.jpg" width="27" height="27" alt="profile pic" style="width:27px; height:27px"/>
												<?php } ?>
					 <?php } ?>
			<? } else { ?>
			<img src="http://www.jyrno.com/images/profilepic.jpg" width="27" height="27" style="width:27px; height:27px"/>
			<? } ?>
              </div>
                <div class="chat_user"><a href="http://www.jyrno.com/profile/index/u/<?php echo $user['id']; ?>" target="_blank"  <?php if((time()-$user['chat_login_time']) < 10) { echo 'class="blink"'; } ?>><?php echo $full_name;?></a>                <div class="status_user">
                	
                </div></div>
            </div>
<?php 	}else{ if($_SESSION['Auth']['id']!=$user['id']){ ?>	
			<div class="popup_online_friends" style="margin-top:0px">
            	<div class="image_chat_icon">
                	<?
			if((($user['avatar'])!='')&&(($user['avatar'])!=NULL)) {
			?>
					<?php if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/uploads/users/'.$user['avatar'])) { ?>
								<img src="http://www.jyrno.com/uploads/users/<?=$user['avatar']?>" width="27" height="27" style="width:27px; height:27px">
					<?php } else  { ?>
										<?php if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/register/profile/uploads/'.$user['avatar'])) { ?>

														<img src="http://www.jyrno.com/register/profile/uploads/<?=$user['avatar']?>" width="27" height="27" alt="Profile pic" style="width:27px; height:27px"/>
												<?php } else  { ?>
												<img src="http://www.jyrno.com/images/profilepic.jpg" width="27" height="27" alt="profile pic" style="width:27px; height:27px"/>
												<?php } ?>
					 <?php } ?>
			<? } else { ?>
			<img src="http://www.jyrno.com/images/profilepic.jpg" width="27" height="27" style="width:27px; height:27px"/>
			<? } ?>
                </div>
                <div class="chat_user" style="border:0px"><a href="#"><?php echo $full_name ;?></a></div>
                <div class="popup_status_user">
 <input type="checkbox" name="add_private_user" id="add_private_user" value="<?php echo $user['id']; ?>"/>
                </div>
            </div>
		<?php }
}}
}}
else
{ ?>
<div class="online_friend">
                    <div class="chat_user" style="border:0px">No Users Online</div>  
                </div>   

<?php }
}
function show_friends($user_id,$con)
{ 
$friends=$con->query("select friend_id from friends where user_id='$user_id' order by id asc");
$row_count = $friends->rowCount();
if($row_count>=1){
	while ($friend = $friends->fetch(PDO::FETCH_ASSOC)) {
			$fid=$friend['friend_id'];
		$users=$con->query("select id,firstname,avatar,lastname,chat_login from users where id='$fid' limit 1");
		$row_count2 = $users->rowCount();
		if($row_count2>=1){
			while ($user = $users->fetch(PDO::FETCH_ASSOC)) {
				$full_name=ucfirst($user['firstname'])." ".ucfirst($user['lastname']);
				//$full_name=$user['username']; ?>
			<div class="online_friend">
            	<div class="image_chat_icon">
                	<?
			if((($user['avatar'])!='')&&(($user['avatar'])!=NULL)) {
			?>
					<?php if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/uploads/users/'.$user['avatar'])) { ?>
								<img src="http://www.jyrno.com/uploads/users/<?=$user['avatar']?>" width="27" height="27" style="width:27px; height:27px">
					<?php } else  { ?>
										<?php if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/register/profile/uploads/'.$user['avatar'])) { ?>

														<img src="http://www.jyrno.com/register/profile/uploads/<?=$user['avatar']?>" width="27" height="27" alt="Profile pic" style="width:27px; height:27px"/>
												<?php } else  { ?>
												<img src="http://www.jyrno.com/images/profilepic.jpg" width="27" height="27" alt="profile pic" style="width:27px; height:27px"/>
												<?php } ?>
					 <?php } ?>
			<? } else { ?>
			<img src="http://www.jyrno.com/images/profilepic.jpg" width="27" height="27" style="width:27px; height:27px"/>
			<? } ?>
              </div>
                <div class="chat_user"><a href="http://www.jyrno.com/profile/index/u/<?php echo $user['id']; ?>" target="_blank"><?php echo $full_name ;?></a><div class="<?php if($user['chat_login']=='1') echo 'status_user'; else echo 'status_friend' ;?>"></div></div>
                
            </div>
<?php
			}
		}?>
	
 			
<?php
}}
else
{ ?>
<div class="online_friend">
                    <div class="chat_user" style="border:0px">You have no friends online</div>  
                </div>   

<?php }
}
function get_chatrooms($user_id,$con)
{ 
$chat_groups=$con->query("select * from chatrooms where type='public' order by created_date desc");
$row_count = $chat_groups->rowCount();
if($row_count>=1){
$i=1;
while ($chat_group = $chat_groups->fetch(PDO::FETCH_ASSOC)) { 
 ?>
<?php // if($ult==true) echo 'creator'; ?>
<div class="chat_group">
                    <div class="chatroom_name"><a href="#" id="<?php echo $chat_group['chatroom_id']; ?>" rel="<?php echo $chat_group['created_by']; ?>" class="public_chatroom"><?php echo $chat_group['name'] ;?></a>
  <div style="float:right"><?php if($chat_group['created_by']==$user_id){ ?> <a href="#" style="" class="delete_chatroom" id="<?php echo $chat_group['chatroom_id']; ?>"><img src="images/delete.png" width="20" height="20"/></a> <?php } ?>
<a title="" style=" cursor:help" class="info_chatroom" id="<?php echo $chat_group['chatroom_id']; ?>" <?php if((time()-$chat_group['created_date']) < 10) { echo 'class="blink"'; } ?>><img src="images/info.png" width="20" height="20" /></a>
<div style="display:none"><?php if($chat_group['description']!='') echo $chat_group['description'] ; else echo "No description provided";?></div>
</div></div>
                </div>   
<?php }}
else
{ ?>
<div class="chat_group">
                    <div class="chat_user" style="border:0px">No Public Groups Found</div>  
                </div>   

<?php }


}

function get_private_chatrooms($user_id,$con)
{ 
$chat_groups=$con->query("select a.chatroom_id,name,description,created_by,b.state from chatrooms a,private_chatroom_users b where type='private' AND b.state!='rejected' AND user_id='".$user_id."' AND a.chatroom_id=b.chatroom_id order by created_date desc");
$row_count = $chat_groups->rowCount();
if($row_count>=1){
	while ($chat_group = $chat_groups->fetch(PDO::FETCH_ASSOC)) { 
		if($chat_group['state']=="requested"){
?>
			<div class="chat_group">
    		<div class="chatroom_name" id="prc<?php echo $chat_group['chatroom_id']; ?>"><a href="#" id="<?php echo $chat_group['chatroom_id']; ?>" rel="<?php echo $chat_group['created_by']; ?>" class="private_chatroom" <?php if((time()-$chat_group['created_date']) < 10) { echo 'class="blink"'; } ?>><?php echo $chat_group['name'] ;?></a><div style="float:right"><input type="button" name="accept" class="accept" value="accept" rel="<?php echo $chat_group['chatroom_id']; ?>" /><input type="button" class="reject" name="reject" value="reject" rel="<?php echo $chat_group['chatroom_id']; ?>"/></div></div>  
             </div>   
		<?php }else{ ?>
		<div class="chat_group">
    		<div class="chatroom_name" id="prc<?php echo $chat_group['chatroom_id']; ?>"><a href="#" id="<?php echo $chat_group['chatroom_id']; ?>" rel="<?php echo $chat_group['created_by']; ?>" class="private_chatroom" <?php if((time()-$chat_group['created_date']) < 10) { echo 'class="blink"'; } ?>><?php echo $chat_group['name'] ;?></a> <div style="float:right">
  <?php if($chat_group['created_by']==$user_id){ ?>
 <a href="#" style="float:left" class="delete_chatroom" id="<?php echo $chat_group['chatroom_id']; ?>"><img src="images/delete.png" width="20" height="20"/></a>
 <?php } ?>
<a title="" style="float:right; cursor:help" class="info_chatroom" id="<?php echo $chat_group['chatroom_id']; ?>"><img src="images/info.png" width="20" height="20" /></a>
<div style="display:none"><?php if($chat_group['description']!='') echo $chat_group['description'] ; else echo "No description provided";?></div>
</div></div>
             </div>  
<?php }}
}
else
{ ?>
<div class="chat_group">
                    <div class="chat_user" style="border:0px">No Private Groups Found</div>  
                </div>   

<?php }

}
function get_requests($user_id,$con)
{ 
$chat_groups=$con->query("select a.chatroom_id from chatrooms a,private_chatroom_users b where type='private' AND b.state='requested' AND user_id='".$user_id."' AND a.chatroom_id=b.chatroom_id order by created_date asc");
echo $chat_groups->rowCount();
}
function checkname($name,$con)
{ 
$chat_groups=$con->query("select name from chatrooms where name='$name'");
echo $chat_groups->rowCount();
}
function count_users($total_online,$con)
{ 
$count_users=$con->query("SELECT login_time FROM users WHERE chat_login='1'");
echo $count_users->rowCount();
}
function count_public($total_online,$con)
{ 
$count_users=$con->query("select created_date from chatrooms where type='public'");
echo $count_users->rowCount();
}
function count_private($total_online,$con)
{ 
$count_users=$con->query("select created_date from chatrooms where type='private'");
echo $count_users->rowCount();
}
function handle_request($user_id,$chatroom_id,$action,$con)
{
$con->exec("update private_chatroom_users set state='$action' where user_id='$user_id' AND chatroom_id='$chatroom_id'");

}
function change_color($user_id,$color,$con)
{
$con->exec("update users set chat_color='$color' where id='$user_id'");

}
function chat_login($user_id,$time,$con)
{
$con->exec("update users set chat_login='1', chat_login_time='$time' where id='$user_id' ");
}
function chat_logout($user_id,$con)
{
$con->exec("update users set chat_login='0' where id='$user_id' ");
}
function test($user_id,$con)
{
echo $user_id;
}
function delete_chatroom($chatroom_id,$con)
{
$count = $con->exec("delete from chatrooms where chatroom_id='$chatroom_id'");
echo "Deleted $count rows";
}
function can_delete_chatroom($chatroom_id,$con)
{
$d=strtotime("now");
$d5=$d-300;
$sql="SELECT datetime FROM jyrno_chat_messages WHERE chatroom_id='$chatroom_id' order by message_id desc limit 1";
$result=$con->query($sql);
	$count=$result->rowCount();
	if($count>0){
	  while($row = $result->fetch(PDO::FETCH_ASSOC))
	  {
			if($row['datetime']<$d5) echo "yes"; else echo "no";
	  }
	}
else
{
	echo "yes";
}
}
function get_password($chatroom,$con)
{
$sql="SELECT password FROM chatrooms WHERE chatroom_id='$chatroom' limit 1";
$result=$con->query($sql);
	$count=$result->rowCount();
	if($count>0){
	  while($row = $result->fetch(PDO::FETCH_ASSOC))
	  {
			return $row['password'];
	  }
	}
else
{
	return;
}
}

function get_chat_login_time($user_id,$con)
{
$sql="SELECT chat_login_time FROM users WHERE id='$user_id' limit 1";
$result=$con->query($sql);
	$count=$result->rowCount();
	if($count>0){
	  while($row = $result->fetch(PDO::FETCH_ASSOC))
	  {
			return $row['chat_login_time'];
	  }
	}
else
{
	return;
}
}

function get_username($user_id,$con)
{
$sql="SELECT username FROM users WHERE id='$user_id' limit 1";
$result=$con->query($sql);
	$count=$result->rowCount();
	if($count>0){
	  while($row = $result->fetch(PDO::FETCH_ASSOC))
	  {
			return $row['username'];
	  }
	}
else
{
	return;
}

}
function get_chatroom_messages($id,$login_time,$con)
{ 
$sql="select * from ( SELECT * FROM jyrno_chat_messages WHERE chatroom_id='$id' AND datetime>'$login_time' order by message_id desc ) tmp order by tmp.message_id asc";
$result=$con->query($sql);
	$count=$result->rowCount();
	if($count>0){
	  while($row = $result->fetch(PDO::FETCH_ASSOC))
	  {
		  $userquery="SELECT username,firstname,lastname,avatar,chat_color FROM users WHERE id='".$row['user_id']."' limit 1";
		  $userresult=$con->query($userquery);
		  while($userrow = $userresult->fetch(PDO::FETCH_ASSOC))
	  	  { $full_name=$userrow['firstname']." ".$userrow['lastname']; 
			//$username= $userrow['username'];
			 $color=$userrow['chat_color']; $avatar=$userrow['avatar'];}
		  echo '<div class="chat_message">
                    <div class="sender_name" style="color:'.$color.'"><a href="http://www.jyrno.com/profile/index/u/'.$row['user_id'].'" target="_blank" style="color:inherit">'.$full_name.'</a></div>
                    <div class="chat_time">'.date("g:i A",$row['datetime']).'</div>
                    <div style="color:'.$color.';float: left;width: 510px; margin-top: 3px;"><div style="width: 27px; height: 27px; float: left; margin-right: 5px; margin-top: 5px;">';
if(($avatar!='')&&($avatar!=NULL)) {
			?>
					<?php if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/uploads/users/'.$avatar)) { ?>
								<img src="http://www.jyrno.com/uploads/users/<?php echo $avatar; ?>" width="27" height="27" style="width:27px; height:27px">
					<?php } else  {?>
										<?php if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/register/profile/uploads/'.$avatar)) { ?>

														<img src="http://www.jyrno.com/register/profile/uploads/<?php echo $avatar; ?>" width="27" height="27" alt="Profile pic" style="width:27px; height:27px"/>
												<?php } else  {?>
												<img src="http://www.jyrno.com/images/profilepic.jpg" width="27" height="27" alt="profile pic" style="width:27px; height:27px"/>
												<?php } ?>
					 <?php } ?>
			<? } else { ?>
			<img src="http://www.jyrno.com/images/profilepic.jpg" width="27" height="27" style="width:27px; height:27px"/>
			<?  }

echo '</div><div class="display_chat" style="color:'.$color.';margin-top:0px; width: 455px;">'.$row['message'].'</div></div>
                   
                </div>
                 <div class="seprator_chat"></div>';
	  }
	}
	else
	{
		//echo '<div class="chat_message" id="notify"><div class="display_chat">No Messages in this chatroom yet</div></div>';
	}

}
function getall_chatroom_messages($id,$con)
{ 
$sql="SELECT * FROM jyrno_chat_messages WHERE chatroom_id='$id' order by message_id asc";
$result=$con->query($sql);
	$count=$result->rowCount();
	if($count>0){
	  while($row = $result->fetch(PDO::FETCH_ASSOC))
	  {
		  $userquery="SELECT firstname,lastname,chat_color FROM users WHERE id='".$row['user_id']."' limit 1";
		  $userresult=$con->query($userquery);
		  while($userrow = $userresult->fetch(PDO::FETCH_ASSOC))
	  	  {$full_name=$userrow['firstname']." ".$userrow['lastname'];
 //$username= $userrow['username'];
$color=$userrow['chat_color'];}
		  echo '<div class="chat_message">
                    <div class="sender_name" style="color:'.$color.'"><a href="http://www.jyrno.com/profile/index/u/'.$row['user_id'].'" target="_blank" style="color:inherit">'.$full_name.'</a></div>
                    <div class="chat_time">'.date("g:i A",$row['datetime']).'</div>
                    <div class="display_chat" style="color:'.$color.'">'.$row['message'].'</div>
                   
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
$sql="SELECT datetime FROM jyrno_chat_messages WHERE user_id='".$user_id."' order by message_id desc limit 1";
$result=$con->query($sql);
	$count=$result->rowCount();
	if($count>0){
	  while($row =  $result->fetch(PDO::FETCH_ASSOC))
	  {
			if($row['datetime']>$befor) echo "keepin"; else echo "logout";
	  }
	}
	else { echo "logout"; }
}
?>