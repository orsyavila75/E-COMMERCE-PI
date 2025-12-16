<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $request->validate(
            [
                // field umum
                'name'        => 'required|string|max:255',
                'email'       => 'required|email|unique:users,email',
                'password'    => 'required|min:6|confirmed',
                'role'        => ['required', Rule::in(['seller', 'customer'])],
                'no_telepon'  => 'nullable|string|max:30',
                'alamat'      => 'nullable|string',

                // field seller
                'nama_toko'         => 'required_if:role,seller|nullable|string|max:150',
                'deskripsi_toko'    => 'required_if:role,seller|nullable|string',
                'alamat_pengiriman' => 'required_if:role,seller|nullable|string',
                'kategori_produk'   => 'required_if:role,seller|nullable|string|max:100',

                // logo toko
                'logo_toko' => 'required_if:role,seller|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ],
            [
                'logo_toko.required_if' => 'Logo toko wajib diisi jika mendaftar sebagai seller.',
                'logo_toko.image'       => 'Logo toko harus berupa gambar.',
                'logo_toko.mimes'       => 'Logo toko harus JPG / JPEG / PNG / WEBP.',
                'logo_toko.max'         => 'Ukuran logo toko maksimal 2MB.',
            ]
        );

        $user = null;

        DB::transaction(function () use ($request, &$user) {
            // 1) SIMPAN USERS
            $user = User::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'no_telepon' => $request->no_telepon,
                'alamat'     => $request->alamat,
                'role'       => $request->role,
            ]);

            // 2) SELLER
            if ($request->role === 'seller') {
                $logoPath = null;

                if ($request->hasFile('logo_toko')) {
                    $file = $request->file('logo_toko');

                    if (! $file->isValid()) {
                        throw new \Exception(
                            "Upload gagal. Error code: " . $file->getError() . " / " . $file->getErrorMessage()
                        );
                    }

                    // simpan ke storage/app/public/seller_logo
                    $logoPath = $file->store('seller_logo', 'public');
                }

                Seller::create([
                    'id_seller'         => $user->getKey(),
                    'nama'              => $user->name,
                    'no_telepon'        => $user->no_telepon,
                    'email'             => $user->email,
                    'nama_toko'         => $request->nama_toko,
                    'deskripsi_toko'    => $request->deskripsi_toko,
                    'alamat_pengiriman' => $request->alamat_pengiriman,
                    'kategori_produk'   => $request->kategori_produk,
                    'logo_toko'         => $logoPath,
                    'status'            => 'pending',
                ]);
            }

            // 3) CUSTOMER
            if ($request->role === 'customer') {
                Customer::create([
                    'id_customer'   => $user->getKey(),
                    'nama_customer' => $user->name,
                    'no_telepon'    => $user->no_telepon,
                    'alamat'        => $user->alamat,
                ]);
            }
        });

        Auth::login($user);

        return $this->redirectByRole($user);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // 1. Coba Login sebagai User (Customer / Seller)
        if (Auth::guard('web')->attempt(
            $request->only('email', 'password'),
            $request->filled('remember')
        )) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::guard('web')->user());
        }

        // 2. Coba Login sebagai Admin
        $adminCredentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('admin')->attempt($adminCredentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah'])
            ->withInput();
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function redirectByRole($user)
    {
        if ($user->role === 'seller') {
            $seller = Seller::find($user->id_user);

            if ($seller && $seller->status === 'pending') {
                return redirect()->route('seller.waiting_approval');
            }

            if ($seller && $seller->status === 'rejected') {
                return redirect()->route('seller.rejected');
            }

            return redirect()->route('seller.dashboard');
        }

        return match ($user->role) {
            'customer' => redirect()->route('customer.dashboard'),
            default     => redirect('/'),
        };
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password, // Model cast handles hashing
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Upgrade akun customer menjadi seller (pendaftaran seller pertama kali).
     */
    public function upgradeToSeller(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_toko' => 'required|string|max:150',
            'kategori'  => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'alamat'    => 'required|string',
            'agreement' => 'required',
        ]);

        DB::transaction(function () use ($request, $user) {
            Seller::create([
                'id_seller'         => $user->id_user,
                'nama'              => $user->name,
                'no_telepon'        => $user->no_telepon,
                'email'             => $user->email,
                'nama_toko'         => $request->nama_toko,
                'deskripsi_toko'    => $request->deskripsi,
                'alamat_pengiriman' => $request->alamat,
                'kategori_produk'   => $request->kategori,
                'status'            => 'pending',
            ]);

            $user->update(['role' => 'seller']);
        });

        return redirect()->route('seller.waiting_approval');
    }

    /**
     * Seller mengirim ulang permintaan persetujuan
     * setelah akunnya ditolak / ingin diverifikasi lagi.
     */
    public function requestApprovalAgain(Request $request)
    {
        $user = Auth::user();

        // Hanya seller yang boleh
        if (! $user || $user->role !== 'seller') {
            abort(403, 'Hanya seller yang dapat mengirim permintaan ini.');
        }

        // Cari data seller berdasarkan id_user (id_seller = id_user)
        $seller = Seller::where('id_seller', $user->id_user)->first();

        if (! $seller) {
            return redirect()
                ->back()
                ->with('error', 'Data seller belum ditemukan, silakan daftar seller terlebih dahulu.');
        }

        // Kalau sudah approved
        if ($seller->status === 'approved') {
            return redirect()
                ->back()
                ->with('info', 'Akun seller Anda sudah disetujui.');
        }

        // Kalau sudah pending
        if ($seller->status === 'pending') {
            return redirect()
                ->back()
                ->with('info', 'Permintaan persetujuan Anda sudah dalam status pending.');
        }

        // Kalau REJECTED -> ubah jadi PENDING lagi
        $seller->status = 'pending';
        $seller->save();

        return redirect()
            ->route('seller.waiting_approval')
            ->with('success', 'Permintaan persetujuan seller berhasil dikirim ulang. Silakan menunggu admin melakukan verifikasi.');
    }
}
