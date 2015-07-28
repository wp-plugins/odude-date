<?php
function odudedate_ical()
{
	if(get_option('xmlon')=='on')
		{
	$uploaddir = wp_upload_dir();
	
	$dpath = '<a href="'.$uploaddir['baseurl'].'/odude-date/'.get_option('xmlpwd').'.ics" class="pure-button">Subscribe to Calendar</a>';
	$pic = '<a href="'.$uploaddir['baseurl'].'/odude-date/'.get_option('xmlpwd').'.ics" title="Download file"><img src="'.plugins_url().'/odude-date/css/images/link.png" border="0" ></a>';
	$opath=str_replace("http","webcal",$dpath);
	return $opath."&nbsp;".$pic;
		}
		else
		{
				return "";
		}
}
add_shortcode('odudedate_ical','odudedate_ical');

function search_odude_calendar($atts)
{
global $wp_query;
global $wpdb;
global $keylink;
global  $site_url;
$uploaddir = wp_upload_dir();
$user = wp_get_current_user();
/*
$f='

<script>
function process()
{
var url="'.$site_url.'search/" + document.getElementById("url").value;
location.href=url;
return false;
}
</script>
<form onSubmit="return process();" id="searchform" class="clearfix">

<input type="text" class="field" name="url" id="url" placeholder="search here ..."> <input type="submit" class="submit" value="go">
</form>

<hr>';	
*/

$f='
<script>
function process()
{
var url="'.$site_url.'search/" + document.getElementById("s").value;
location.href=url;
return false;
}
</script>
<form onSubmit="return process();" id="searchform" class="clearfix">
	<label for="s" class="assistive-text">Search</label>
	<input type="text" class="field" name="s" value="" id="s" placeholder="Search …">
	<input type="submit" class="submit" name="submit" id="searchsubmit" value="Go">
</form><br>

';

	if(isset($wp_query->query_vars['scountry']))
	{
		$term=$wp_query->query_vars['scountry'];
		//$getgalimages = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."odudedate WHERE `event` LIKE '%$term%' and Publish='1' limit 0,20 ");
		$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."odudedate WHERE `event` LIKE '%%%s%%' and Publish='1' limit 0,20 ",array($term));
	$getgalimages = $wpdb->get_results($sql);	
			
				if(count($getgalimages))
				{
				
					
					$f.="<div class=\"pure-g-r\">";
					
					foreach($getgalimages as $val)
					{
					
					$event = $val->event;
					$day=$val->day;
					$month=$val->month;
					$year=$val->year;
					if($year=="0")
					$year=date('Y');
					$country=$val->country;
					$event_desc=$val->event_desp;
					$link=$val->link;
					$category=$val->category;
					$id=$val->id;
					$extra1=$val->extra1;
					$extra2=$val->extra2;
					$extra3=$val->extra3;
					$holiday=$val->Holiday;
					$datefor="$year-$month-$day";
					
					
						if($extra3=="")
						{
						$extra3="";
						}
						else
						{
						$imglink='<a href="'.$site_url.'calendar/'.$id.'/'.toSafeURL($event, "'").'">';
						if (strpos($link, $keylink) !== false)
						$imglink='<a href="'.$link.'">';
						
						thumbImage($extra3,$id);
						$extra3=$imglink."<img src='".$uploaddir['baseurl']."/odude-date/thumb_$id.jpg'></a>";
						}
						$flag=do_shortcode('[odude_flag group="'.$country.'" size="ico" page=""]');
						
						
						/*
						
						$f.="<div class='pure-u-1'><div class='odude_button blue'>

  <strong class='title'>
  <a href='$siteurl/time/$id/".toSafeURL($event, "'")."/'>".$event."</a></strong>
  <span class='first'>
   <span class='details'>".iso2long($datefor)."<br>
      $extra1
	  
    <strong>$extra2 </strong> <br>".$flag."
  </span>
 </span>
<span class='second'>
$extra3
</span> 
  <span class='price'>&rsaquo;</span>
</div></div>";
*/


				if ( is_super_admin()  ) 
					{
					
					$edit="<a href='".$site_url."wp-admin/admin.php?page=odudedate&edit=$id' class=\"pure-button pure-button-active\" target='_blank'>[Edit]</a>";
					}
					else if( in_array( "author", (array) $user->roles ))
					{
					
					$edit="<a href='".$site_url."wp-admin/admin.php?page=odudedate&edit=$id' class=\"pure-button pure-button-active\" target='_blank'>[Edit]</a>";
					}
					else
					{
					$edit="";
					}

						$newlink='<a href="'.$site_url.'calendar/'.$id.'/'.toSafeURL($event, "'").'">'.$event.'</a> ';
							if (strpos($link, $keylink) !== false)
							{
							$newlink='<a href="'.$link.'">'.$event.'</a> ';
							}
						
						$f.="<div class='pure-u-1'>";
						$f.='  <div class="obox">
								<div class="header">
								'.$newlink.'
								  <div class="date">'.$flag.'</div>
								</div>
								<div class="body">'.$extra3.'</div>
								<div class="footer">'.iso2long($datefor).'   '.$extra1.' '.$extra2.' '.$edit.'</div>
							  </div>';
						$f.="</div>";						
						
					}
					$f.="</div>";
					$f.="<h6>Look into more places ?: <a href='".$site_url."?s=$term&submit=Go'>Click here</a></h6>";
					//$f.="<h6>Additional Results:</h6>".get_search_link( $term );
					return $f;
				}
				else
				{
					$f.="<h6>Additional Results: <a href='".$site_url."?s=$term&submit=Go'>Click here</a></h6>";
					//	$f.="<h6>Additional Results:</h6>".get_search_link( $term );
					return $f."No Result Found";
				}






	}
	else
	{
	//Blank seach page
	//return "Nothing Searched";
return $f;
	}
			

}
//[search_odude_calendar] at search page.
add_shortcode('search_odude_calendar','search_odude_calendar');


