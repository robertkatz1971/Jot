<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Contact;

class BirthdaysController extends Controller
{
    public function index () {

        $contacts = request()->user()->contacts()->Birthdays()->get();
        return Contact::collection($contacts);
    }
}
