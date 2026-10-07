<?php

namespace App\View\Composers;

use Illuminate\View\View;

class TrackingComposer
{
    public function compose(View $view): void
    {
        $view->with([
            'showStatistics' => $this->shouldShowStatistics(),
            'showAds' => $this->shouldShowAds()
        ]);
    }

    private function shouldShowStatistics(): bool
    {
        return config('app.statistics_enabled')
            && app()->isProduction()
            && !$this->isIgnoredIp();
    }

    private function shouldShowAds(): bool
    {
        return config('app.ads_enabled') && app()->isProduction();
    }

    private function isIgnoredIp(): bool
    {
        return in_array(request()->ip(), config('app.ignore_ips'), true);
    }
}