function detail_odude_calendar($atts)
{
global $wp_query;
global $wpdb;
global  $site_url;
global $keylink;
global $gcountry;
$uploaddir = wp_upload_dir();
if(isset($wp_query->query_vars['sid']))
{
$year=$wp_query->query_vars['syear'];
$country=$wp_query->query_vars['sid'];
}
else
{


	if(isset($_COOKIE["odude_cal"]))
	$country=$_COOKIE["odude_cal"];
	else
	$country=$atts['group'];
	
$year="";
}

		
		if($country=='' || $year=='')
		{
		
		return do_shortcode('[odude_time zone=""]');
		}
		else
		{
		//$getgalimages = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."odudedate WHERE id = '".$country."' and Publish='1'");
		$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."odudedate WHERE id = %d and Publish='1'",array($country));
	$getgalimages = $wpdb->get_results($sql);	
		
			if(count($getgalimages))
			{
			
				$f="";
				$f.="<div class=\"pure-g-r\">";
				
				foreach($getgalimages as $val)
				{
				$f.="<div class=\"pure-u-1\">";
				$event = $val->event;
				$day=$val->day;
				$month=$val->month;
				$year=$val->year;
				if($year=="0")
					$year=date('Y');
				
				
						$datefor="$year-$month-$day";
						$datetime = new DateTime($datefor);
						$iday=$datetime->format("d");
						$imonth=$datetime->format("m");
						$iyear=$datetime->format("Y");
						$dateforX="$iyear$imonth$iday";
				
						$datefor="$year-$month-$day";
						$datetime = new DateTime($datefor);
						$datetime->modify('+1 day');
						$iday=$datetime->format("d");
						$imonth=$datetime->format("m");
						$iyear=$datetime->format("Y");
						$dateforY="$iyear$imonth$iday";
				
				global $xday;
				global $xmonth;
				global $xyear;
				
				$xday=$val->day;
				$xmonth=$val->month;
				$xyear=$val->year;
				
					
				
				
				$country=$val->country;

					
				if($country=='all')
				$gcountry=cookieCon();
				else				
				$gcountry=$country;
				
				
				$event_desc=$val->event_desp;
				$link=$val->link;
				$category=$val->category;
				$id=$val->id;
				$extra1=$val->extra1;
				$extra2=$val->extra2;
				$extra3=$val->extra3;
				$holiday=$val->Holiday;
				if($holiday=='0')
				$holiday="";
				else
				$holiday='<img src="'.plugins_url( '../css/images/red.png', __FILE__ ).'">';	
				//$holiday='<img src="'.plugins_url().'/odude-date/css/images/holiday.png">';
				
				$share='<a href="https://www.facebook.com/sharer.php?u=http://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].'" target="_blank"><img src="'.plugins_url().'/odude-date/css/images/facebook_share.gif"></a>';
				
				$google='<a href="http://www.google.com/calendar/event?action=TEMPLATE&text='.$event.'&details='.$extra1.' '.$extra2.'&trp=false&sprop=&sprop=name:&dates='.$dateforX.'/'.$dateforY.'" target="_blank" rel="nofollow"><img src="'.plugins_url().'/odude-date/css/images/google.gif"></a>';
				
				$flag=do_shortcode('[odude_flag group="'.$country.'" size="ico" page=""]');
				$explore='<a href="'.$site_url.'calendar/'.$day.'/'.$month.'/'.$year.'/'.$country.'/" class="pure-button">Explore '.$day.'/'.$month.'/'.$year.'</a>';
				
				if($extra3=="")
				{
				$extra3="";
				}
				else
				{
				thumbImage($extra3,$id);
				$extra3="<img src='". $uploaddir['baseurl']."/odude-date/large_$id.jpg''><br>";
				
				}
				
				
				
				$butt="";
					if($link!='')
					{
						if (strpos($link, $keylink) !== false)
						{
						$butt="<br><a href='$link' class=\"pure-button pure-button-primary\">More Details</a>";
						
						}
						else
						{
						$pic = plugins_url().'/odude-date/css/images/link.png';
						$butt="<br><a href='$link' class=\"pure-button pure-button-primary\" target='_blank'>More Details</a> <img src='$pic'>";
						}
					} 
				$f.="<br><blockquote class=\"bq2\"><center><h6>".$event."</h6>$extra1 $extra2<br>$extra3<b>$day/$month/$year </b> <br>$flag $share $google</center><br>".nl2br(htmlspecialchars_decode($event_desc))."<br>$holiday $butt $explore</blockquote></div>";		
				if ( is_super_admin()  ) 
					{
					
					$f.="<a href='".$site_url."wp-admin/admin.php?page=odudedate&edit=$id' class=\"pure-button pure-button-active\" target='_blank'>[Edit]</a>";
					}
					//if ( is_super_admin()  ) 
					else if( current_user_can('edit_others_pages') )
					{
					
					$f.="<a href='".$site_url."wp-admin/admin.php?page=odudedate_e&edit=$id' class=\"pure-button pure-button-active\" target='_blank'>[Edit]</a>";
					}
					else
					{
					$f.="";
					}
				
				}
				
				$f.="</div>";
				
				
					
				
			}
			else
			{
				return "No Record";
			}
		
		
		
		return $f;
		}
		

}
add_shortcode('detail_odude_calendar','detail_odude_calendar');

