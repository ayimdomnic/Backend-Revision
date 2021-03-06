<?php

namespace App\Services\Mailamericas\Tracking\PostalStructure;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Exception;

class TownsService
{
    private $apiEndpoint;
    private $towns = [];

    /**
     * TownsService constructor.
     */
    public function __construct()
    {
        $this->apiEndpoint = env('TRACKING_API_URL');
    }

    /**
     * @param array $filters
     * @return $this
     * @throws Exception
     */
    public function search($filters = [])
    {
        try {
            // Call API
            $client = new Client(['verify' => !app()->isLocal(),]);
            $response = $client->get(env('TRACKING_API_URL') . '/v1/postal-structure/admin-level-2', [
                'query' => $filters
            ]);

            // Log response
            $response = $response->getBody()->getContents();

            $response = json_decode($response);

            $this->towns = $response->data;
        } catch (ClientException $e) {
            throw new Exception($e->getMessage());
        }

        return $this;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->towns;
    }
}
