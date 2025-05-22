<?php

namespace App\Services\ThirdParty\Todo;

use App\Services\ThirdParty\BaseService;
use GuzzleHttp\Exception\GuzzleException;


class TypicodeAPIService extends BaseService implements TodoAPIInterface
{
    /**
     * @throws GuzzleException
     */
    public function getTodos():array
    {
        $response = $this->httpClient->get(env('TODO_API_URL'));
        $bodyResponse = $response->getBody();
        return json_decode($bodyResponse, true);
    }
}