function odude_group_name($atts)
{
	global $gcountry;
	global $default_code;
	
	if($atts['group']=='')
		{
			if(is_home())
			{
				
			
				$country=cookieCon();
			}
			else
			{
				if($gcountry=='')
					$country=$default_code;
				else
					$country=$gcountry;
			}
		}
	else
		{
		$country=$atts['group'];
		}
		
	return ODudeGroup('gname',$country,'admin');
}
add_shortcode('odude_group_name','odude_group_name');

function date_front($atts)
{
global $wp_query;
global $wpdb;

$datefor=date('Y')."-".date('m')."-".date('d');	
$country=cookieCon();
$zone=zoneName($country);
date_default_timezone_set($zone);
$curtime=date("F d, Y H:i:s", time());
//$flag=do_shortcode('[odude_flag group="'.$country.'" size="ico" page=""]');

//$disp="<b>".iso2long($datefor)."</b> <br>(".odude_time_ago( $datefor ).")";
//$disp.="<hr>Country Code:".$country;
//$disp.="<hr>Country Name:".conName($country);
//$disp.="<hr>Zone Name:".$zone;
//$disp.="<hr>Current Time:".$curtime;
//$disp.="<hr>Flag:".$flag;

//$disp.= getEventsBox($day,$month,$year,$country,'general');
	$disp.=getEventsBoxSingle($day,$month,$year,$country,'general');
return $disp;
}
add_shortcode('odude_date_front','date_front');

