<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Profile\UpdateProfileRequest;
use App\Services\Panel\ProfileService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected ProfileService $profileService) {}

    /**
     * Show the form for editing the resource.
     */
    public function show(Request $request): View
    {
        $user = $request->user();

        $roles = $this->profileService->getAllRoles();

        return view('panel.profile.show', compact('user', 'roles'));
    }

    /**
     * Update the resource in storage.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->profileService->update($request->validated(), $request->user()->id);

        $message = $request->input('_form') === 'update-password'
            ? __('Profile password updated successfully!')
            : __('Profile updated successfully!');

        return redirect()->route('panel.profile.show')
            ->withSuccess($message);
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->profileService->delete($request->user()->id);

        return redirect()->route('login');
    }
}
