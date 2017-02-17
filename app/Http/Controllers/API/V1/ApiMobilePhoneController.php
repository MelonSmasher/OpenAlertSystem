<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Model\MobilePhone;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Http\Transformers\MobilePhoneTransformer;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\SMS\Facades\SMS;

class ApiMobilePhoneController extends BaseAPIController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $user = $this->auth->user();
        $emails = $user->mobilePhones()->paginate($this->resultLimit);
        return $this->response->paginator($emails, new MobilePhoneTransformer);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function get(Request $request, $id)
    {
        $user = $this->auth->user();
        $email = $user->mobilePhones()->where('id', $id)->firstOrFail();
        return $this->response->item($email, new MobilePhoneTransformer);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function delete(Request $request, $id)
    {
        $user = $this->auth->user();

        $deleted = $user->mobilePhones()->where('id', $id)->firstOrFail()->delete();
        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure('mobile phone');
    }

    public function updateOrNew(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'carrier' => 'integer|min:1|exists:mobile_carriers,id,deleted_at,NULL',
            'number' => 'string|required|size:10'
        ]);

        if ($validator->fails())
            throw new StoreResourceFailedException('Could not store mobile phone.', $validator->errors());

        $user = $this->auth->user();

        if ($toRestore = MobilePhone::onlyTrashed()->where('number', $data['number'])->first()) {
            $toRestore->restore();
            $toRestore->verified = false;
            $toRestore->verification_token = null;
            $toRestore->save();
        }

        $item = MobilePhone::updateOrCreate(['number' => $data['number']], [
            'user_id' => $user->id,
            'mobile_carrier_id' => $data['carrier'],
            'verified' => false,
        ]);

        // If the email is not verified
        if (!$item->verified) {
            $token = generateVerificationToken();
            $item->verification_token = $token;
            $item->save();
            $message = "Welcome to ".env('APP_NAME', 'Open Alert')."!\nYour code is: " . $token . "\nTo verify this number visit:\n" . url('/verify/' . $token);
            SMS::queue($message, [], function ($sms) use ($item) {
                if (env('SMS_DRIVER', 'email') === 'email') {
                    $sms->to('+1' . $item->number, $item->carrier->code);
                } else {
                    $sms->to('+1' . $item->number);
                }
            });
        }

        $trans = new MobilePhoneTransformer();
        $item = $trans->transform($item);
        return $this->response->created(route('api.emails.show', ['id' => $item['id']]), ['data' => $item]); //@todo remove verification code from response
    }
}
