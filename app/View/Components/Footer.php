<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;
use App\Models\ContactInformation;
use App\Models\ServiceCategory;
use App\Models\LegalPage;

class Footer extends Component
{
    public ?ContactInformation $contact;
    public $categories;
    public $legalPages;

    public function __construct()
    {
        // Contact info — shared with topbar, same cache key
        $this->contact = Cache::remember('contact.primary', now()->addMinutes(60), function () {
            return ContactInformation::where('is_primary', true)
                ->where('is_active', true)
                ->first();
        });

        // Top 5 service categories for the footer links column
        $this->categories = Cache::remember('footer.categories', now()->addMinutes(60), function () {
            return ServiceCategory::where('is_active', true)
                ->orderBy('sort_order')
                ->limit(5)
                ->get(['id', 'name', 'slug']);
        });

        // Legal pages for footer bottom bar links
        $this->legalPages = Cache::remember('footer.legal', now()->addHours(6), function () {
            return LegalPage::active()
                ->orderBy('id')
                ->get(['title', 'slug']);
        });
    }

    public function render(): View|Closure|string
    {
        return view('components.footer');
    }
}