<?php
$cache = MemcachedConnect::getInstance()->getConnect();
$btcPrice = $cache->get('getBictoinPrice');
if (empty($btcPrice)) {
    $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
    $parameters = [
        'start' => '1',
        'limit' => '5000',
        'convert'=> 'USD',
    ];

    $headers = [
        'Accepts: application/json',
        'X-CMC_PRO_API_KEY: 366f2c8c-9dec-42d9-82fa-5f8641764978'
    ];
    $qs = http_build_query($parameters);
    $request = "{$url}?{$qs}"; // create the request URL


    $curl = curl_init(); // Get cURL resource
    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => $request,            // set the request URL
        CURLOPT_HTTPHEADER => $headers,     // set the headers
        CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
    ));

    $response = curl_exec($curl); // Send the request, save the response
    $btcPrice = json_decode($response); // print json decoded response
    curl_close($curl); // Close request
    $cache->set('getBictoinPrice', $btcPrice, false, 7200);
    curl_close($curl);
}

echo "$" . number_format((int)$btcPrice->data[0]->quote->USD->price,0,"",  " ");