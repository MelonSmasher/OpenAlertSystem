<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Transformers\MobileCarrierTransformer;
use App\Model\MobileCarrier;
use Illuminate\Http\Request;

class ApiMobileCarrierController extends BaseAPIController
{

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        return $this->response->paginator(MobileCarrier::paginate($this->resultLimit), new MobileCarrierTransformer);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function get(Request $request, $id)
    {
        $item = MobileCarrier::findOrFail($id);
        return $this->response->item($item, new MobileCarrierTransformer);
    }

}
