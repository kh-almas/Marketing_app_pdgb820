<?php

namespace App\Actions\SendGrid;

use App\Models\SenderVerification;
use Illuminate\Support\Facades\Http;

class Sender_Verification
{
    private $apiKey;
    private $baseURL;
    public function __construct()
    {
        $this->apiKey = config('services.sendgrid.apiKey');
        $this->baseURL = 'https://api.sendgrid.com';
    }

    public function createSenderVerification($info)
    {
        $url = $this->baseURL.'/v3/verified_senders';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
        ])->post($url, [
            "nickname" => $info->nickname,
            "from_email" => $info->from_email,
            "from_name" => $info->from_name,
            "reply_to" => $info->reply_to,
            "reply_to_name" => $info->reply_to_name,
            "address" => $info->address,
            "address2" => $info->address2,
            "state" => $info->state,
            "city" => $info->city,
            "country" => $info->country,
            "zip" => $info->zip,
        ]);

        $success = $response->successful();

        if ($success == 1)
        {
            SenderVerification::create([
                'sendgrid_id' => $response['id'],
                'nickname' => $response['nickname'],
                'from_email' => $response['from_email'],
                'from_name' => $response['from_name'],
                'reply_to' => $response['reply_to'],
                'reply_to_name' => $response['reply_to_name'],
                'address' => $response['address'],
                'address2' => $response['address2'],
                'state' => $response['state'],
                'city' => $response['city'],
                'country' => $response['country'],
                'zip' => $response['zip'],
                'verified' => $response['verified'],
                'locked' => $response['locked'],
            ]);
        }
        return $success;
    }

    public function deleteSenderVerification($sendgrid_id)
    {
        $url = $this->baseURL.'/v3/verified_senders/'.$sendgrid_id;
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
        ])->delete($url);

        return $response->successful();
    }

    public function getAllSingleSend()
    {
        $url = $this->baseURL.'/v3/verified_senders';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
        ])->get($url);

        $success = $response->successful();

        if ($success == 1)
        {
            $datas = $response['results'];
            foreach ($datas as $data){
                SenderVerification::firstOrCreate([
                    'sendgrid_id' => $data['id'],
                    'nickname' => $data['nickname'],
                    'from_email' => $data['from_email'],
                    'from_name' => $data['from_name'],
                    'reply_to' => $data['reply_to'],
                    'reply_to_name' => $data['reply_to_name'],
                    'address' => $data['address'],
                    'address2' => $data['address2'],
                    'state' => $data['state'],
                    'city' => $data['city'],
                    'country' => $data['country'],
                    'zip' => $data['zip'],
                    'verified' => $data['verified'],
                    'locked' => $data['locked'],
                ]);
            }
        }
        return $success;
    }

    public function domainWarnList()
    {
        $url = $this->baseURL.'/v3/verified_senders/steps_completed';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
        ])->get($url);
        dd($response->body());
    }
}
