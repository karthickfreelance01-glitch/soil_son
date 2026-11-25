<?php

namespace App\Http\Controllers;

use App\Support\EnquiryRecorder;
use Illuminate\Http\Request;

/** The slide-out "Quick Enquiry" panel shown on every public page. */
class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        $ok = ['status' => true, 'message' => 'Thank you! Our counsellor will call you shortly.'];

        if (filled($request->input('website'))) {   // honeypot
            return $request->expectsJson() ? response()->json($ok) : back()->with('enquiry_success', $ok['message']);
        }

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'mobile'  => ['required', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'email'   => ['nullable', 'email:rfc', 'max:150'],
            'service' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:1000'],
        ], [
            'mobile.regex' => 'Please enter a valid mobile number.',
        ]);

        EnquiryRecorder::record($data, 'sidebar', $request);

        return $request->expectsJson()
            ? response()->json($ok)
            : back()->with('enquiry_success', $ok['message']);
    }
}