function date_main($atts)
{
global $wp_query;
global $wpdb;
global $gcountry;


if(isset($wp_query->query_vars['sday']) && isset($wp_query->query_vars['smonth']) && isset($wp_query->query_vars['syear']))
{


	$day=$wp_query->query_vars['sday'];
	$month=$wp_query->query_vars['smonth'];
	$year=$wp_query->query_vars['syear'];
		if($year=="0")
		$year=date('Y');
	$country=$wp_query->query_vars['scountry'];
	
	$gcountry=$country;
	
	$datefor="$year-$month-$day";
		if($day=='' && $month=='' && $year=='')
		{
		 $datefor=date('Y')."-".date('m')."-".date('d');	
		}
	$disp="<center><b>".iso2long($datefor)."</b> <br>(".odude_time_ago( $datefor ).")</center><hr>";

	$disp.= getEventsBox($day,$month,$year,$country,'general');
	return $disp;
}
else if(isset($wp_query->query_vars['sid']) && isset($wp_query->query_vars['syear']))
{
	//don't delete this. It looks wrong but works. :)
	return do_shortcode('[detail_odude_calendar group="US"]');

}
else
{
	

	if($atts['group']=='')
		{
			$country=cookieCon();
		}
	else
		{
		$country=$atts['group'];
		}
	$day="";
	$month="";
	$year="";
	
	$datefor="$year-$month-$day";
		if($day=='' && $month=='' && $year=='')
		{
		 $datefor=date('Y')."-".date('m')."-".date('d');	
		}
		$disp="";
	//$disp="<center><b>".iso2long($datefor)."</b> <br>(".odude_time_ago( $datefor ).")</center><hr>";
	//$disp.="<div class=\"pure-g-r\">";
	//$disp.="<div class=\"pure-u-2\">";
	//include(ODUDEDATE_PLUGIN_DIR . '/layout/general_top.php');
	$disp.= getEventsBox($day,$month,$year,$country,'general');
	//include(ODUDEDATE_PLUGIN_DIR . '/layout/general_bottom.php');
	//$disp.="</div>";
	//$disp.="</div>";
	return $disp;

}

				

}
add_shortcode('odude_date','date_main');





function date_other($atts)
{

global $wp_query;
global $wpdb;
$category=$atts['layout'];

if(isset($wp_query->query_vars['sday']) && isset($wp_query->query_vars['smonth']) && isset($wp_query->query_vars['syear']))
{
		$day=$wp_query->query_vars['sday'];
		$month=$wp_query->query_vars['smonth'];
		$year=$wp_query->query_vars['syear'];
			if($year=="0")
			$year=date('Y');
		$country=$wp_query->query_vars['scountry'];
		
		$datefor="$year-$month-$day";
		if($day=='' && $month=='' && $year=='')
		{
		 $datefor=date('Y')."-".date('m')."-".date('d');	
		}
		$disp="";
		
		
		$Vdata = file_get_contents(ODUDEDATE_PLUGIN_DIR . '/layout/'.$category.'_top.php');
		$disp.=$Vdata;
		$disp.= getEventsBox($day,$month,$year,$country,$category);
		$Vdata = file_get_contents(ODUDEDATE_PLUGIN_DIR . '/layout/'.$category.'_bottom.php');
		$disp.=$Vdata;
		return $disp;


}
else if(isset($wp_query->query_vars['sid']) && isset($wp_query->query_vars['syear']))
{

	return '';

}
else
{
	
	
			if($atts['group']=='')
			{
			if(isset($_COOKIE["odude_cal"]))
			$country=$_COOKIE["odude_cal"];
			else
			$country=$atts['group'];
			}
			else
			{
			$country=$atts['group'];
			}
		$day="";
		$month="";
		$year="";
		
		
		$datefor="$year-$month-$day";
		if($day=='' && $month=='' && $year=='')
		{
		 $datefor=date('Y')."-".date('m')."-".date('d');	
		}
		$disp="";
				
			
			
		$Vdata = file_get_contents(ODUDEDATE_PLUGIN_DIR . '/layout/'.$category.'_top.php');
		$disp.=$Vdata;
		$disp.= getEventsBox($day,$month,$year,$country,$category);
		$Vdata = file_get_contents(ODUDEDATE_PLUGIN_DIR . '/layout/'.$category.'_bottom.php');
		$disp.=$Vdata;
		
		
		
		return $disp;
		
}

				

}
add_shortcode('odude_other','date_other');



