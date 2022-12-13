<?php
namespace App\Services;

class OneSignalService
{
    public $Url = "https://onesignal.com/api/v1/";
    
    /**
     * sendNotificationToAll
     * Function used to send push notifiction to all
     * @param  mixed $appId
     * @param  mixed $apiKey
     * @param  mixed $contents
     * @return Boolean true or false
     */
    public function sendNotificationToAll($appId, $apiKey, $contents = null)
    {
        try {
            if (!empty($appId) && !empty($apiKey) && !empty($contents)) {
                $client = new \GuzzleHttp\Client();
                $postData = ["app_id" => $appId, "included_segments" => ["All"], "contents" => ["en" => $contents]];
                $response = $client->request('POST', $this->Url . 'notifications', [
                    'body' => json_encode($postData),
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $apiKey,
                        'Content-Type' => 'application/json',
                    ],
                ]);
                if ($response->getStatusCode() == 200) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

}
