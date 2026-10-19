<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Step 1: Data Diri
            'name' => 'required|string|max:255',
            'nik' => 'required|string|regex:/^[0-9]+$/|min:13|max:20',
            'email' => 'required|email|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'whatsapp' => 'required|regex:/^[0-9]{10,15}$/',
            'jersey_size' => 'required|string|max:10',
            'kategori' => 'required|string|in:umum,pelajar',
            'id_type' => 'nullable|string|max:50',
            'blood_type' => 'nullable|string|max:10',
            'kewarganegaraan' => 'nullable|string|max:100',
            'negara' => 'required|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kota' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:500',
            'emergency_phone' => 'required|regex:/^[0-9]{10,15}$/',
            'emergency_name' => 'required|string|max:255',
            'emergency_relation' => 'nullable|string|max:100',
            'community' => 'nullable|string|max:255',
            'medical_history' => 'nullable|string|max:1000',

            // Race category and proof of payment
            'kategori_jarak' => 'required|string|max:100',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,webp,svg|max:1024',
        ]);

        try {
            $path = null;
            if ($request->hasFile('payment_proof')) {
                $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            }

            $registrant = Registrant::create([
                // Step 1: Data Diri
                'name' => $validated['name'],
                'nik' => $validated['nik'],
                'email' => $validated['email'],
                'dob' => $validated['dob'],
                'gender' => $validated['gender'],
                'whatsapp' => $validated['whatsapp'],
                'jersey_size' => $validated['jersey_size'],
                'kategori' => $validated['kategori'],
                'id_type' => $validated['id_type'] ?? 'KTP',
                'blood_type' => $validated['blood_type'],
                'kewarganegaraan' => $validated['kewarganegaraan'] ?? 'Indonesia',
                'negara' => $validated['negara'] ?? 'Indonesia',
                'provinsi' => $validated['provinsi'],
                'kota' => $validated['kota'],
                'alamat' => $validated['alamat'],
                'emergency_phone' => $validated['emergency_phone'],
                'emergency_name' => $validated['emergency_name'],
                'emergency_relation' => $validated['emergency_relation'],
                'community' => $validated['community'],
                'medical_history' => $validated['medical_history'],

                // Preserve the registration payment proof for admin review.
                'kategori_jarak' => $validated['kategori_jarak'],
                'payment_proof_path' => $path,
                'agreed' => true,
                'status' => 'pending',
            ]);

            // Check if request is AJAX
            if ($request->wantsJson() || $request->header('X-Requested-With') == 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'message' => 'Pendaftaran berhasil dikirim dan menunggu verifikasi panitia.',
                    'registrant_id' => $registrant->id,
                ]);
            }

            return redirect()->back()
                ->with([
                    'success' => 'Pendaftaran berhasil dikirim dan menunggu verifikasi panitia.',
                    'registrant_name' => $registrant->name,
                    'registrant_created_at' => $registrant->created_at->format('d/m/Y H:i'),
                ]);
        } catch (\Exception $e) {
            \Log::error('Registration error: '.$e->getMessage());

            // Check if request is AJAX
            if ($request->wantsJson() || $request->header('X-Requested-With') == 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan registrasi: '.$e->getMessage(),
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pendaftaran: '.$e->getMessage());
        }
    }
}