function odude_calendar($atts)
{
global $wp_query;
global $gcountry;
if(isset($wp_query->query_vars['sday']))
{
$day=$wp_query->query_vars['sday'];
$month=$wp_query->query_vars['smonth'];
$year=$wp_query->query_vars['syear'];
$country=$wp_query->query_vars['scountry'];
}
else
{
	
	if($atts['group']=='')
		{
			if(is_home())
			{
			
				$country=cookieCon();
			}
			else
			{
				$country=$gcountry;
			}
		}
	else
		{
		$country=$atts['group'];
		}

	/*
		if($atts['group']=='')
		{
			$country=cookieCon();
		}
			else
		{
		$country=$atts['group'];
		}
	*/	
		/*
		if(is_home())
		{
			$country=cookieCon();
		}
		else
		{
			$country=$atts['group'];
		}
		*/

$day="";
$month="";
$year="";
}

		
		if($day=='' && $month=='' && $year=='')
		{
		
		return draw_calendar(date('m'),date('Y'),$country)."\n\r".HolidayList(date('m'),date('Y'),$country);
		}
		else if($day=='' && $month!='' && $year!='')
		{
		return draw_calendar($month,$year,$country)."\n\r".HolidayList($month,$year,$country);
		}
		else
		{
		
		return draw_calendar($month,$year,$country)."\n\r".HolidayList($month,$year,$country);
		}
		

}
add_shortcode('odude_calendar','odude_calendar');


function date_search($atts)
{
//Searching for specific keyword at post page
//[odude_date_search type="event" country="NP" search="christmas"]

$type=$atts['type'];
$search=$atts['search'];
$country=$atts['group'];

global $wpdb;
//$getgalimages = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."odudedate WHERE `$type` LIKE '%$search%' and country='$country'  and Publish='1' order by year");

$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."odudedate WHERE `$type` LIKE '%%%s%%' and country=%s  and Publish='1' order by year",array($search,$country));
$getgalimages = $wpdb->get_results($sql);	
	
$disp="";
			if(count($getgalimages))
			{
			
			$disp.="<table class=\"pure-table pure-table-horizontal\"><thead><tr><th>Date</th><th>Title</th><th>Calendar</th></tr></thead><tbody>";
				foreach($getgalimages as $val)
				{
				$event = $val->event;
				$day=$val->day;
				$event_desc=$val->event_desp;
				$link=$val->link;
				$id=$val->id;
				$extra1=$val->extra1;
				$extra2=$val->extra2;
				$extra3=$val->extra3;
				$year=$val->year;
				$month=$val->month;
				$datefor="$year-$month-$day";
				$disp.="<tr><td>".iso2long($datefor)."<br>".odude_time_ago($datefor)."</td><td>$event</td><td><a href=\"http://datetimenow.com/calendar/$day/$month/$year/$country/\" class=\"pure-button pure-button-primary\">View</a></td></tr>";
				
				}
			$disp.="</tbody></table>";
			}	
			


return $disp;
				

}
add_shortcode('odude_date_search','date_search');

function odude_time($atts)
{
	
$country=cookieCon();

			if($atts['zone']=='')
			{
			$zone=zoneName($country);
			}
			else
			{
			$zone=$atts['zone'];
			}


date_default_timezone_set($zone);
$datefor=date('Y')."-".date('m')."-".date('d');	

$curtime=date("F d, Y H:i:s", time());
$f="";
//$f="24Hr. Clock of <b>".$zone."</b><br>";
$f.='<script type="text/javascript">

var currenttime = "'.$curtime.'" //PHP method of getting server date

var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
var serverdate=new Date(currenttime)
var diem = "AM";
var h = serverdate.getHours();
if (h == 0) {
    h = 12;
  } else if (h > 12) {
    h = h - 12;
    diem = "PM"
  }
function padlength(what){
var output=(what.toString().length==1)? "0"+what : what
return output
}

function displaytime(){
serverdate.setSeconds(serverdate.getSeconds()+1);
var datestring=montharray[serverdate.getMonth()]+" "+padlength(serverdate.getDate())+", "+serverdate.getFullYear();
var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())+" "+diem;
//document.getElementById("odude_servertime").innerHTML=datestring+"<br> "+timestring;
document.getElementById("odude_servertime").innerHTML=timestring;
}

window.onload=function(){
setInterval("displaytime()", 1000)
}

</script>

