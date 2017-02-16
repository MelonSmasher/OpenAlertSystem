<?php namespace App\Providers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 2/15/17
 * Time: 7:12 PM
 */

use Illuminate\Http\Request;
use App\Model\Role;
use Laravel\Socialite\Contracts\Provider;
use App\Model\SocialAccount;
use App\Model\User;
use Illuminate\Support\Facades\Validator;

class SocialAccountServiceProvider
{

    /**
     * @param Request $request
     * @param Provider $provider
     * @return static
     */
    public function createOrGetUser(Request $request, Provider $provider)
    {
        // Get the user object from the upstream provider
        $providerUser = $provider->user();
        // Get the provider name
        $providerName = class_basename($provider);
        // get the social account associated with that provider and their provider ID
        $account = SocialAccount::whereProvider($providerName)->whereProviderUserId($providerUser->getId())->first();
        // Define some useful variables here
        $email = $providerUser->getEmail();
        $name = $providerUser->getName();
        $username = explode('@', $email)[0];
        // If we've gotten that user then retrieve their local account, otherwise we start the account creation process
        if ($account) {
            $user = $account->user;
        } else {
            // Create a new social account object
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $providerName
            ]);
            // Do we have the user in the DB with that email? Maybe they used a different social account provider before?
            // If we do retrieve that account
            $user = User::whereEmail($providerUser->getEmail())->first();
            // If no user with that email exists
            if (!$user) {
                // Validate their email domain...
                $validator = Validator::make(['email' => strtolower($providerUser->getEmail())], [
                    'email' => 'regex:/@.*' . str_replace('.', '\.', strtolower(env('VALID_AUTH_DOMAIN', '*'))) . '$/',
                ]);
                // Did the validator fail?
                if ($validator->fails()) {
                    // If so flash a mesage on the next page
                    $request->session()->flash('alert-danger', 'The account you\'ve selected is not a member of the ' . env('VALID_AUTH_DOMAIN') . ' domain.');
                    // Pass them back to the login page
                    return redirect('/login');
                }
                // If we passed validation, we need to create a new user object
                $user = User::create([
                    'email' => $email,
                    'name' => $name,
                    'username' => $username
                ]);
                // If this is the first user to log in
                if (User::all()->first()->id == $user->id) {
                    // Then we need to make them an admin
                    $user->attachRole(Role::where('name', 'admin')->get()->first());
                }
            }
            // Associate the user account with the social account for the next login
            $account->user()->associate($user);
            // Save the social account
            $account->save();
        }
        /**
         * The following code runs on each login, even if the account is existing
         */
        // Did we authenticate with google?
        if ($providerName == 'GoogleProvider') {
            // Do we have an avatar url from the provider?
            if (!empty($providerUser->avatar)) {
                // Is the avatar url the same as the one already attached to the user?
                if ($user->avatar_url != $providerUser->avatar) {
                    // Parse the url and strip parameters
                    $url = parse_url($providerUser->avatar);
                    // If not, then attach the url to the user
                    $user->avatar_url = $url['scheme'] . '://' . $url['host'] . $url['path'];
                    $user->save();
                }
            }
        }
        // If the user has no roles, make sure they have the application user role.
        if (0 >= count($user->roles)) {
            // Give the user a default role of application user.
            $user->attachRole(Role::where('name', 'application-user')->get()->first());
        }
        // If the user has been updated then save them
        if ($user->isDirty()) $user->save();
        // Return the user object
        return $user;
    }
}