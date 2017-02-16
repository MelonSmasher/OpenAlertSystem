<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Model\MobilePhone;

class MobilePhoneTransformer extends TransformerAbstract
{

    /**
     * @param MobilePhone $item
     * @return array
     */
    public function transform(MobilePhone $item)
    {
        $user = auth()->user();
        $carrierTrans = new MobileCarrierTransformer();
        $carrier = $carrierTrans->transform($item->mobileCarrier);
        if ($user->can('view-token')) {
            return [
                'id' => (int)$item->id,
                'user_id' => (int)$item->user_id,
                'number' => $item->number,
                'formatted' => formatPhoneNumber($item->number),
                'country_code' => $item->country_code,
                'verified' => (bool)$item->verified,
                'verification_token' => $item->verification_token,
                'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
                'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
                'mobile_carrier' => $carrier
            ];
        } else {
            return [
                'id' => (int)$item->id,
                'user_id' => (int)$item->user_id,
                'number' => $item->number,
                'formatted' => formatPhoneNumber($item->number),
                'country_code' => $item->country_code,
                'verified' => (bool)$item->verified,
                'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
                'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
                'mobile_carrier' => $carrier
            ];
        }
    }
}