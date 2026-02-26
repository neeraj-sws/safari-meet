<?php

namespace App\Services\Enquiry;

use App\Models\Enquiry;
use App\Models\Admin;
use App\Helpers\UserHelper;
use Illuminate\Support\Facades\Mail;
use App\Mail\DynamicMail;

class CreateEnquiryService
{
    public function execute(array $data): Enquiry
    {
        $ipDetails = UserHelper::UserIPDetails();

        $enquiry = Enquiry::create([
            'name'             => ucwords($data['name']),
            'email'            => $data['email'],
            'number'           => $data['number'],
            'type'             => $data['type'],
            'type_id'          => $data['type_id'],
            'url'              => $data['url'],
            'safaris'          => $data['safaris'],
            'travellers'       => $data['travellers'],
            'accommodation_id' => $data['accommodation_id'] ?? null,
            'ip_address'       => $ipDetails['ip_address'],
            'source'           => $data['source'],
            'browser'          => $ipDetails['browser'],
            'os'               => $ipDetails['os'],
            'device'           => $ipDetails['is_mobile'] ? 'Mobile' : 'Desktop',
            'start_date'       => $data['start_date'],
            'end_date'         => $data['end_date'],
        ]);

        $this->sendUserMail($enquiry);
        $this->sendAdminMail($enquiry, $data['url']);

        return $enquiry;
    }

    protected function sendUserMail(Enquiry $enquiry): void
    {
        $payload = [
            'name'         => $enquiry->name,
            'number'       => $enquiry->number,
            'safaris'      => $enquiry->safaris,
            'travellers'   => $enquiry->travellers,
            'accommodation' => optional($enquiry->accommodation)->title,
            'start_date'   => $enquiry->start_date,
            'end_date'     => $enquiry->end_date,
        ];

        $parsed = UserHelper::parseTemplate('USERENQUIRY', $payload);

        Mail::to($enquiry->email)->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );
    }

    protected function sendAdminMail(Enquiry $enquiry, string $url): void
    {
        $payload = [
            'name'           => $enquiry->name,
            'number'         => $enquiry->number,
            'safaris'        => $enquiry->safaris,
            'travellers'     => $enquiry->travellers,
            'accommodation'  => optional($enquiry->accommodation)->title,
            'start_date'     => $enquiry->start_date,
            'end_date'       => $enquiry->end_date,
            'admin_view_url' => route('admin.enquiries'),
            'url'            => $url,
            'received_at'    => $enquiry->created_at,
        ];

        $parsed = UserHelper::parseTemplate('ADMINENQURY', $payload);

        Mail::to(Admin::query()->value('email'))->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );
    }
}
