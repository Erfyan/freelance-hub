<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WebAuthnController extends Controller
{
    // Tampilkan form login
    public function showLoginForm(): View
    {
        // Cek apakah user sudah login (misalnya via session old)
        $user = Auth::user();
        
        if ($user) {
            return view('auth.webauthn', compact('user'));
        }
        
        // Jika belum login, tampilkan form input email untuk mencari user
        return view('auth.webauthn-discover');
    }

    // Tampilkan halaman pendaftaran Passkey
    public function showRegisterPage(): View
    {
        return view('profile.passkeys');
    }

    // Cari user berdasarkan email (untuk discovery)
    public function discoverUser(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan']);
        }
        
        // Redirect ke form autentikasi dengan data user
        return redirect()->route('webauthn.show.form', ['user_id' => $user->id]);
    }

    // Tampilkan form autentikasi dengan user yang sudah ditemukan
    public function showAuthForm(Request $request): View
    {
        $user = \App\Models\User::findOrFail($request->user_id);
        
        // Cek apakah user punya credential
        if ($user->webauthnCredentials()->isEmpty()) {
            return view('auth.webauthn-setup', compact('user'));
        }
        
        return view('auth.webauthn', compact('user'));
    }

    // Hapus credential
    public function deleteCredential(Request $request): RedirectResponse
    {
        $request->validate([
            'credential_id' => 'required'
        ]);
        
        $credential = \Laragear\WebAuthn\Models\WebAuthnCredential::where('credential_id', $request->credential_id)->first();
        
        if ($credential && $credential->user_id == Auth::id()) {
            $credential->delete();
            return back()->with('success', 'Sidik jari berhasil dihapus');
        }
        
        return back()->withErrors(['credential_id' => 'Credential tidak ditemukan']);
    }
}
