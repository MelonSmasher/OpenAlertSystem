<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Transformers\EmailTransformer;
use App\Model\Email;
use Illuminate\Http\Request;
use Krucas\Settings\Facades\Settings;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Support\Facades\Validator;

class ApiEmailController extends BaseAPIController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $user = $this->auth->user();
        $emails = $user->emails()->paginate($this->resultLimit);
        return $this->response->paginator($emails, new EmailTransformer);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function get(Request $request, $id)
    {
        $user = $this->auth->user();
        $email = $user->emails()->where('id', $id)->firstOrFail();
        return $this->response->item($email, new EmailTransformer);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function delete(Request $request, $id)
    {
        $user = $this->auth->user();
        $deleted = $user->emails()->where('id', $id)->firstOrFail()->delete();
        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure('email');
    }

    public function updateOrNew(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'email|required'
        ]);

        if ($validator->fails())
            throw new StoreResourceFailedException('Could not store email.', $validator->errors());

        $excluded_domains = [];//Settings::get('excluded-email-domains', []);
        $email_domain = explode('@', $data['email'])[1];
        if (!empty($excluded_domains)) {
            if (in_array($email_domain, $excluded_domains))
                throw new StoreResourceFailedException('Could not store email.', ['The email address entered is a member of a forbidden domain: ' . $email_domain]);
        }

        $user = $this->auth->user();

        $item = Email::updateOrCreate(['address' => $data['email']], [
            'user_id' => $user->id,
            'verified' => false,
        ]);

        // If the email is not verified
        if (!$item->verified) {
            //@todo send the verification email
        }

        $trans = new EmailTransformer();
        $item = $trans->transform($item);
        return $this->response->created(route('api.emails.show', ['id' => $item['id']]), ['data' => $item]); //@todo remove verification code from response
    }
}
