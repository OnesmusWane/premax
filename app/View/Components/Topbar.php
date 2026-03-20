<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;
use App\Models\ContactInformation;

class Topbar extends Component
{
    public ?ContactInformation $contact;

    public function __construct()
    {
        // Cache for 60 minutes — contact info rarely changes.
        // Clear cache via: Cache::forget('contact.primary')
        $this->contact = Cache::remember('contact.primary', now()->addMinutes(60), function () {
            return ContactInformation::where('is_primary', true)
                ->where('is_active', true)
                ->first();
        });
    }

    public function render(): View|Closure|string
    {
        return view('components.topbar');
    }
}