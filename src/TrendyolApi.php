<?php

class TrendyolApi
{
    const DEFAULT_BASE_URL = 'https://apigw.trendyol.com/integration/';

    /** @var string */
    private $supplierId;

    /** @var string */
    private $apiKey;

    /** @var string */
    private $apiSecret;

    /** @var string */
    private $baseUrl;

    public function __construct($supplierId, $apiKey, $apiSecret, $baseUrl = self::DEFAULT_BASE_URL)
    {
        $this->supplierId = (string) $supplierId;
        $this->apiKey = (string) $apiKey;
        $this->apiSecret = (string) $apiSecret;
        $this->baseUrl = rtrim((string) $baseUrl, '/') . '/';
    }

    public function getOrders($query = [])
    {
        $queryString = http_build_query($query);
        $endpoint = sprintf('order/sellers/%s/orders', $this->supplierId);
        if (!empty($queryString)) {
            $endpoint .= '?' . $queryString;
        }

        return $this->send('GET', $endpoint);
    }

    private function send($method, $endpoint)
    {
        if (!extension_loaded('curl')) {
            return [
                'success' => false,
                'message' => 'cURL extension is not enabled.',
                'data' => null,
            ];
        }

        $url = $this->baseUrl . ltrim($endpoint, '/');
        $authorization = base64_encode($this->apiKey . ':' . $this->apiSecret);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $authorization,
            'User-Agent: ' . $this->supplierId . ' - TochatWhatsAppIntegration',
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        $body = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errorMessage = curl_error($ch);
        curl_close($ch);

        if (!empty($errorMessage)) {
            return [
                'success' => false,
                'message' => $errorMessage,
                'data' => null,
            ];
        }

        $decoded = json_decode((string) $body, true);
        if ($httpCode >= 200 && $httpCode < 300) {
            return [
                'success' => true,
                'message' => 'ok',
                'data' => is_array($decoded) ? $decoded : [],
            ];
        }

        return [
            'success' => false,
            'message' => is_array($decoded) && isset($decoded['message']) ? $decoded['message'] : 'Trendyol API request failed.',
            'data' => is_array($decoded) ? $decoded : [],
        ];
    }
}
