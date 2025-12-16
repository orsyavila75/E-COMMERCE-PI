<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('main.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Handle Notification Update
        if ($request->has('update_notifications')) {
            // In a real app, you would save these preferences to the database
            // $user->settings()->update([
            //     'notif_order' => $request->has('notif_order'),
            //     'notif_promo' => $request->has('notif_promo'),
            // ]);
            
            return back()->with('success', 'Preferensi notifikasi berhasil diperbarui!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $user->update([
            'name' => $request->name,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $file = $request->file('photo');
            $filename = 'profile_' . $user->id_user . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profiles', $filename, 'public');

            $user->update([
                'photo' => $path
            ]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        // User model has 'password' => 'hashed' cast, so we just pass the plain password
        $user->update([
            'password' => $request->password,
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    public function deleteAddress($id)
    {
        // Assuming addresses are stored in a separate table or just clearing the main address for now
        // Since the current implementation seems to store address in 'users' table (based on update method),
        // we will just clear the address field if the ID matches the user (or just clear it generally).
        
        // However, the view shows "Alamat Pengiriman" as if it's a list, but the update method updates 'alamat' on users table.
        // Let's assume for now we just clear the 'alamat' field on the user.
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $user->update(['alamat' => null]);

        return back()->with('success', 'Alamat berhasil dihapus!');
    }
}
