<html>
<head>
<title>Schedule your time slot below</title>
</head>

<?PHP

$eightAmSlot = 'unchecked';
$nineAmSlot = 'unchecked';
$tenAmSlot = 'unchecked';
$elevenAmSlot = 'unchecked';
$twelvePmSlot = 'unchecked';
$onePmSlot = 'unchecked';
$twoPmSlot = 'unchecked';
$threePmSlot = 'unchecked';
$fourPmSlot = 'unchecked';

if (isset($_POST['Submit1'])) {

	$selected_radio = $_POST['timeslot'];
	
		if ($selected_radio == '8am') {
			$eightAmSlot = 'checked';

		}
		else if ($selected_radio == '9am') {
			$nineAmSlot = 'checked';
        }
        

		else if ($selected_radio == '10am') {
			$tenAmSlot = 'checked';

		}
		else if ($selected_radio == '11am') {
			$elevenAmSlot  = 'checked';
        }
        

		else if ($selected_radio == '12pm') {
			$twelvePmSlot = 'checked';

		}
		else if ($selected_radio == '1pm') {
			$onePmSlot  = 'checked';
        }
        

		else if ($selected_radio == '2pm') {
			$twoPmSlot  = 'checked';

		}
		else if ($selected_radio == '3pm') {
			$threePmSlot = 'checked';
        }
        

		else if ($selected_radio == '4pm') {
			$fourPmSlot = 'checked';
		}
}

?>

<body>

<FORM NAME ="form1" METHOD ="POST" ACTION ="schedule.php">

<INPUT TYPE = 'Radio' Name ='timeslot'  value= '8am' <?PHP print $eightAmSlot; ?>>8 am - 9 am

<INPUT TYPE = 'Radio' Name ='timeslot'  value= '9am' <?PHP print $nineAmSlot; ?>>9 am - 10 am

<INPUT TYPE = 'Radio' Name ='timeslot'  value= '10am' <?PHP print $tenAmSlot; ?>>10 am - 11 am

<INPUT TYPE = 'Radio' Name ='timeslot'  value= '11am' <?PHP print $elevenAmSlot; ?>>11 am - 12 pm

<INPUT TYPE = 'Radio' Name ='timeslot'  value= '12pm' <?PHP print $twelvePmSlot; ?>>12 pm - 1 pm

<INPUT TYPE = 'Radio' Name ='timeslot'  value= '1pm' <?PHP print $onePmSlot; ?>>1 pm - 2 pm

<INPUT TYPE = 'Radio' Name ='timeslot'  value= '2pm' <?PHP print $twoPmSlot ; ?>>2 pm - 3 pm

<INPUT TYPE = 'Radio' Name ='timeslot'  value= '3pm' <?PHP print $threePmSlot; ?>>3 pm - 4 pm

<INPUT TYPE = 'Radio' Name ='timeslot'  value= '4pm' <?PHP print $fourPmSlot; ?>>4 pm - 5 pm

<P>
<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Submit Slot">
</FORM>

</body>
</html>


