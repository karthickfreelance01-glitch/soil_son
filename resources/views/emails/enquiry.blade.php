<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><title>New enquiry</title></head>
<body style="font-family:Arial,Helvetica,sans-serif;color:#222;">
    <h2 style="color:#1a28aa;margin:0 0 16px;">New website enquiry</h2>
    <table cellpadding="8" cellspacing="0" border="0" style="border-collapse:collapse;">
        <tr><td><strong>Name</strong></td><td>{{ $data['name'] }}</td></tr>
        <tr><td><strong>Mobile</strong></td><td>{{ $data['mobile'] }}</td></tr>
        @if(!empty($data['email']))<tr><td><strong>Email</strong></td><td>{{ $data['email'] }}</td></tr>@endif
        @if(!empty($data['address']))<tr><td><strong>Address</strong></td><td>{{ $data['address'] }}</td></tr>@endif
        @if(!empty($data['service']))<tr><td><strong>Service</strong></td><td>{{ $data['service'] }}</td></tr>@endif
        @if(!empty($data['message']))<tr><td><strong>Message</strong></td><td>{!! nl2br(e($data['message'])) !!}</td></tr>@endif
        <tr><td><strong>Form</strong></td><td>{{ ($data['source'] ?? 'contact') === 'sidebar' ? 'Side enquiry panel' : 'Contact page' }}</td></tr>
        <tr><td><strong>Received</strong></td><td>{{ $data['submitted_at'] }}</td></tr>
    </table>
    <p style="margin-top:20px;color:#666;font-size:13px;">Manage all enquiries in the admin panel: {{ url('/admin/enquiries') }}</p>
</body>
</html>
