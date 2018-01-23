<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function store(Request $request) {
    	// $request->rooms;
    	// $request->planeTickets;

    	// set up validation request

    	$youOrThey = 'dere';

    	return [true, "Takk for påmeldingen! Vi gleder oss til å møte {$youOrThey}."];
    }
}
