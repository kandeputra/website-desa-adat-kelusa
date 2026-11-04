<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function edit() { return view('admin.profil', ['u' => auth()->user()]); }

    public function update(Request $r)
    {
        $u = $r->user();
        $data = $r->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,'.$u->id,
            'jabatan' => 'nullable|string|max:100',
            'password_lama' => 'nullable|required_with:password|current_password',
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [], ['password_lama' => 'kata sandi lama', 'password' => 'kata sandi baru']);
        $u->fill(collect($data)->only('name', 'email', 'jabatan')->all());
        if (! empty($data['password'])) $u->password = $data['password'];
        $u->save();
        return back()->with('ok', 'Profil diperbarui.');
    }
}
