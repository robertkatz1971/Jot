<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BirthdayTest extends TestCase
{
    use RefreshDatabase;

    public function testContactsWithBirthdaysInCurrentMonth()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        
        $birthdayContact = Contact::factory()->create( [
            'user_id' => $user->id,
            'birthday' => now()->subYear(),
        ]);

        $notBirthdayContact = Contact::factory()->create( [
            'user_id' => $user->id,
            'birthday' => now()->subMonth(),
        ]);

        
        $this->get('/api/birthdays?api_token=' . $user->api_token )
            ->assertJsonCount(1)
            ->assertJson( [
                            'data' => [
                                [
                                    'data' => [
                                        'contact_id' => $birthdayContact->id
                                    ]
                                ]
                            ]
                        ]);

    }
}
