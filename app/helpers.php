<?php
function getRoleName($role_type=1)
{
	$array = array(1=>'Super Admin',2=>'Business Owner',3=>'User');
	if(isset($array[$role_type]))
		return $array[$role_type];
	else
		return $array[1];
}
function getRoles()
{
	$array = array(1=>'Super Admin',2=>'Business Owner',3=>'User');
	return $array;
}
// function logo()
// {
//  	$user = auth()->user();
//  	$url =  asset('/').'theme/images/logo-dark.png';
//  	if($user)
//  	{
//  		if($user->user_type==1 && $user->logo)
//  		{
//  			$url =  asset('storage').'/'.$user->logo;
//  		}
//  		else if($user->user_type==2 && $user->logo)
//  		{
//  			$url =  asset('storage').'/'.$user->logo;
//  		}
//  		else if($user->user_type==3 && isset($user->owner->logo) && $user->owner->logo)
//  		{
//  			$url =  asset('storage').'/'.$user->owner->logo;
//  		}
//  	}
//  	else{
//  		$user = \App\User::where('user_type',1)->first();
//  		if($user && $user->logo)
//  			$url =  asset('storage').'/'.$user->logo;
//  	}

//  	return $url;
// }

function pre($text)
{
	print "<pre>";
	print_r($text);
	die;
}
function colorclasses()
{
	return array("bg-primary","bg-secondary","bg-success","bg-danger","bg-warning","bg-info","bg-dark");	
}
function themeclasses()
{
	return array("","info","danger","success","dark","secondary");	
}
function bgcolors()
{
	return array("primary","secondary","danger","success","dark","info","warning");	
}
function cacheclear()
{
	return time();
}
?>