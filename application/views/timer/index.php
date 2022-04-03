<h1 class="page-header">
	Timer
</h1>

<table class="table">
	<tr>
		<th>Dato</th>
		<th>Navn</th>
		<th>Tid</th>
		<th>Status</th>
		<th></th>
	</tr>
	<?php
	$prevDate = date("Y-m-d");
	
	$this->db->order_by('id','desc');
	$sql = $this->db->get('timer_total')->result();
	
	foreach($sql as $row):
	
	// get user 
	$this->db->where('id',$row->uid);
	$user = $this->db->get('users_kasse')->result();
	
	if($user){
		$name = $user[0]->name;
	}else{
		$name = '';
	}
	
	// check if active
	$this->db->where('date',$row->date);
	$this->db->where('active',1);
	$this->db->where('uid',$row->uid);
	$active = $this->db->get('timer')->result();
	
	if($active){
		$active_inactiv = 'Aktiv';
		$active_label = 'label-success';
		
		// add active seconds to total
		$currentTotalActive = time()-$active[0]->start;
		
		$total_seconds_active = (int)$row->total_seconds+$currentTotalActive;
				
		$total_hours = (int)gmdate("H", $total_seconds_active);
		$total_minutes = (int)gmdate("i", $total_seconds_active);
		$total_seconds = (int)gmdate("s", $total_seconds_active);
		
	}else{
		$active_inactiv = 'Inaktiv';
		$active_label = 'label-danger';
		
		$total_hours = $row->hours;
		$total_minutes = $row->minutes;
		$total_seconds = $row->seconds;
		
	}
	
	if($row->date == date("Y-m-d")){
		$date = 'I dag';
	}elseif($row->date == date("Y-m-d",strtotime("-1 day"))){
		$date = 'Igår';
	}else{
		$date = $row->date;
	}
	
	if($row->date != $prevDate){
	?>
	<tr>
		<td colspan="6"><hr style="border-top: 4px solid #ececec" /></td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td><?=$date;?></td>
		<td><?=$name;?></td>
		<td>
			<?php if($total_hours < 10): echo '0'; endif; echo $total_hours; ?>:<?php if($total_minutes < 10): echo '0'; endif; echo $total_minutes; ;?>:<?php if($total_seconds < 10): echo '0'; endif; echo $total_seconds; ;?></td>
		<td><span class="label <?=$active_label;?>"><?=$active_inactiv;?></span></td>
		<td align="right"><a href="#" class="btn btn-default btn-xs showDetailsTimer" data-id="<?=$row->date;?>-<?=$row->uid;?>">Vis detaljeret</a></td>
	</tr>
	<?php
	$prevEndTime = 0;
	
	$this->db->where('date',$row->date);
	$this->db->where('uid',$row->uid);
	$this->db->order_by('id');
	$timer_for_date = $this->db->get('timer')->result();
	
	foreach($timer_for_date as $timer_date):
	
	if($timer_date->end == false){
		$counted_seconds = time()-$timer_date->start;
	}else{
		$counted_seconds = $timer_date->end-$timer_date->start;
	}
	
	if($prevEndTime){
		$getDifferentTime = $timer_date->start-$prevEndTime;
		$diff_hours = gmdate("H", $getDifferentTime);
		$diff_minutes = gmdate("i", $getDifferentTime);
		$diff_seconds = gmdate("s", $getDifferentTime);
		$inactive_line = true;
	}else{
		$inactive_line = false;
	}
	
	$total_seconds = $counted_seconds;
	
	$hours = gmdate("H", $total_seconds);
	$minutes = gmdate("i", $total_seconds);
	$seconds = gmdate("s", $total_seconds);
	
	if($inactive_line){
	?>
	<tr style="font-size: 12px; display: none" class="show_more_<?=$row->date;?>-<?=$row->uid;?>">
		<td></td>
		<td></td>
		<td>
			<?php echo $diff_hours; ?>:<?php echo $diff_minutes; ?>:<?php echo $diff_seconds; ?><br /><small> (<?=date("H:i:s",$prevEndTime);?> til <?php echo date("H:i:s",$timer_date->start);?>)</small>
		</td>
		<td>
			<span class="label label-danger">Inaktiv</span>
		</td>
		<td></td>
	</tr>
	<?php
	}
	?>
	<tr style="font-size: 12px; display: none" class="show_more_<?=$row->date;?>-<?=$row->uid;?>">
		<td></td>
		<td></td>
		<td>
			<?php echo $hours; ?>:<?php echo $minutes; ?>:<?php echo $seconds; ?><br /><small> (<?=date("H:i:s",$timer_date->start);?> til <?php if($timer_date->end): echo date("H:i:s",$timer_date->end); else: echo 'nu'; endif; ?>)</small>
		</td>
		<td>
			<span class="label label-success">Aktiv</span>
		</td>
		<td></td>
	</tr>
	<?php
	
	if($timer_date->end){
		$prevEndTime = $timer_date->end;
	}
	
	endforeach;	
	
	$prevDate = $row->date;
		
	endforeach;
	?>
</table>