<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Resources\Contact as ContactResource;

class SearchController extends Controller
{
    public function index () {

        $data = request()->validate([
            'searchTerm' => 'required',
        ]);
        
        $contacts = Contact::search($data['searchTerm'])
        ->where('user_id', request()->user()->id)
        ->orderBy('name')
        ->get();

        return ContactResource::collection($contacts);
    }
}
