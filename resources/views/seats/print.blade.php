
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/forms/switch.css') }}">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <button type="button" value="Print"  onclick="window.print(); getElementById('hidden-div').style.display = 'block'; this.style.display = 'none'">Print</button>
<?php
//Columns must be a factor of 12 (1,2,3,4,6,12)
$num=0;
?>
<div class="row">
<?php
foreach ($members as $member){
	//dd($member->seat_no);
?>  
        	<div class="col-sm-6">
                <h1 style="font-size:50px;"><?php echo $member->seat_no;?></h1>
				<h2 style="font-size:40px;"><?php echo $member->first_name;?></h2>
				<h3 style="font-size:30px;"><?php echo $member->surname;?></h3>
				<h4 style="font-size:20px;"><?php echo $member->degree_name;?></h4>
            </div>
<?php
    $num=$num+1;
    if($num % 2 == 0) echo '</div><div class="row">';
}
?>
</div>
