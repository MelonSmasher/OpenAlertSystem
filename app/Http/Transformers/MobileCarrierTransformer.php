<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Model\MobileCarrier;

class MobileCarrierTransformer extends TransformerAbstract
{

    /**
     * @param MobileCarrier $item
     * @return array
     */
    public function transform(MobileCarrier $item)
    {
        $country_trans = new CountryTransformer();
        $country = $country_trans->transform($item->country);

        return [
            'id' => (int)$item->id,
            'label' => $item->label,
            'code' => $item->code,
            'country' => $country,
            'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
            'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
        ];
    }

}