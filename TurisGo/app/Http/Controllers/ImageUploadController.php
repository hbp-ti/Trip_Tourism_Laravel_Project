<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PopupHelper;

class ImageUploadController extends Controller
{
    public function handleUpload(Request $request)
    {

        $locale = $request->route('locale');

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png|max:8192', 
        ]);

        $path = $request->file('profile_picture')->store('imageUploads', 'public');
        $user = User::find(Auth::id());
        $user->image = $path;
        $user->update();

        $popup = PopupHelper::showPopup(
            'Success!',
            'Your profile picture has been updated',
            'success',
            'OK',
            false,
            '',
            5000
        );

        return redirect()->route('auth.profile.show', ['locale' => $locale])->with('popup', $popup);
	}
}
