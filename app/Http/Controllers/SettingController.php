<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Instantiate a new SettingController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-settings', ['only' => ['index', 'edit']]);
        $this->middleware('permission:create-settings', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-settings', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-settings', ['only' => ['destroy']]);
    }


    /**
     * Display the user's settings.
     */
    public function index(): View
    {
        $setting = Setting::where('user_id', Auth::id())->first();
        return view('settings.index', compact('setting'));
    }

    /**
     * Show the form for creating a new setting.
     */
    public function create(): View
    {
        return view('settings.create');
    }

    /**
     * Store a newly created setting in storage.
     */
    public function store(StoreSettingRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        // Check if settings already exist
        if (Setting::where('user_id', Auth::id())->exists()) {
            return redirect()->route('settings.index')
                ->with('info', 'Settings already exist. Please update them.');
        }

        Setting::create($data);

        return redirect()->route('settings.index')
            ->with('success', 'Settings created successfully.');
    }


    /**
     * Show the form for editing the existing setting.
     */
    public function edit(): View
    {
        $setting = Setting::where('user_id', Auth::id())->firstOrFail();
        return view('settings.edit', compact('setting'));
    }

    /**
     * Update the existing setting in storage.
     */
    public function update(UpdateSettingRequest $request, $userId): RedirectResponse
    {
        $data = $request->validated();
        $setting = Setting::where('user_id', $userId)->firstOrFail();
        $setting->update($data);

        return redirect()->route('settings.edit', $userId)
            ->with('success', 'Settings updated successfully.');
    }
}
