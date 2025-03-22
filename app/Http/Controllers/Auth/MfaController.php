<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\ImageRendererFormat\SvgImageBackEnd;
use BaconQrCode\Writer;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class MfaController extends Controller
{
    public function enableMfa(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $google2fa = app('pragmarx.google2fa');

        $user->google2fa_secret = $google2fa->generateSecretKey();
        //$user->google2fa_enabled = true;
        $user->save();

        $QRImage = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        //return $QRImage;
        return view('mfa.enable')
            ->with('QRImage', $QRImage)
            ->with('page', 'Aktivasi Fitur MFA')
            ->with('judul','Fitur MFA')
            ->with('subjudul','')
            ->with('tombol','')
            ;
    }

    public function verifyMfa(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $user = $request->user(); // Ambil pengguna yang sedang login
        $google2fa = new Google2FA();

        // Verifikasi OTP dengan secret milik user
        if (!$google2fa->verifyKey($user->google2fa_secret, $request->input('otp'))) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        // Set MFA sebagai aktif dan simpan ke database
        $user->google2fa_enabled = true;
        $user->save();

        // Tandai session MFA sebagai diverifikasi
        session(['mfa_verified' => true]);

        return redirect('admin/home')->with('success', 'MFA diaktifkan!');
    }

}
