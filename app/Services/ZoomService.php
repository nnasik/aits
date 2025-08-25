<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZoomService
{
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = $this->generateAccessToken();
    }

    private function generateAccessToken()
    {
        $response = Http::asForm()->withBasicAuth(
            config('services.zoom.client_id'),
            config('services.zoom.client_secret')
        )->post('https://zoom.us/oauth/token', [
            'grant_type' => 'account_credentials',
            'account_id' => config('services.zoom.account_id'),
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to get Zoom access token: ' . $response->body());
        }

        return $response->json()['access_token'];
    }

    public function createMeeting($topic, $startTime, $duration = 60){
    $response = Http::withToken($this->accessToken)
        ->post('https://api.zoom.us/v2/users/me/meetings', [
            'topic'      => $topic,
            'type'       => 2,
            'start_time' => $startTime,
            'duration'   => $duration,
            'timezone'   => 'Asia/Dubai',
            'settings'   => [
                'join_before_host'   => true,
                'host_video'         => true,
                'participant_video'  => true,
            ],
        ]);

        if ($response->failed()) {
            throw new \Exception('Zoom API error: ' . $response->body());
        }

        return $response->json();
    }

}
