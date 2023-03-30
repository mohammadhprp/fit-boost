<?php

namespace App\Actions\Auth;

use App\Constants\Strings\AppErrors;
use App\Http\Requests\Authentication\AuthenticationRequest;
use App\Models\OTP;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationAction
{
    /**
     * @param AuthenticationRequest $request
     * @return mixed
     */
    public function handle(AuthenticationRequest $request): mixed
    {
        $otp = Otp::select(
            'receiver', 'receiver_channel',
            'password', 'request_id', 'expired_at'
        )->where('request_id', $request->request_id)
            ->first();

        if (!$otp) {
            abort(403, AppErrors::Forbidden);
        }

        if ($otp->expired_at->isPast()) {
            abort(401, AppErrors::OTPExpired);
        }

        if ($request->receiver != $otp->receiver ||
            !Hash::check($request->password, $otp->password)) {
            abort(401, AppErrors::Unauthorized);
        }

        $receiver = $otp->receiver_channel == OTP::SMS_CHANNEL ? 'phone' : 'email';

        $user = User::updateOrCreate(
            [$receiver => $request->receiver],
            ['password' => Hash::make($request->password)]
        );

        return $user;
    }
}
