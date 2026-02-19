@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-2 sm:px-4">
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 max-w-3xl mx-auto">
            <div class="flex items-center justify-between gap-4">
                <h1 class="text-lg sm:text-xl font-semibold text-gray-800">Profil</h1>
            </div>

            @if (session('success'))
                <div class="mt-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="mt-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1" for="nama_user">Nama</label>
                        <input id="nama_user" name="nama_user" type="text" value="{{ old('nama_user', $user->nama_user) }}"
                            class="w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 @error('nama_user') border-red-400 @enderror" />
                        @error('nama_user')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1" for="email_user">Email</label>
                        <input id="email_user" name="email_user" type="email" value="{{ old('email_user', $user->email_user) }}"
                            class="w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 @error('email_user') border-red-400 @enderror" />
                        @error('email_user')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1" for="nama_perusahaan">Nama Perusahaan</label>
                        <input id="nama_perusahaan" name="nama_perusahaan" type="text"
                            value="{{ old('nama_perusahaan', $user->nama_perusahaan) }}"
                            class="w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 @error('nama_perusahaan') border-red-400 @enderror" />
                        @error('nama_perusahaan')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1" for="nomor_telepon">Nomor Telepon</label>
                        <input id="nomor_telepon" name="nomor_telepon" type="text"
                            value="{{ old('nomor_telepon', $user->nomor_telepon) }}"
                            class="w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 @error('nomor_telepon') border-red-400 @enderror" />
                        @error('nomor_telepon')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs text-gray-500 mb-1" for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3"
                            class="w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 @error('alamat') border-red-400 @enderror">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-2">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 rounded-md text-sm text-white hover:bg-orange-700 transition"
                        style="background-color:#F7931E">
                        Simpan
                    </button>

                    <a href="{{ route('orders.index') }}"
                        class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-sm text-gray-700 hover:bg-gray-50 transition">
                        Pesanan Saya
                    </a>
                </div>
            </form>

        </div>
    </div>
@endsection
