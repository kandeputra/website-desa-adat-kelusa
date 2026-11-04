<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Agenda, Galeri, Pengaduan, Post, User};
use App\Support\Pawukon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stat' => [
                'berita' => Post::where('type', 'berita')->where('status', 'terbit')->count(),
                'draf' => Post::where('status', 'draf')->count(),
                'aduanBaru' => Pengaduan::where('status', 'baru')->count(),
                'aduanProses' => Pengaduan::where('status', 'diproses')->count(),
                'agenda' => Agenda::whereBetween('mulai', [now()->startOfDay(), now()->addDays(30)])->count(),
                'dibaca' => (int) Post::sum('views'),
                'galeri' => Galeri::count(),
                'pengguna' => User::where('is_active', true)->count(),
            ],
            'aduan' => Pengaduan::latest()->take(6)->get(),
            'tulisan' => Post::with('penulis')->latest('updated_at')->take(6)->get(),
            'populer' => Post::where('status', 'terbit')->orderByDesc('views')->take(5)->get(),
            'agenda' => Agenda::where('mulai', '>=', now()->startOfDay())->orderBy('mulai')->take(4)->get(),
            'rerahinan' => Pawukon::mendatang(3),
        ]);
    }
}
