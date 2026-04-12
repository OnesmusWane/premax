@extends('layouts.default-menu-page')
@section('content')
<div class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 max-w-md w-full text-center">
        <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
            </svg>
        </div>
        <h2 class="text-xl font-extrabold text-gray-900 mb-2">Link Expired</h2>
        <p class="text-sm text-gray-500 leading-relaxed">
            This feedback link has expired. Links are valid for 7 days after service.<br>
            Please contact us if you still wish to share your feedback.
        </p>
        <a href="{{ url('/contact') }}" class="inline-block mt-6 text-sm font-bold text-custom-primary hover:underline">
            Contact Us
        </a>
    </div>
</div>
@endsection