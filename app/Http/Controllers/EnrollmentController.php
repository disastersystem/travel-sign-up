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

        $youOrThey = 'dere';

    	// foreach ($request->rooms as $room_type_array) {

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
