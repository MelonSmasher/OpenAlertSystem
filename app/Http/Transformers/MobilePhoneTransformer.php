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

        $carrierTrans = new MobileCarrierTransformer();

        $carrier = $carrierTrans->transform($item->mobileCarrier);

        return [
            'id' => (int)$item->id,
            'account_id' => (int)$item->account_id,
            'number' => $item->number,
            'country_code' => $item->country_code,
            'verified' => (bool)$item->verified,
            'verification_token' => $item->verification_token,
            'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
            'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
            'mobile_carrier' => $carrier
        ];
    }

}