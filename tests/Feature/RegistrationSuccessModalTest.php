<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegistrationSuccessModalTest extends TestCase
{
    public function test_registration_success_is_shown_in_a_clear_modal(): void
    {
        $this->withSession([
            'success' => 'Pendaftaran berhasil dikirim dan menunggu verifikasi panitia.',
            'registrant_name' => 'Peserta MUSI RUN',
        ])
            ->get('/registrasi')
            ->assertOk()
            ->assertSee('submit-success-open')
            ->assertSee('submitSuccessModal')
            ->assertSee('Terima kasih, Peserta MUSI RUN!')
            ->assertSee('menunggu verifikasi panitia')
            ->assertSee('Pantau email atau WA Anda');
    }
}
