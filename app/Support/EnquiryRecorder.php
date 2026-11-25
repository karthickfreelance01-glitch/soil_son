<?php

namespace App\Support;

use App\Mail\EnquiryMail;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/** Saves an enquiry to the database, keeps a CSV backup and emails the centre. */
class EnquiryRecorder
{
    public static function record(array $data, string $source, Request $request): void
    {
        $data += ['email' => null, 'address' => null, 'service' => null, 'message' => null];
        $data['source'] = $source;
        $data['ip'] = $request->ip();
        $data['page_url'] = substr((string) ($request->input('page_url') ?: $request->headers->get('referer')), 0, 250) ?: null;
        $data['submitted_at'] = now()->toDateTimeString();

        try {
            if (Schema::hasTable('enquiries')) {
                Enquiry::create([
                    'name' => $data['name'], 'mobile' => $data['mobile'], 'email' => $data['email'],
                    'address' => $data['address'], 'service' => $data['service'], 'message' => $data['message'],
                    'source' => $source, 'page_url' => $data['page_url'], 'ip' => $data['ip'], 'status' => 'new',
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Enquiry DB save failed: '.$e->getMessage());
        }

        self::archive($data);

        try {
            Mail::to(config('site.enquiry_email'))->send(new EnquiryMail($data));
        } catch (\Throwable $e) {
            Log::error('Enquiry mail failed: '.$e->getMessage());
        }
    }

    /** Local CSV copy so no enquiry is ever lost to a mail or database outage. */
    protected static function archive(array $data): void
    {
        try {
            $file = 'enquiries.csv';
            if (! Storage::exists($file)) {
                Storage::put($file, "submitted_at,name,mobile,email,address,service,ip\n");
            }
            $row = array_map(
                fn ($v) => '"'.str_replace('"', '""', (string) $v).'"',
                [$data['submitted_at'], $data['name'], $data['mobile'], $data['email'], $data['address'],
                 trim($data['service'].($data['source'] === 'sidebar' ? ' (side enquiry)' : '')), $data['ip']]
            );
            Storage::append($file, implode(',', $row));
        } catch (\Throwable $e) {
            Log::error('Enquiry CSV archive failed: '.$e->getMessage());
        }
    }
}
