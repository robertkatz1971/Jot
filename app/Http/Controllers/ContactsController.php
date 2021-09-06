<?php

namespace App\Http\Controllers;

use Nette\Utils\Json;
use App\Models\Contact;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Contact as ContactResource;

class ContactsController extends Controller
{

    public function index() {

        $this->authorize('viewAny', Contact::class);

        return ContactResource::collection(request()->user()->contacts()->orderby('name')->get());
    
    }

    public function store() {

        $this->authorize('create', Contact::class);

        $contact = request()->user()->contacts()->create($this->validateData());

        return (new ContactResource($contact))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);


    }

    public function show(Contact $contact) {
       
        $this->authorize('update', $contact);
         
        return new ContactResource(Contact::findOrFail($contact->id));
    }

    public function update(Contact $contact) {

       $this->authorize('update', $contact);
       
       $contact->update($this->validateData());

       return (new ContactResource($contact))
             ->response()
             ->setStatusCode(Response::HTTP_OK);
    
    }

    public function destroy (Contact $contact) {

        $this->authorize('delete', $contact);

        $contact->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    private function validateData () {

        return request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'company' => 'required',
            'birthday' => 'required' 
        ]);
    }

}
