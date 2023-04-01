<?php

namespace App\Http\Controllers\Api;

use App\Actions\Auth\AuthenticationAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\AuthenticationRequest;
use App\Http\Requests\Authentication\OTPRequest;
use App\Models\OTP;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    /**
     * @param AuthenticationRequest $request
     * @param AuthenticationAction $action
     * @return JsonResponse
     */
    public function authentication(AuthenticationRequest $request, AuthenticationAction $action): JsonResponse
    {

        $user = $action->handle($request);

        $userAction = 'get';

        if ($user->wasRecentlyCreated) {
            $userAction = 'created';
            $user->update(['phone_verified_at' => now()]);
        }

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'action' => $userAction,
        ]);
    }


    /**
     * @param OTPRequest $request
     * @return JsonResponse
     */
    public function otp(OTPRequest $request): JsonResponse
    {
        $code = App::environment('production') ? rand(10000, 99999) : 12345;

        $otp = OTP::updateOrCreate(
            ['receiver' => $request->receiver],
            [
                'receiver_channel' => $request->receiver_channel,
                'password' => Hash::make($code),
                'expired_at' => now()->addMinute(),
            ]
        );

        return response()->json([
            'request_id' => $otp->request_id,
            'channel' => (int)$request->receiver_channel,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function refresh(Request $request): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json(['token' => auth()->user()->createToken($request->device_name)->plainTextToken]);
    }
}
