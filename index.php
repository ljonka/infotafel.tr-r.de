<!DOCTYPE html>
<html>
<head>
    <title>Minimum Setup</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/bootstrap-calendar/css/calendar.min.css">

	<style>
	.evententry{
		height: 200px;
		overflow: hidden;
		margin: 5px;
		padding: 0;
		max-width: 400px;
	}
	#logo h1{float: right;}
	</style>
</head>
<body>

    <div id="logo" class="page-header">
	<img src="https://www.transition-regensburg.de/wp-content/uploads/2015/05/Transition_Logo_Breit.png" width="400px"/>
	<h1>Veranstaltungen</h1>
    </div>
	<div class="row">
		<div class="col-xs-5 col-md-3 evententry panel panel-default" style="display:none;" id="entrytemplate">
			<div class="caption panel-body">
				<h4 class="title"></h3>
				<h5 class="start"></h4>
				<h5 class="ort"></h5>
				<p class="description"></p>
			</div>
		</div>
	</div>

    <!--<div id="calendar"></div>-->

    <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="bower_components/underscore/underscore-min.js"></script>
    <script type="text/javascript" src="bower_components/bootstrap-calendar/js/calendar.js"></script>
    <script type="text/javascript" src="bower_components/date_format/date.format.js"></script>

    <script type="text/javascript">
	/*
        var calendar = $("#calendar").calendar(
            {
                tmpl_path: "bower_components/bootstrap-calendar/tmpls/",
                events_source: 'events.php',
		view: 'month',
		time_start: '11:00',
		time_end: '21:00',
		time_split: '60'
            });
	*/

	var d1 = new Date();
	d1.setDate(d1.getDate()-1);
	var d2 = new Date();
	d2.setDate(d2.getDate()+7);

	$.getJSON("events.php", {from: d1.valueOf(), to: d2.valueOf()}, function(data, status){
		var template = $("#entrytemplate").first();
		data.result.forEach(function(event){
			var entry = template.clone();
			entry.find(".title").html(event.title);
			entry.find(".start").append((new Date(parseInt(event.start))).format("M jS, Y - H:i"));
                        entry.find(".ort").append(event.location);
			entry.find(".description").append(event.description);
			//entry.find("p").html(event.description);
			entry.show();
			template.parent().append(entry);
		});
	})
    </script>
</body>
</html>

