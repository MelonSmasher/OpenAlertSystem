<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Model\Country;

class CountryTransformer extends TransformerAbstract
{

    /**
     * @param Country $item
     * @return array
     */
    public function transform(Country $item)
    {
        return [
            'id' => (int)$item->id,
            'label' => $item->label,
            'code' => $item->code,
            'abbreviation' => $item->abbreviation,
            'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
            'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
        ];
    }

}