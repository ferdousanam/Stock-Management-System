<?php


namespace Anam\Dashboard\App\Http\View\Composers;


use App\Models\SystemSetting;
use Illuminate\View\View;

class SystemComposer
{
    /**
     * The user repository implementation.
     *
     * @var \App\Models\SystemSetting
     */
    protected $settings;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->settings = SystemSetting::first();
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('settings', $this->settings);
    }
}
