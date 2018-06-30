<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function store(Request $request) {
    	// $request->rooms;
    	// $request->planeTickets;

    	// set up validation request

    	// return $request->rooms["single"][0]["people"][0]["name"];

    	// foreach ($request->rooms as $type) {
    	// 	foreach ($type as $room) {
    	// 		foreach ($room as $person) {
    	// 			# code...
    	// 		}
    	// 	}
    	// }

    	// if () {
    		$youOrThey = 'dere';
    	// }


    	// foreach ($request->activities as $activity) {
    	// 	$activity["amountAdults"];
    	// 	$activity["amountChildren"];
    	// }

    	sleep(1);

    	return [true, "Takk for påmeldingen. Vi gleder oss til å møte {$youOrThey}!"];
    }

    // public function confirmation_mail () {

    // }
}
