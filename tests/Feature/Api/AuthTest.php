<?php

namespace Tests\Feature\Api;


use App\Models\OTP;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_otp()
    {
        $phone = '0912345679';
        $response = $this->postJson(
            "/{$this->apiRoute}/auth/otp",
            [
                'receiver' => $phone,
                'receiver_channel' => OTP::SMS_CHANNEL,
            ],
        );

        $response->assertStatus(200);


        $this->assertDatabaseHas(OTP::class, [
            'receiver' => $phone,
        ]);

    }

    public function test_user_authentication_with_phone()
    {
        $code = rand(10000, 99999);
        $phone = '0912345679';

        $otp = OTP::create([
            'receiver' => $phone,
            'receiver_channel' => OTP::SMS_CHANNEL,
            'password' => Hash::make($code),
            'expired_at' => now()->addMinute(),
        ]);


        $response = $this->postJson(
            "/{$this->apiRoute}/auth/user",
            [
                'receiver' => $phone,
                'request_id' => $otp->request_id,
                'password' => $code,
                'device_name' => 'Test Device'
            ]
        );

        $response->assertStatus(200);
    }

    public function test_user_authentication_with_email()
    {
        $code = rand(10000, 99999);
        $email = 'example@domin.com';

        $otp = OTP::create([
            'receiver' => $email,
            'receiver_channel' => OTP::EMAIL_CHANNEL,
            'password' => Hash::make($code),
            'expired_at' => now()->addMinute(),
        ]);


        $response = $this->postJson(
            "/{$this->apiRoute}/auth/user",
            [
                'receiver' => $email,
                'request_id' => $otp->request_id,
                'password' => $code,
                'device_name' => 'Test Device'
            ]
        );

        $response->assertStatus(200);
    }

    public function test_user_unauthorized()
    {
        $code = rand(10000, 99999);
        $phone = '0912345679';

        $otp = OTP::create([
            'receiver' => $phone,
            'receiver_channel' => OTP::SMS_CHANNEL,
            'password' => Hash::make($code),
            'expired_at' => now()->addMinute(),
        ]);


        $response = $this->postJson(
            "/{$this->apiRoute}/auth/user",
            [
                'receiver' => $phone,
                'request_id' => $otp->request_id,
                'password' => 'Wrong Password',
                'device_name' => 'Test Device'
            ]
        );

        $response->assertStatus(401);
    }

    public function test_user_unauthorized_with_expired_otp()
    {
        $code = rand(10000, 99999);
        $phone = '0912345679';

        $otp = OTP::create([
            'receiver' => $phone,
            'receiver_channel' => OTP::SMS_CHANNEL,
            'password' => Hash::make($code),
            'expired_at' => now()->subMinute(),
        ]);


        $response = $this->postJson(
            "/{$this->apiRoute}/auth/user",
            [
                'receiver' => $phone,
                'request_id' => $otp->request_id,
                'password' => $code,
                'device_name' => 'Test Device'
            ]
        );

        $response->assertStatus(401);
    }


    public function test_user_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(
            "/{$this->apiRoute}/auth/logout",
        );

        $response->assertStatus(200);
    }

}
