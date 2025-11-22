<?php 

namespace App\Services;

use Selcom\ApigwClient\Client;

class SelcomService
{
    protected Client $client;

    public function __construct()
    {
        $baseUrl = env('SELCOM_BASE_URL');
        $apiKey = env('SELCOM_API_KEY');
        $apiSecret = env('SELCOM_API_SECRET');

        if (!$baseUrl || !$apiKey || !$apiSecret) {
            throw new \Exception("Selcom API credentials are not properly set in the .env file.");
        }

        // Initialize the official Selcom Client
        $this->client = new Client($baseUrl, $apiKey, $apiSecret);
    }

    /**
     * Get the initialized Selcom Client instance.
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Convenience method for a POST request (e.g., Checkout).
     * @param string $path The API path (e.g., 'checkout/get-express-url').
     * @param array $data The request data payload.
     * @return array
     */
    public function post($path, array $data): array
    {
        $response = $this->client->postFunc($path, $data);
        return json_decode($response, true);
    }

    // You can add methods for getFunc and deleteFunc here as well
}