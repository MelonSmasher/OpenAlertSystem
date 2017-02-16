<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');
/**
 *
 * The API raye limits IP addresses at 500 requests per minute
 *
 */
$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 500, 'expires' => 1], function ($api) {
    /**
     * The route group below is used to jam the version number into the URL.
     * This is not the Dingo way of doing things.
     * Eventually we will need to migrate to an accept header
     * @todo
     * https://stackoverflow.com/questions/38664222/dingo-api-how-to-add-version-number-in-url/
     * https://github.com/dingo/api/issues/1221
     */
    $api->group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\API\V1'], function ($api) {

        $api->group(['prefix' => 'auth'], function ($api) {
            $api->post('/', ['uses' => 'ApiAuthenticationController@authenticate', 'as' => 'api.authenticate']);
            $api->get('validate', ['uses' => 'ApiAuthenticationController@validateAuth', 'as' => 'api.validate_auth', 'middleware' => 'api.validate.session']);
        });

        $api->get('verify/{token}', ['uses' => 'TokenVerificationController@verify', 'as' => 'api.send.verify.token']);
        $api->post('verify', ['uses' => 'TokenVerificationController@verify', 'as' => 'api.post.verify.token']);

        $api->group(['middleware' => 'api.auth'], function ($api) {
            $api->group(['prefix' => 'user'], function ($api) {
                $api->group(['prefix' => 'email'], function ($api) {
                    $api->get('/', ['uses' => 'ApiEmailController@index', 'as' => 'api.emails.index']);
                    $api->post('/', ['uses' => 'ApiEmailController@updateOrNew', 'as' => 'api.emails.store']);
                    $api->get('{id}', ['uses' => 'ApiEmailController@get', 'as' => 'api.emails.show']);
                    $api->delete('{id}', ['uses' => 'ApiEmailController@delete', 'as' => 'api.emails.destroy']);
                });
                $api->group(['prefix' => 'phone'], function ($api) {
                    $api->get('/', ['uses' => 'ApiMobilePhoneController@index', 'as' => 'api.phones.index']);
                    $api->post('/', ['uses' => 'ApiMobilePhoneController@updateOrNew', 'as' => 'api.phones.store']);
                    $api->get('{id}', ['uses' => 'ApiMobilePhoneController@get', 'as' => 'api.phones.show']);
                    $api->delete('{id}', ['uses' => 'ApiMobilePhoneController@delete', 'as' => 'api.phones.destroy']);
                });
            });
            $api->group(['prefix' => 'resources'], function ($api) {
                $api->group(['prefix' => 'carriers'], function ($api) {
                    $api->get('/', ['uses' => 'ApiMobileCarrierController@index', 'as' => 'api.carries.index']);
                    $api->get('{id}', ['uses' => 'ApiMobileCarrierController@get', 'as' => 'api.carriers.show']);
                });
            });
        });
    });
});

