<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
//Import events from ics
$url = "https://www.transition-regensburg.de/?plugin=all-in-one-event-calendar&controller=ai1ec_exporter_controller&action=export_events&no_html=true";


/* This example demonstrates how the Ics-Parser should be used.
 *
 * PHP Version 5
 *
 * @category Example
 * @package  Ics-parser
 * @author   Martin Thoma <info@martin-thoma.de>
 * @license  http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version  SVN: <svn_id>
 * @link     http://code.google.com/p/ics-parser/
 * @example  $ical = new ical('MyCal.ics');
 *           print_r( $ical->get_event_array() );
 */
require 'ics-parser/class.iCalReader.php';

$ical   = new ICal($url);
//range params: rangeStart, rangeEnd
$intTimeFrom = new DateTime('@' . round((int)$_GET["from"] / 1000, 0));
$intTimeTo = new DateTime('@' . round((int)$_GET["to"] / 1000, 0));
if($intTimeFrom > 0){
	$events = $ical->eventsFromRange($intTimeFrom->format("Y-m-d"), $intTimeTo->format("Y-m-d"));
}else{
	$events = $ical->events();
}
$arrEvents = [];
foreach ($events as $event){
	//print_r($event); //break;
	preg_match("/^ai1ec-([\d]+)/", $event["UID"], $arrUid);
	$arrEvent = [
		"id" => $arrUid[1],
		"title" => $event["SUMMARY"],
		"description" => str_replace("\\n", "<br />", $event["DESCRIPTION"]),
		"url" => $event["URL"],
		"class" => "event-important",
		"location" => str_replace("\\", "", $event["LOCATION"]),
		"start" => $ical->iCalDateToUnixTimestamp($event["DTSTART"]) . '000',
		"end" => $ical->iCalDateToUnixTimestamp($event["DTEND"]) . '000'
	];
	$arrEvents[] = $arrEvent;
}
$arrResult = [
	"success" => 1,
	"from" => $intTimeFrom,
	"to" => $intTimeTo,
	"result" => $arrEvents
];
echo json_encode($arrResult);