<div class="odude_servertime"><span id="odude_servertime"></span></div>
<div class="odude_serverdate"><span id="odude_serverdate"></span>'.iso2long($datefor).' '.$zone.'</div>';

return $f;

}
add_shortcode('odude_time','odude_time');

function odude_settimezone($atts)
{
global $default_code;
$zone=$atts['zone'];
			
			if($atts['zone']=='')
			{
			$zone=cookieTime();
			}
			
	
			
date_default_timezone_set($zone);
return "Time Zone: ".$zone;
}
//Just set TimeZone. No Output [odude_settimezone zone="Asia/Kathmandu"]
add_shortcode('odude_settimezone','odude_settimezone');

function odude_static_time($atts)
{
global $wp_query;
$zone=$atts['zone'];
$page=$atts['page'];


	if($atts['page']=='page')
		{
			if(isset($wp_query->query_vars['scountry']))
			{
			$country=$wp_query->query_vars['scountry'];
			$zone=zoneName($country);
			}
			else
			{
			$zone=cookieTime();
			}
		}
		else
		{

			if($atts['zone']=='')
			{
			$zone=cookieTime();
			}
		}

date_default_timezone_set($zone);
$timezone = new DateTimeZone($zone);
$datetime = new DateTime('now', $timezone);
$curtime=date("F d, Y H:i", time());
return $curtime. " GMT ".$datetime->format('P');

}
//Just displays static time. No animation.  [odude_static_time zone="Asia/Kathmandu"]
add_shortcode('odude_static_time','odude_static_time');

function odude_sethome_button($atts)
{
global  $site_url;
global $gcountry;
global $gzone;
$gcountry=$atts['group'];
$gzone=$atts['zone'];
$zone=$atts['zone'];
$country=$atts['group'];

return "<a href='".$site_url."?default=$country&zone=$zone' class='pure-button pure-button-active' >Set Home Calendar ($zone)</a>";

}
//Its add a set home button [odude_sethome country="NP" zone="Asia/Kathmandu"]
add_shortcode('odude_sethome_button','odude_sethome_button');



function odude_flag($atts)
{
global $wp_query;
global $gcountry;
$country=$atts['group'];
$size=$atts['size'];
$page=$atts['page'];

	/*
		if($atts['page']=='page')
		{
			if(isset($wp_query->query_vars['scountry']))
			{
			$country=$wp_query->query_vars['scountry'];
			}
			else
			{
			$country=cookieCon();
			}
		}
		else
		{
			if($atts['group']=='')
			{
				$country=cookieCon();
			}
		}
		*/
		
	
	if($atts['group']=='')
		{
			if(is_home())
			{
			
				$country=cookieCon();
			}
			else
			{
				$country=$gcountry;
			}
		}
	else
		{
		$country=$atts['group'];
		}

//$pic = plugins_url()."/odude-date/css/images/".$size."_".$country.".png";
$pic=plugins_url( '../css/images/'.$size.'_'.$country.'.png', __FILE__ );
$path = ODUDEDATE_PLUGIN_DIR. "css/images/".$size."_".$country.".png";

			
		
		if(file_exists($path))
		{
			return "<img src='$pic'>";
		}
		else
		{
			return "";
		}

}
//Its add a set home button [odude_flag group="NP" size="ico" page=""]
add_shortcode('odude_flag','odude_flag');


function odude_cal_list($atts)
{
global $wp_query;
$type=$atts['layout'];
global  $site_url;

	if(isset($wp_query->query_vars['smonth']))
	{
	$month=$wp_query->query_vars['smonth'];
	$year=$wp_query->query_vars['syear'];
	$country=$wp_query->query_vars['scountry'];
	
		
	}
	else
	{
		$month=$atts['month'];
		
		if($month=='')
		$month=date("m", time());
		
		$country=$atts['group'];
		$year=date("Y", time());
		
		if($atts['group']=='')
		{
		if(isset($_COOKIE["odude_cal"]))
		$country=$_COOKIE["odude_cal"];
		else
		$country='US';
		}

			
	}

//echo "$month - $country - $year";
	
global $wpdb;
		if($type=='celeb')
		{
		//$getgalimages = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."odudedate WHERE `category`='$type' and country='$country' and month='$month' and Publish='1' order by day");
		
		$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."odudedate WHERE `category`=%s and country=%s and month=%d and Publish='1' order by day",array($type,$country,$month));
$getgalimages = $wpdb->get_results($sql);	
		
		}
		else
		{
		//$getgalimages = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."odudedate WHERE `category`='$type' and country='$country' and month='$month' and year='$year' and Publish='1' order by day");
		
		$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."odudedate WHERE `category`=%s and country=%s and month=%d and year=%d and Publish='1' and event!='' order by day",array($type,$country,$month,$year));
