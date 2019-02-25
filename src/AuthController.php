<?php

namespace Metrogistics\AzureSocialite;

use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{
    public function redirectToOauthProvider()
    {
        return Socialite::driver('azure-oauth')->redirect();
    }

    public function handleOauthResponse()
    {
        try {
            $user = Socialite::driver('azure-oauth')->user();
        } catch (InvalidStateException $e) {
            $user = Socialite::driver('azure-oauth')->stateless()->user();
        }

        $authUser = $this->findOrCreateUser($user);

        auth()->login($authUser, true);

        // session([
        //     'azure_user' => $user
        // ]);

        return redirect(
            config('azure-oath.redirect_on_login')
        );
    }

    protected function findOrCreateUser($user)
    {
        $user_class = config('azure-oath.user_class');
        $authUser = $user_class::where(config('azure-oath.user_id_field'), $user->id)->first();

        if ($authUser) {
            return $authUser;
        }

        $UserFactory = new UserFactory();

        return $UserFactory->convertAzureUser($user);
    }
}
