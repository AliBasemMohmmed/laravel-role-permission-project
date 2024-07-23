<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    /**
     * Instantiate a new ProfileController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-profile|create-profile|edit-profile|delete-profile', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-profile', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-profile', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-profile', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('profiles.index', [
            'profiles' => Profile::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // تحقق من وجود صورة
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $data['image'] = $imagePath;
        }

        $userId = Auth::id();

        // تحقق إذا كان للمستخدم ملف تعريف موجود بالفعل
        if (Profile::where('user_id', $userId)->exists()) {
            return redirect()->route('profiles.index')
                ->with('success', 'You already have a profile.');
        }

        // أضف user_id إلى البيانات
        $data['user_id'] = $userId;

        // أنشئ السجل الجديد
        Profile::create($data);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('profiles.index')
            ->with('success', 'Profile created successfully.');
    }




    /**
     * Display the specified resource.
     */
    public function show(Profile $profile): View
    {
        return view('profiles.show', [
            'profile' => $profile
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile): View
    {
        return view('profiles.edit', [
            'profile' => $profile
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, Profile $profile): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($profile->image) {
                Storage::disk('public')->delete($profile->image);
            }

            $imagePath = $request->file('image')->store('profile_images', 'public');
            $data['image'] = $imagePath;
        }

        $profile->update($data);

        return redirect()->route('profiles.show', $profile->id)
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile): RedirectResponse
    {
        $profile->delete();
        return redirect()->route('profiles.index')
            ->withSuccess('Profile deleted successfully.');
    }
}
