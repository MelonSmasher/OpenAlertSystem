<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/26/16
 * Time: 2:42 PM
 */

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Model\Email;

class EmailTransformer extends TransformerAbstract
{
    /**
     * @param Email $item
     * @return array
     */
    public function transform(Email $item)
    {
        $user = auth()->user();

        if ($user->can('view-token')) {
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'address' => $item->address,
                'verified' => (bool)$item->verified,
                'verification_token' => $item->verification_token,
                'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
                'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
            ];
        } else {
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'address' => $item->address,
                'verified' => (bool)$item->verified,
                'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
                'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
            ];
        }
    }

}