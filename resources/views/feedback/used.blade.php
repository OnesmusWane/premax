@extends('layouts.default-menu-page')
@section('content')
<div class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 max-w-md w-full text-center">
        <div class="w-14 h-14 rounded-full bg-amber-50 flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h2 class="text-xl font-extrabold text-gray-900 mb-2">Already Submitted</h2>
        <p class="text-sm text-gray-500 leading-relaxed">
            This feedback link has already been used. Each link can only be used once.<br>
            Thank you for your response!
        </p>
        <a href="{{ url('/') }}" class="inline-block mt-6 text-sm font-bold text-custom-primary hover:underline">
            Back to Home
        </a>
    </div>
</div>
@endsection