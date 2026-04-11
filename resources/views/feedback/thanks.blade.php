@extends('layouts.default-menu-page')
@section('content')
<div class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 max-w-md w-full text-center">
        <div class="w-14 h-14 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h2 class="text-xl font-extrabold text-gray-900 mb-2">Thank You!</h2>
        <p class="text-sm text-gray-500 leading-relaxed">
            Your feedback has been submitted successfully.<br>
            We appreciate you taking the time — it helps us serve you better.
        </p>
        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-2 mt-6 bg-custom-primary hover:bg-red-800 text-white font-bold text-sm px-6 py-2.5 rounded-xl no-underline transition-colors duration-200">
            Back to Home
        </a>
    </div>
</div>
@endsection