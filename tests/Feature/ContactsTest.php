<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use Database\Factories\ContactFactory;
use function PHPUnit\Framework\assertJson;
use function PHPUnit\Framework\assertTrue;

use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

    }
    private function data() {
        return [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'company' => 'ABC Company',
            'birthday' => '6/20/1966',
            'api_token' => $this->user->api_token,
            'user_id' => $this->user->id
        ];
    }

    public function testUnauthenticateUserIsRedirectedToLogin() {

        $response = $this->post('/api/contacts', 
            array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Contact::all());

    }

    public function testContactCanBeAddedbyAuthenicatedUser()
    {
       $response = $this->post('/api/contacts', $this->data());

        $contact = Contact::first();

       $this->assertEquals('Test Name', $contact->name);
       $this->assertEquals('test@email.com', $contact->email);
       $this->assertEquals('ABC Company', $contact->company);

       $response->assertStatus(Response::HTTP_CREATED);
       $response->assertJson( [
            'data' => [
                'contact_id' => $contact->id
            ],
            'links' => [
                'self' => $contact->path()
            ]
       ]);
    }

    public function testFieldsAreRequired() 
    {
        collect(['name', 'email', 'company'])
            ->each(function($field) {
                $response = $this->post('/api/contacts', 
                array_merge($this->data(), [$field => '']));

                $contact = Contact::first();

                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Contact::all());
            });
    }

    public function testEmailMustBeValidFormat() {

        $response = $this->post('/api/contacts', 
                array_merge($this->data(), ['email' => 'NOT AN EMAIL']));
        
        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Contact::all());
    }

    public function testContactCanBeRetrieved() {

        $contact = Contact::factory()->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/contacts/' . $contact->id . '?api_token=' . $this->user->api_token );

        $response->assertOK();

        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'birthday' => $contact->birthday->format('m/d/Y'),
                'email' => $contact->email,
                'company' => $contact->company,
                'last_updated' => $contact->updated_at->diffForHumans()
            ]
        ]);
    }

    public function testContactCanBeRetrievedForAuthenticatedUser() {

        $contact = Contact::factory()->create();

        $anotherUser = User::factory()->create();

        $response = $this->get('/api/contacts/' . $contact->id . '?api_token=' . $anotherUser->api_token );

        $response->assertForbidden();
    }

    public function testContactCanBePatched() {

        $contact = Contact::factory()->create(['user_id' => $this->user->id]);

        $response = $this->patch('/api/contacts/' . $contact->id, $this->data());

        $contact = $contact->fresh();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('ABC Company', $contact->company);

        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id
            ],
            'links' => [
                'self' => $contact->path()
            ]
        ]);

        $response->assertOK();
    }

    public function testContactCanBePatchedOnlyByUserThatOwnsContact() {

        $contact = Contact::factory()->create();

        $anotherUser = User::factory()->create();

        $response = $this->patch('/api/contacts/' . $contact->id, 
            array_merge($this->data(), ['api_token' => $anotherUser->api_token]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);

    }

    public function testContactCanBeDeleted() {

        $contact = Contact::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete('/api/contacts/' . $contact->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Contact::all());

        $response->assertStatus(Response::HTTP_NO_CONTENT);

    }

    public function testContactCanBeDeletedOnlyByUserWhoOwnsContact() {

        $contact = Contact::factory()->create();
        $anotherUser = User::factory()->create();

        $response = $this->delete('/api/contacts/' . $contact->id, ['api_token' => $anotherUser->api_token]);

        $response->assertForbidden();

    }

    public function testListOfContactFetchedForAuthenticatedUser() {

        $users = User::factory()->count(2)->create();

        $contact = Contact::factory()->create(['user_id' => $users[0]->id]);
        $contact2 = Contact::factory()->create(['user_id' => $users[1]->id]);

        $response = $this->get('/api/contacts?api_token=' . $users[0]->api_token);

        $response->assertJsonCount(1)
            ->assertOk();
    
        
        $response->assertJson([
            'data' => [
                    [
                        'data' => [
                            'contact_id' => $contact->id,
                            'name' => $contact->name,
                            'birthday' => $contact->birthday->format('m/d/Y'),
                            'email' => $contact->email,
                            'company' => $contact->company,
                            'last_updated' => $contact->updated_at->diffForHumans()
                        ],
                        'links' => [
                            'self' => $contact->path()
                        ]
                    ]
            ]
        ]);

        $this->assertCount(2, Contact::all());
    }
}
