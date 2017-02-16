<?php

namespace App\Http\Controllers\API\V1;

use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class BaseAPIController extends Controller
{
    use Helpers;

    /**
     * @var int
     */
    protected $resultLimit = 50;


    /**
     * @var int
     */
    protected $maxResultLimit = 1500;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroySuccessResponse()
    {
        return $this->response->noContent()->setStatusCode(204);
    }

    /**
     * @param string $resource
     */
    public function destroyFailure($resource = 'resource')
    {
        throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not delete ' . $resource . '.');
    }
}
