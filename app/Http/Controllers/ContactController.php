<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    /**
     * Display contact page
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Store contact message with security measures
     */
    public function store(Request $request)
    {
        // Rate limiting: maksimal 3 pesan per 15 menit per IP
        $key = 'contact-form:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'rate_limit' => "Terlalu banyak percobaan. Silakan coba lagi dalam {$seconds} detik."
            ])->withInput();
        }

        // Hitung attempt
        RateLimiter::hit($key, 900); // 15 menit

        // Validasi input yang ketat
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-Z\s\.\-\']+$/', // Hanya huruf, spasi, titik, dash, dan apostrof
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:100',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\+]?[0-9\s\-\(\)]+$/', // Hanya angka, spasi, dash, kurung, dan plus
            ],
            'subject' => [
                'required',
                'string',
                'min:5',
                'max:200',
                'regex:/^[a-zA-Z0-9\s\.\-\!\?\:\,\;]+$/', // Hanya karakter yang aman
            ],
            'message' => [
                'required',
                'string',
                'min:10',
                'max:2000',
                'regex:/^[a-zA-Z0-9\s\.\-\!\?\:\,\;\n\r\(\)\[\]\{\}\"\'\/\\]+$/', // Karakter yang diizinkan
            ],
            'g-recaptcha-response' => [
                'required',
                'string',
            ],
        ], [
            'name.regex' => 'Nama hanya boleh mengandung huruf, spasi, titik, dash, dan apostrof.',
            'email.regex' => 'Format email tidak valid.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'subject.regex' => 'Subject mengandung karakter yang tidak diizinkan.',
            'message.regex' => 'Pesan mengandung karakter yang tidak diizinkan.',
            'g-recaptcha-response.required' => 'Silakan verifikasi bahwa Anda bukan robot.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Verifikasi reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $recaptchaSecret = config('services.recaptcha.secret_key');
        
        if ($recaptchaSecret) {
            $recaptchaVerify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}&remoteip={$request->ip()}");
            $recaptchaData = json_decode($recaptchaVerify);
            
            if (!$recaptchaData->success) {
                return back()->withErrors([
                    'recaptcha' => 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.'
                ])->withInput();
            }
        }

        // Sanitasi input untuk mencegah XSS
        $sanitizedData = [
            'name' => strip_tags(trim($request->name)),
            'email' => filter_var(trim($request->email), FILTER_SANITIZE_EMAIL),
            'phone' => $request->phone ? strip_tags(trim($request->phone)) : null,
            'subject' => strip_tags(trim($request->subject)),
            'message' => strip_tags(trim($request->message)),
        ];

        // Cek duplikasi pesan dalam 5 menit terakhir (anti-spam)
        $recentMessage = ContactMessage::where('email', $sanitizedData['email'])
            ->where('created_at', '>=', now()->subMinutes(5))
            ->first();

        if ($recentMessage) {
            return back()->withErrors([
                'duplicate' => 'Anda baru saja mengirim pesan. Silakan tunggu 5 menit sebelum mengirim pesan lagi.'
            ])->withInput();
        }

        try {
            ContactMessage::create($sanitizedData);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan Anda berhasil dikirim. Terima kasih telah menghubungi kami!'
                ]);
            }
            
            return back()->with('success', 'Pesan Anda berhasil dikirim. Terima kasih telah menghubungi kami!');
        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti.'
                ], 500);
            }
            
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti.'
            ])->withInput();
        }
    }
}
