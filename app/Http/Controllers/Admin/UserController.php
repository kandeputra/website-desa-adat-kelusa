<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/** Kelola akun — hanya Super Admin. */
class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['users' => User::withCount('posts')->orderByRaw("role = 'super_admin' desc")->orderBy('name')->get()]);
    }

    public function create() { return view('admin.users.form', ['u' => new User(['role' => 'admin', 'is_active' => true])]); }
    public function edit(User $user) { return view('admin.users.form', ['u' => $user]); }

    protected function aturan(?User $u = null): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($u?->id)],
            'jabatan' => 'nullable|string|max:100',
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
            'is_active' => 'boolean',
            'password' => [$u ? 'nullable' : 'required', 'confirmed', Password::min(8)->letters()->numbers()],
        ];
    }

    public function store(Request $r)
    {
        $data = $r->validate($this->aturan(), [], ['name' => 'nama', 'role' => 'peran', 'password' => 'kata sandi']);
        User::create($data + ['is_active' => $r->boolean('is_active')]);
        return redirect()->route('admin.pengguna.index')->with('ok', 'Akun '.$data['name'].' dibuat.');
    }

    public function update(Request $r, User $user)
    {
        $data = $r->validate($this->aturan($user), [], ['name' => 'nama', 'role' => 'peran', 'password' => 'kata sandi']);
        $data['is_active'] = $r->boolean('is_active');
        if ($user->is($r->user()) && ($data['role'] !== 'super_admin' || ! $data['is_active'])) {
            return back()->withErrors(['role' => 'Anda tidak bisa menurunkan peran atau menonaktifkan akun sendiri.'])->withInput();
        }
        if ($user->isSuperAdmin() && $data['role'] !== 'super_admin' && User::where('role', 'super_admin')->count() <= 1) {
            return back()->withErrors(['role' => 'Harus ada minimal satu Super Admin.'])->withInput();
        }
        if (empty($data['password'])) unset($data['password']);
        $user->update($data);
        return redirect()->route('admin.pengguna.index')->with('ok', 'Akun '.$user->name.' diperbarui.');
    }

    public function destroy(Request $r, User $user)
    {
        abort_if($user->is($r->user()), 422, 'Anda tidak bisa menghapus akun sendiri.');
        if ($user->isSuperAdmin() && User::where('role', 'super_admin')->count() <= 1) {
            return back()->withErrors(['hapus' => 'Super Admin terakhir tidak bisa dihapus.']);
        }
        $user->delete();
        return back()->with('ok', 'Akun dihapus. Tulisannya tetap tersimpan.');
    }
}
