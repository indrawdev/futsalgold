<?php require_once('Connections/Konek.php'); ?>
<?php include "function.php" ?>	
<link rel="stylesheet" href="system.css" type="text/css" media="screen" />
	
	<link rel="stylesheet" type="text/css" href="plugin/durasi/css/calendar-eightysix-v1.1-default.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="plugin/durasi/css/calendar-eightysix-v1.1-vista.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="plugin/durasi/css/calendar-eightysix-v1.1-osx-dashboard.css" media="screen" />
	
	<script type="text/javascript" src="plugin/durasi/js/mootools-1.2.4-core.js"></script>
	<script type="text/javascript" src="plugin/durasi/js/mootools-1.2.4.4-more.js"></script>
	<script type="text/javascript" src="plugin/durasi/js/calendar-eightysix-v1.1.js"></script>
	
	<script type="text/javascript">
		window.addEvent('domready', function() {
			//Example I
			new CalendarEightysix('exampleI', { 'offsetY': -4 });
			
			//Example II
			new CalendarEightysix('Dari', { 'startMonday': true, 'slideTransition': Fx.Transitions.Back.easeOut, 'format': '%d/%m/%Y', 'draggable': true, 'offsetY': -4 });
			
			new CalendarEightysix('Ke', { 'startMonday': true, 'slideTransition': Fx.Transitions.Back.easeOut, 'format': '%d/%m/%Y', 'draggable': true, 'offsetY': -4 });
			
			//Example III
			new CalendarEightysix('exampleIII', { 'excludedWeekdays': [0, 6], 'toggler': 'exampleIII-picker', 'offsetY': -4 });
			
			//Example IV
			new CalendarEightysix('exampleIV', { 'excludedDates': ['12/25/2012', '12/26/2012'], 'defaultDate': '12/01/2012', 'format': '%d.%m.%Y', 'offsetY': -4 });
			
			//Example V
			new CalendarEightysix('exampleV', { 'theme': 'default red', 'defaultDate': 'next Wednesday', 'minDate': 'tomorrow', 'offsetY': -4 });
			
			//Example VI
			new CalendarEightysix('exampleVI', { 'defaultView': 'decade', 'theme': 'vista', 'disallowUserInput': true, 'offsetY': -4 });
			
			//Example VII
			new CalendarEightysix('exampleVII', { 'defaultView': 'year', 'theme': 'osx-dashboard', 'createHiddenInput': true, 'alignX': 'left', 'alignY': 'bottom', 'offsetX': -4 });
			
			//Example VIII
			new CalendarEightysix('exampleVIII', { 'format': '%A %D %B', 'alignX': 'middle', 'alignY': 'top' });
			
			//Example IX
			var calendarIX = new CalendarEightysix('exampleIXb', { 'linkWithInput': false, 'defaultDate': '1/1/2010', 'minDate': '1/1/2010', 'maxDate': '12/31/2014', 'format': '%d', 
																    'toggler': 'exampleIX-picker', 'offsetY': -4, 'offsetX': 76 });
			calendarIX.addEvent('change', function(date) { 
				$('exampleIXa').set('value', date.get('month') + 1);
				$('exampleIXc').set('value', date.get('year')); 
			});
			var dateIXchange = function() {
				//Get the current date
				var date = calendarIX.getDate();
				//Set the variables from the input and select elements
				date.set('month', $('exampleIXa').get('value') - 1);
				date.set('date', $('exampleIXb').get('value'));
				date.set('year', $('exampleIXc').get('value'));
				//Set the new date
				calendarIX.setDate(date);
			}
			$('exampleIXa').addEvent('change', dateIXchange);
			$('exampleIXb').addEvent('change', dateIXchange);
			$('exampleIXc').addEvent('change', dateIXchange);
			
			//Example X
			MooTools.lang.set('nl-NL', 'Date', {
				months:    ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
				days:      ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
				dateOrder: ['date', 'month', 'year', '/']
			});
			MooTools.lang.set('de-DE', 'Date', {
				months:    ['Januar', 'Februar', 'M&auml;rz', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
				days:      ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
				dateOrder: ['date', 'month', 'year', '/']
			});
			$('exampleXa').addEvent('click', function() { MooTools.lang.setLanguage('nl-NL'); });
			$('exampleXb').addEvent('click', function() { MooTools.lang.setLanguage('de-DE'); });
			
			//Example XI
			var calendarXIa = new CalendarEightysix('exampleXIa', { 'disallowUserInput': true, 'minDate': 'today',  'alignX': 'left', 'alignY': 'bottom', 'offsetX': -4 });
			var calendarXIb = new CalendarEightysix('exampleXIb', { 'disallowUserInput': true, 'minDate': 'tomorrow', 'alignX': 'left', 'alignY': 'bottom', 'offsetX': -4 });
			calendarXIa.addEvent('change', function(date) {
				date = date.clone().increment(); //At least one day higher; so increment with one day
				calendarXIb.options.minDate = date; //Set the minimal date
				if(calendarXIb.getDate().diff(date) >= 1) calendarXIb.setDate(date); //If the current date is lower change it
				else calendarXIb.render(); //Always re-render
			});
			
			//Example XII
			new CalendarEightysix('exampleXII', { 'excludedWeekdays': [0, 6], 'excludedDates': ['01/12/2012', '01/17/2012'], 'minDate': '01/01/2012', 'disallowUserInput': true, 'keyNavigation': true, 'offsetY': -4 });
			
			//Example XIII
			var calendarXIII = new CalendarEightysix('exampleXIII', { 'injectInsideTarget': true, 'alwaysShow': true, 'pickable': false });
			calendarXIII.addEvent('rendermonth', function(e) {
				//The event returns all the date related elements within the calendar which can easily be iterated
				e.elements.each(function(day) {
					day.set('title', day.retrieve('date').format('%A %d %B'));
					if(day.retrieve('date').get('date') == 14) {
						day.setStyles({ 'color': 'firebrick', 'font-weight': 'bold', 'cursor': 'pointer' }).addEvent('click', function() { alert('Fourteen is awesome!'); } );
					}					
				});
			});
			calendarXIII.render(); //Render again because while initializing and doing the first render it did not have the event set yet
		
		});	
	</script>
	
	<title>Calendar Eightysix version 1.1</title>
</head>
<body>

<?=FBR(2);?>

<form name="form1" method="post" action="AppCetakStokBarangShow.php" target="_blank">
	
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0" class="ins">		
		
		<tr>
		  <th align="right" class="tleft"><input id="exampleI" name="dateI" type="hidden" maxlength="10" />Tgl Stok Awal :</th>
		  <td class="tright"><input id="Dari" name="Dari" type="text" maxlength="10" /></td>
		</tr>
        
        <tr>
			<th align="right">Tgl Transaksi Akhir :</th>
		  <td><input id="Ke" name="Ke" type="text" maxlength="10" /></td>
  </tr>
        <tr>
          <th colspan="2" align="center" class="bleftright"><input type="submit" name="button" id="button" value="Laporan Stok Barang" class="tombol"/></th>
        </tr>
		
		
		
</table>

</form>
