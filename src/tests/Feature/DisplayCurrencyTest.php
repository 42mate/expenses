<?php

namespace Tests\Feature;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DisplayCurrencyTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_persist_display_currency_from_the_selector(): void
    {
        $currency = Currency::where('code', '!=', 'DEF')->first();
        if (!$currency) {
            $this->markTestSkipped('No currencies seeded.');
        }

        $user = User::create([
            'name' => 'Currency Tester',
            'email' => 'currency-' . uniqid() . '@example.com',
            'password' => bcrypt('secret'),
            'default_currency_id' => 1,
        ]);

        $this->actingAs($user);

        $response = $this->post('/display-currency', [
            'display_currency_id' => $currency->id,
        ]);

        $response->assertRedirect();
        $this->assertEquals($currency->id, $user->fresh()->display_currency_id);
    }

    public function test_display_currency_requires_a_valid_currency(): void
    {
        $user = User::create([
            'name' => 'Currency Tester',
            'email' => 'currency-' . uniqid() . '@example.com',
            'password' => bcrypt('secret'),
            'default_currency_id' => 1,
        ]);

        $this->actingAs($user);

        $response = $this->post('/display-currency', [
            'display_currency_id' => 999999,
        ]);

        $response->assertSessionHasErrors('display_currency_id');
    }
}
