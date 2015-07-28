<?php
 $current_user = wp_get_current_user();
 $username= $current_user->user_login;
global  $site_url;
 global $pro_active;
 
 $w_large_size=get_option('w_large_size');
 if($w_large_size=='')
 {
	 	 
	 echo "<div class=\"wrap\"><hr><h4>ODude Date Setting is not yet saved. Please save settings before you proceed. </h4></div>";
 }
 else
 {
	
 
if($username=="admin")
 $mypage="odudedate";
 else
 $mypage="odudedate";


 
 global $wpdb;
 
if(isset($_GET['edit']))
$edit=$_GET['edit'];
else
$edit="";

if($edit!="")
{
	if($username=="admin")
	{
	//$getres = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."odudedate WHERE id = '$edit'");
	$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."odudedate WHERE id = %d",array($edit));
	$getres = $wpdb->get_results($sql);
	}
	else
	{
	//$getres = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."odudedate WHERE id = '$edit' and user='$username'");
	$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."odudedate WHERE id = %d and user=%s",array($edit,$username));
	$getres = $wpdb->get_results($sql);
	}
		if(count($getres))
			{
						
			?>
			
							<h1>Editing (<?php echo $username; ?>)</h1>
							
							<form method="get" action="">
								<input type="hidden" name="page" value="<?php echo $mypage; ?>">
								<input type="hidden" name="id" value="<?php echo $edit; ?>">
								<input type="hidden" name="check" value="update">
								<table class="form-table">
								<tr>
									<th scope="row">
										<label for="my-text-field">Event Title:</label>
									</th>
								 
									<td>
										<input type="text" value="<?php echo $getres[0]->event; ?>" id="event" name="event" class="regular-text">
										<br>
										<span class="description">Topic of the event</span>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="my-text-field">Event Description</label>
									</th>
								 
									<td>
									  <?php
				$content = $getres[0]->event_desp;
				$editor_id = 'event_desp';
				$args = array(
					'textarea_rows' => 10,
					'teeny' => false,
					'quicktags' => true
				);

				wp_editor( $content, $editor_id, $args);

				?>

									</td>
								</tr>


								<tr>
									<th scope="row">
										<label for="my-text-field">Extra1 :</label>
									</th>
								 
									<td>
										<input type="text" name="extra1" value="<?php echo $getres[0]->extra1; ?>">
										
										<span class="description">Just single line extra information below the topic.</span>
									</td>
								</tr>

								<tr>
									<th scope="row">
										<label for="my-text-field">Extra2 :</label>
									</th>
								 
									<td>
										 <input type="text" name="extra2" value="<?php echo $getres[0]->extra2; ?>">
										
										<span class="description">Short single line extra information displayed along with topic.</span>
									</td>
								</tr>



								<tr>
									<th scope="row">
										<label for="my-text-field">Image URL :</label>
									</th>
								 
									<td>
										 <input type="text" name="extra3" class="regular-text" value="<?php echo $getres[0]->extra3; ?>">
										<br>
										<span class="description">Eg. http://www.google.com/abc.jpg<br>(Remote image will be locally saved with new thumbnail)</span>
									</td>
								</tr>



								<tr>
									<th scope="row">
										<label for="my-text-field">Scheduled date</label>
									</th>
								 
									<td>
										<select name="day">
				<option value="01" <?php if ($getres[0]->day=='1') echo 'selected="selected"';?>>01</option>
				<option value="02" <?php if ($getres[0]->day=='2') echo 'selected="selected"';?>>02</option>
				<option value="03" <?php if ($getres[0]->day=='3') echo 'selected="selected"';?>>03</option>
				<option value="04" <?php if ($getres[0]->day=='4') echo 'selected="selected"';?>>04</option>
				<option value="05" <?php if ($getres[0]->day=='5') echo 'selected="selected"';?>>05</option>
				<option value="06" <?php if ($getres[0]->day=='6') echo 'selected="selected"';?>>06</option>
				<option value="07" <?php if ($getres[0]->day=='7') echo 'selected="selected"';?>>07</option>
				<option value="08" <?php if ($getres[0]->day=='8') echo 'selected="selected"';?>>08</option>
				<option value="09" <?php if ($getres[0]->day=='9') echo 'selected="selected"';?>>09</option>
				<option value="10" <?php if ($getres[0]->day=='10') echo 'selected="selected"';?>>10</option>
				<option value="11" <?php if ($getres[0]->day=='11') echo 'selected="selected"';?>>11</option>
				<option value="12" <?php if ($getres[0]->day=='12') echo 'selected="selected"';?>>12</option>
				<option value="13" <?php if ($getres[0]->day=='13') echo 'selected="selected"';?>>13</option>
				<option value="14" <?php if ($getres[0]->day=='14') echo 'selected="selected"';?>>14</option>
				<option value="15" <?php if ($getres[0]->day=='15') echo 'selected="selected"';?>>15</option>
				<option value="16" <?php if ($getres[0]->day=='16') echo 'selected="selected"';?>>16</option>
				<option value="17" <?php if ($getres[0]->day=='17') echo 'selected="selected"';?>>17</option>
				<option value="18" <?php if ($getres[0]->day=='18') echo 'selected="selected"';?>>18</option>
				<option value="19" <?php if ($getres[0]->day=='19') echo 'selected="selected"';?>>19</option>
				<option value="20" <?php if ($getres[0]->day=='20') echo 'selected="selected"';?>>20</option>
				<option value="21" <?php if ($getres[0]->day=='21') echo 'selected="selected"';?>>21</option>
				<option value="22" <?php if ($getres[0]->day=='22') echo 'selected="selected"';?>>22</option>
				<option value="23" <?php if ($getres[0]->day=='23') echo 'selected="selected"';?>>23</option>
				<option value="24" <?php if ($getres[0]->day=='24') echo 'selected="selected"';?>>24</option>
				<option value="25" <?php if ($getres[0]->day=='25') echo 'selected="selected"';?>>25</option>
				<option value="26" <?php if ($getres[0]->day=='26') echo 'selected="selected"';?>>26</option>
				<option value="27" <?php if ($getres[0]->day=='27') echo 'selected="selected"';?>>27</option>
				<option value="28" <?php if ($getres[0]->day=='28') echo 'selected="selected"';?>>28</option>
				<option value="29" <?php if ($getres[0]->day=='29') echo 'selected="selected"';?>>29</option>
				<option value="30" <?php if ($getres[0]->day=='30') echo 'selected="selected"';?>>30</option>
				<option value="31" <?php if ($getres[0]->day=='31') echo 'selected="selected"';?>>31</option>
				</select>
								
				<select id="month" name="month">
				<option value="1" <?php if ($getres[0]->month=='1') echo 'selected="selected"';?>>January</option>
				<option value="2" <?php if ($getres[0]->month=='2') echo 'selected="selected"';?>>February</option>
				<option value="3" <?php if ($getres[0]->month=='3') echo 'selected="selected"';?>>March</option>
				<option value="4" <?php if ($getres[0]->month=='4') echo 'selected="selected"';?>>April</option>
				<option value="5" <?php if ($getres[0]->month=='5') echo 'selected="selected"';?>>May</option>
				<option value="6" <?php if ($getres[0]->month=='6') echo 'selected="selected"';?>>June</option>
				<option value="7" <?php if ($getres[0]->month=='7') echo 'selected="selected"';?>>July</option>
				<option value="8" <?php if ($getres[0]->month=='8') echo 'selected="selected"';?>>August</option>
				<option value="9" <?php if ($getres[0]->month=='9') echo 'selected="selected"';?>>September</option>
				<option value="10" <?php if ($getres[0]->month=='10') echo 'selected="selected"';?>>October</option>
				<option value="11" <?php if ($getres[0]->month=='11') echo 'selected="selected"';?>>November</option>
				<option value="12" <?php if ($getres[0]->month=='12') echo 'selected="selected"';?>>December</option>
				</select>
				
				
				<select id="year" name="year">
				<option value="2015" <?php if ($getres[0]->year=='2014') echo 'selected="selected"';?>>2014</option>
				<option value="2015" <?php if ($getres[0]->year=='2015') echo 'selected="selected"';?>>2015</option>
				<option value="2016" <?php if ($getres[0]->year=='2016') echo 'selected="selected"';?>>2016</option>
				<option value="0" <?php if ($getres[0]->year=='0') echo 'selected="selected"';?>>Repeat</option>
				</select>
										<br>
										<span class="description">All events are treated as full day event.</span>
									</td>
								</tr>


								<tr>
									<th scope="row">
										<label for="my-text-field">Group or Category:</label>
									</th>
								 
									<td>
										   <?php echo ODudeGroup('all','all','admin','country',$getres[0]->country); ?>
										<br>
										<span class="description">Choose appropriate group.<br>If (COMMON GROUP) is chosen the event will appear in all the group.</span>
									</td>
								</tr>


								<tr>
									<th scope="row">
										<label for="my-text-field">Link :</label>
									</th>
								 
									<td>
										  <input type="text" name="link" class="regular-text" value="<?php echo $getres[0]->link; ?>">
										<br>
										<span class="description">Eg. http://www......... (Linking event to other website or own article.) <br> It will be linked with [More Deatail] button at article page.</span>
									</td>
								</tr>


								<tr>
									<th scope="row">
										<label for="my-text-field">Make RED :</label>
									</th>
								 
									<td>
										<select id="holiday" name="holiday">
										<option value="0" <?php if ($getres[0]->Holiday=='0') echo 'selected="selected"';?> >No</option>
										<option value="1" <?php if ($getres[0]->Holiday=='1') echo 'selected="selected"';?> >YES</option>
										</select> 
										<br>
										<span class="description">red.png will appear and calendar will be marked with RED box</span>
									</td>
								</tr>

								<tr>
									<th scope="row">
										<label for="my-text-field">Tag as:</label>
									</th>
								 
									<td>
										 	<select id="category" name="category">
											<option value="general" <?php if ($getres[0]->category=='general') echo 'selected="selected"';?>>General</option>
											<option value="celeb" <?php if ($getres[0]->category=='celeb') echo 'selected="selected"';?>>Celeb</option>
											<option value="extra" <?php if ($getres[0]->category=='extra') echo 'selected="selected"';?>>Extra</option>
											</select>
										<br>
										<span class="description">GENERAL: It is treated as main event. Green box will appear for each entry at calendar.<br>
																	CELEB: It is specially for person/people. Eg. Celebrities birthday or Anniversary. No colours at calendar.<br>
																	EXTRA: It is just a extra. No colours will be changed at calendar. </span>
									</td>
								</tr>

								<tr>
									<th scope="row">
										<label for="my-text-field">Publish this event:</label>
									</th>
								 
									<td>
										 <select id="publish" name="publish">
											<option value="0" <?php if ($getres[0]->Publish=='0') echo 'selected="selected"';?> >No</option>
											<option value="1" <?php if ($getres[0]->Publish=='1') echo 'selected="selected"';?> >YES</option>
											</select>
										<br>
										<span class="description">It just means you want to hide or show this event.</span>
									</td>
								</tr>
								
								<tr>
									<th scope="row">
										<label for="my-text-field">Delete this event:</label>
									</th>
								 
									<td>
										  <select id="delete" name="delete">
										<option value="no">No</option>
										<option value="yes">Yes</option>
										</select>
										<br>
										<span class="description">This will delete the event along with image. It cannot be reverted back.</span>
									</td>
								</tr>

								</table>
								 <p class="submit"><input type="submit" value="Submit Event" class="button-primary" name="Submit"></p>
								</form>
							
							
							
				
							
							<?php
			}
			else
			{
			
			echo "not found";
			}
			

}
else
{

?>





<h1>Posting (<?php echo $username; ?>) </h1>
<form method="get" action="">
<input type="hidden" name="page" value="<?php echo $mypage; ?>">
<input type="hidden" name="check" value="post">
<table class="form-table">
<tr>
    <th scope="row">
        <label for="my-text-field">Event Title:</label>
    </th>
 
    <td>
        <input type="text" value="" id="event" name="event" class="regular-text">
       
        <span class="description">Topic of the event</span>
    </td>
</tr>
<tr>
    <th scope="row">
        <label for="my-text-field">Event Description</label>
    </th>
 
    <td>
       <?php
$content = '';
$editor_id = 'event_desp';
$args = array(
    'textarea_rows' => 10,
    'teeny' => false,
    'quicktags' => true
);

wp_editor( $content, $editor_id, $args);

?>

    </td>
</tr>


<tr>
    <th scope="row">
        <label for="my-text-field">Extra1 :</label>
    </th>
 
    <td>
        <input type="text" name="extra1">
       
        <span class="description">Just single line extra information below the topic.</span>
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="my-text-field">Extra2 :</label>
    </th>
 
    <td>
         <input type="text" name="extra2">
       
        <span class="description">Short single line extra information displayed along with topic.</span>
    </td>
</tr>



<tr>
    <th scope="row">
        <label for="my-text-field">Image URL :</label>
    </th>
 
    <td>
         <input type="text" name="extra3" class="regular-text">
        <br>
        <span class="description">Eg. http://www.google.com/abc.jpg<br>(Remote image will be locally saved with new thumbnail)</span>
    </td>
</tr>



<tr>
    <th scope="row">
        <label for="my-text-field">Scheduled date</label>
    </th>
 
    <td>
         <select name="day">
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>
<select id="month" name="month"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>
<select id="year" name="year">
<option value="2015">2014</option>
<option value="2015" selected>2015</option>
<option value="2016">2016</option>
<option value="0">Repeat</option>
</select>
        <br>
        <span class="description">All events are treated as full day event.</span>
    </td>
</tr>


<tr>
    <th scope="row">
        <label for="my-text-field">Group or Category:</label>
    </th>
 
    <td>
          <?php echo ODudeGroup('all','all','admin'); ?>
        <br>
        <span class="description">Choose appropriate group.<br>If (COMMON GROUP) is chosen the event will appear in all the group.</span>
    </td>
</tr>


<tr>
    <th scope="row">
        <label for="my-text-field">Link :</label>
    </th>
 
    <td>
          <input type="text" name="link" class="regular-text">
        <br>
        <span class="description">Eg. http://www......... (Linking event to other website or own article.) <br> It will be linked with [More Deatail] button at article page.</span>
    </td>
</tr>


<tr>
    <th scope="row">
        <label for="my-text-field">Make RED :</label>
    </th>
 
    <td>
         <select id="holiday" name="holiday">
		<option value="0">No</option>
		<option value="1">YES</option>
		</select> 
        
        <span class="description">red.png will appear and calendar will be marked with RED box</span>
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="my-text-field">Tag as:</label>
    </th>
 
    <td>
         <select id="category" name="category">
		<option value="general">general</option>
		<option value="celeb">celeb</option>
		<option value="extra">extra</option>
		</select>
        <br>
        <span class="description">GENERAL: It is treated as main event. Green box will appear for each entry at calendar.<br>
									CELEB: It is specially for person/people. Eg. Celebrities birthday or Anniversary. No colours at calendar.<br>
									EXTRA: It is just a extra. No colours will be changed at calendar. </span>
    </td>
</tr>



</table>
 <p class="submit"><input type="submit" value="Submit Event" class="button-primary" name="Submit"></p>
</form>


<?php
global $wpdb;



if(isset($_GET['check']))
	{
	$check=$_GET['check'];
	$day=$_GET['day'];
	$month=$_GET['month'];
	$year=$_GET['year'];
	}
	else
	{
	$check="";
	$day="";
	$month="";
	$year="";

	}

if($check=='post')
{
//Insert Event
	$event=$_GET['event'];
	$link=$_GET['link'];
	$event_desp=$_GET['event_desp'];
	$extra1=$_GET['extra1'];
	$extra2=$_GET['extra2'];
	$extra3=$_GET['extra3'];
	$country=$_GET['country'];
	$holiday=$_GET['holiday'];
	$category=$_GET['category'];
	if($day=='' || $month=='' || $year=='')
		{
		echo "Date is empty";
		}
		else
		{
			//$rec=getEventsList($day,$month,$year,$category,$country);
			//if($rec!='0')
			//{
				//echo "<h1>Already Exists </h1>- $rec";
			//}
			//else
			//{
			$query =  "insert into ".$wpdb->prefix."odudedate values(null,'$event','$event_desp','$extra1','$extra2','$extra3','$country','$day','$month','$year','$username','$link','$category','$holiday','1',now())";
			$wpdb->query($query);
			echo "Event Inserted : <a href='". $site_url."calendar/$day/$month/$year/$country/' target='_blank'>View</a><br>";
			//}
		}
}
else if($check=='update')
{
	$id=$_GET['id'];
	$event=$_GET['event'];
	$link=$_GET['link'];
	$event_desp=$_GET['event_desp'];
	$extra1=$_GET['extra1'];
	$extra2=$_GET['extra2'];
	$extra3=$_GET['extra3'];
	$country=$_GET['country'];
	$holiday=$_GET['holiday'];
	$category=$_GET['category'];
	$delete=$_GET['delete'];
	$publish=$_GET['publish'];
	
	if($delete=="yes")
	{
	
		if($username=="admin")
		$query =  "DELETE FROM ".$wpdb->prefix."odudedate WHERE `id` ='$id'";
		else
		$query =  "DELETE FROM ".$wpdb->prefix."odudedate WHERE `id` ='$id' and user='$username'";
		
		$wpdb->query($query);
		echo "Deleted: $event";
	}
	else
	{
		
		if($username=="admin")
		$query =  "UPDATE ".$wpdb->prefix."odudedate SET `event` = '$event',`event_desp` = '$event_desp',`extra1` = '$extra1',`extra2` = '$extra2',`extra3` = '$extra3',`country` = '$country',`day` = '$day',`month` = '$month',`year` = '$year',`link` = '$link',`category` = '$category',`Holiday` = '$holiday',`Publish` = '$publish',`pdate` = now()  WHERE `id` ='$id'";
		else
		$query =  "UPDATE ".$wpdb->prefix."odudedate SET `event` = '$event',`event_desp` = '$event_desp',`extra1` = '$extra1',`extra2` = '$extra2',`extra3` = '$extra3',`country` = '$country',`day` = '$day',`month` = '$month',`year` = '$year',`link` = '$link',`category` = '$category',`Holiday` = '$holiday',`Publish` = '$publish',`pdate` = now()  WHERE `id` ='$id' and user='$username'";
		$wpdb->query($query);
		
		echo "Updated <a href='". $site_url."calendar/$day/$month/$year/$country/' target='_blank'>View</a><br><br>";
		if($extra3=="" && $pro_active=='1')
		echo dynamicImage($event,$id,true);
	
	}

}
else
{
echo "<hr>";
}
}
 }
?>