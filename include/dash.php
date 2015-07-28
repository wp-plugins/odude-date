	<h2 id="" class="nav-tab-wrapper">
	<a id="general" class="nav-tab nav-tab-active" href="#">Welcome to ODude Date Admin Dashboard</a>
	</h2>
	
	
	<?php
function dateToCal($timestamp) 
{
return date('Ymd\THis\Z', $timestamp);
}
// Escapes a string of characters
function escapeString($string) 
{
return trim(preg_replace('/([\,;])/','\\\$1', $string));
}

?>



<?php


function odudedate_xml($country)
{
	define('DATE_ICAL', 'Ymd\THis\Z');
	$uploaddir = wp_upload_dir();
	global $wp_query;
	global $wpdb;
	$siteurl= get_site_url().'/calendar/';
	//$blog_details = get_current_site();
	$rssfeed .= "BEGIN:VCALENDAR\r\n";
	$rssfeed .= "METHOD:PUBLISH\r\n";
    $rssfeed .= "VERSION:2.0\r\n";
    $rssfeed .= "PRODID:-//".get_bloginfo('name').'-'.conName($country)."//NONSGML v1.0//EN\r\n";
	$rssfeed .= "X-WR-CALNAME:".get_bloginfo('name')."\r\n";
	$rssfeed .= "CALSCALE:GREGORIAN\r\n";
	//$rssfeed .= "X-WR-TIMEZONE:Asia/Katmandu\r\n";

//$rssfeed .= "X-WR-TIMEZONE:Asia/Katmandu\r\n";
	//loooop
	
	$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."odudedate WHERE (country='%%%s%%' or country='all') and Publish='1' ORDER BY id DESC limit 0,5 ",array($term));
	$getgalimages = $wpdb->get_results($sql);
		if(count($getgalimages))
				{
					
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
						
						$datetime = new DateTime($datefor);
						//$datetime->modify('+1 day');
						$day=$datetime->format("d");
						$month=$datetime->format("m");
						$year=$datetime->format("Y");
						$dateforD="$year$month$day";
						
						
						$pdate=$val->pdate;
						$address="";
					
						if($extra3!="")
						$imgsrc=$uploaddir['baseurl'].'/odude-date/thumb_'.$id.'jpg';
						else
						$imgsrc="";
						
						$rssfeed .= "BEGIN:VEVENT\r\n";
						$rssfeed .= "STATUS:CONFIRMED\r\n";
						//$rssfeed .= "DTSTAMP:".dateToCal(time())."\r\n";
						//$rssfeed .= "DTSTART:".dateToCal(time())."\r\n";
						//$rssfeed .= "DTEND:".dateToCal(time())."\r\n";
						$rssfeed .= "DTSTART;VALUE=DATE:".$dateforD."\r\n";
						
						//overriding values
						$datefor="$year-$month-$day";
						
						$datetime = new DateTime($datefor);
						$datetime->modify('+1 day');
						$day=$datetime->format("d");
						$month=$datetime->format("m");
						$year=$datetime->format("Y");
						$dateforD="$year$month$day";
						
						$rssfeed .= "DTEND;VALUE=DATE:".$dateforD."\r\n";
						//$rssfeed .= "CREATED:20130214T141201Z\r\n";
						$rssfeed .= "LAST-MODIFIED:".date(DATE_ICAL, strtotime($pdate))."\r\n";
						$rssfeed .= "UID:".$id."\r\n";
						$rssfeed .= "LOCATION:".escapeString($address)."\r\n";
						$rssfeed .= "DESCRIPTION:".escapeString($desp)."\r\n";
						$rssfeed .= "URL;VALUE=URI:".$siteurl.''.$id.'/'.toSafeURL($event, "'")."\r\n";
						$rssfeed .= "SUMMARY:".escapeString($event)."\r\n";
						
						$rssfeed .= "END:VEVENT\r\n";				
					}
				
				}					
	//end
	$rssfeed .= 'END:VCALENDAR';
				
				$path = $uploaddir['basedir'].'/odude-date/'.get_option('xmlpwd').'.ics';
				$opath = $uploaddir['baseurl'].'/odude-date/'.get_option('xmlpwd').'.ics';
				$myfile = fopen($path, "w") or die("Unable to open file!");
				fwrite($myfile, $rssfeed);
				fclose($myfile);
				
				return "<br>Created: ".$opath."<br>Total No.".count($getgalimages)." records.";
}
?>
<div class="wrap">

<a href="http://www.odude.com"><img src="http://odude.com/icon-128x128.jpg" border="1"></a>
<br>
Visit <a href="http://www.odude.com/wordpress/">ODude.com</a> for more information.

<?php
$uploaddir = wp_upload_dir();
	
	
		$custom_upload_folder= $uploaddir['basedir'] . '/odude-date';
		if (!is_dir($custom_upload_folder))
		 {
			mkdir($custom_upload_folder);
		 }
		
		echo "<br><br>Checking Settings...<hr>";
 
if(is_writable($custom_upload_folder))
{ 
    echo "Media upload folder is writeable. [OK]"; 
} 
else
{ 
   echo "The directory is not writeable. ".$custom_upload_folder." [Solve this issue by creating this folder]"; 
} 
if(get_option('xmlon')=='on')
		{
			global $default_code;
			echo "<hr>";
			$msg="Generate XML File for ".conName($default_code);
			//echo $msg;
			?>
			<form method="get" action="">
			<input type="hidden" name="page" value="odudedate_dash">
			<input type="hidden" name="check" value="genxml">
			<input type="submit" name="" id="doaction2" class="button action" value="<?php echo $msg; ?>">
			</form>
			
			<?php
			
			if(isset($_GET['check']))
			if($_GET['check']=='genxml')
			{
				echo "Generateing file.....";
				echo odudedate_xml($default_code);
				
			}
			
		}
		else
		{
			echo "<hr>XML OFF - Delete file";
		}
?>
		

</div>