$getgalimages = $wpdb->get_results($sql);	

		}
$disp="";
$disp='

<script>
function process()
{
var url="'.$site_url.'holiday/" + document.getElementById("month").value+"/" + document.getElementById("year").value+"/'.$country.'/";
location.href=url;
return false;
}
</script>
<form onSubmit="return process();">
<table  border=0 ><tr><td width="20%">
<select id="month" name="month"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>
</td><td width="15%"><select id="year" name="year">
<option value="2015">2015</option>
<option value="2016">2016</option>
</select></td><td> <input type="submit" class="submit" value="view"></td></tr></table>
</form>
';	
$disp.="<h6>".conName($country)." - ".monthName($month)."</h6>";
//$disp.="<br><a title='January' href='".$site_url."holiday/1/$year/$country/'>JAN</a> | <a title='February' href='http://datetimenow.com/holiday/2/$year/$country/'>FEB</a> | <a title='March' href='http://datetimenow.com/holiday/3/$year/$country/'>MAR</a> | <a title='April' href='http://datetimenow.com/holiday/4/$year/$country/'>APR</a> | <a title='May' href='http://datetimenow.com/holiday/5/$year/$country/'>MAY</a> | <a title='June' href='http://datetimenow.com/holiday/6/$year/$country/'>JUN</a> | <a title='July' href='http://datetimenow.com/holiday/7/$year/$country/'>JUL</a> | <a title='August' href='http://datetimenow.com/holiday/8/$year/$country/'>AUG </a>| <a title='September' href='http://datetimenow.com/holiday/9/$year/$country/'>SEP</a> | <a title='October' href='http://datetimenow.com/holiday/10/$year/$country/'>OCT</a> |<a title='November' href='http://datetimenow.com/holiday/11/$year/$country/'>NOV</a> | <a title='December' href='http://datetimenow.com/holiday/12/$year/$country/'>DEC</a> $year <br>";
			if(count($getgalimages))
			{
			$disp.="<table class=\"pure-table pure-table-horizontal\"><thead><tr><th>Date</th><th></th><th>Title</th><th>Duration</th><th>Calendar</th></tr></thead><tbody>";
			
				foreach($getgalimages as $val)
				{
				$event = $val->event;
				$day=$val->day;
				$event_desc=$val->event_desp;
				$link=$val->link;
				$id=$val->id;
				$extra1=$val->extra1;
				$extra2=$val->extra2;
				$extra3=$val->extra3;
				//$year=$val->year;
				$month=$val->month;
				$datefor="$year-$month-$day";
				
				if($extra3!="")
				$extra3="<img src='$extra3'>";
				
					if($link!='')
					{
						if (strpos($link, 'datetimenow') !== false)
						{
						$event="<a href='$link'>$event</a>";
						
						}
						else
						{
						//$pic = plugins_url().'/odude-date/css/images/link.png';
						$pic=plugins_url( '../css/images/link.png', __FILE__ );
						$event="<a href='$link' target='_blank'>$event</a>&nbsp; <img src='$pic'>";
						}
					} 
				
				if($type=='celeb')
				{
				$disp.="<tr><td>$day/$month/$year</td><td>$extra3</td><td><b>$event</b></td><td>".odude_time_ago($datefor)."</td><td><a href=\"".$site_url."calendar/$day/$month/$year/$country/\" class=\"pure-button\">View</a></td></tr>";
				}
				else
				{
				
					
				
				$disp.="<tr><td>$day/$month/$year</td><td></td><td><b>$event</b></td><td>".odude_time_ago($datefor)."</td><td><a href=\"".$site_url."calendar/$day/$month/$year/$country/\" class=\"pure-button\">View</a></td></tr>";
				
				}
				}
			$disp.="</tbody></table>";
			}	
			


return $disp;
				

}
//[odude_cal_list layout="celeb" country="NP" month="2"]
add_shortcode('odude_cal_list','odude_cal_list');



?>