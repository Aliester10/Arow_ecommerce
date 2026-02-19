@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Tambah Admin
        </h2>
        <a href="{{ route('admin.users.admins.index') }}"
            class="inline-flex items-center justify-center rounded-md border border-stroke bg-white py-3 px-6 text-center font-medium text-black hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-md border border-red-300 bg-red-50 p-4 text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-sm border border-stroke bg-white p-6 shadow-default dark:border-gray-700 dark:bg-gray-800">
        <form method="POST" action="{{ route('admin.users.admins.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="mb-2.5 block font-medium text-black dark:text-white">Nama</label>
                <input type="text" name="nama_user" value="{{ old('nama_user') }}"
                    class="w-full rounded-md border border-stroke bg-transparent py-3 px-5 text-black outline-none focus:border-primary dark:border-gray-700 dark:text-white"
                    required>
            </div>

            <div>
                <label class="mb-2.5 block font-medium text-black dark:text-white">Email</label>
                <input type="email" name="email_user" value="{{ old('email_user') }}"
                    class="w-full rounded-md border border-stroke bg-transparent py-3 px-5 text-black outline-none focus:border-primary dark:border-gray-700 dark:text-white"
                    required>
            </div>

            <div>
                <label class="mb-2.5 block font-medium text-black dark:text-white">Password</label>
                <input type="password" name="password"
                    class="w-full rounded-md border border-stroke bg-transparent py-3 px-5 text-black outline-none focus:border-primary dark:border-gray-700 dark:text-white"
                    required>
            </div>

            <div>
                <label class="mb-2.5 block font-medium text-black dark:text-white">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full rounded-md border border-stroke bg-transparent py-3 px-5 text-black outline-none focus:border-primary dark:border-gray-700 dark:text-white"
                    required>
            </div>

            <div>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-md bg-primary py-3 px-8 text-center font-medium text-white hover:bg-opacity-90">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
