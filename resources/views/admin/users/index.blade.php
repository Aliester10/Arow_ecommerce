@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Daftar User
        </h2>
    </div>

    <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-gray-700 dark:bg-gray-800 sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-gray-700">
                        <th class="min-w-[80px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">ID</th>
                        <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white">Nama</th>
                        <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white">Email</th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">Role</th>
                        <th class="min-w-[180px] py-4 px-4 font-medium text-black dark:text-white">Register</th>
                        <th class="min-w-[180px] py-4 px-4 font-medium text-black dark:text-white">Last Login</th>
                        <th class="min-w-[160px] py-4 px-4 font-medium text-black dark:text-white">Last IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-gray-700 xl:pl-11">
                                <p class="text-black dark:text-white">{{ $user->id_user }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ $user->nama_user }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ $user->email_user }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ $user->role_user }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ optional($user->created_at)->format('Y-m-d H:i') ?? '-' }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ optional($user->last_login_at)->format('Y-m-d H:i') ?? '-' }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ $user->last_login_ip ?? '-' }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border-b border-[#eee] py-5 px-4 dark:border-gray-700 text-center">
                                Tidak ada user ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 p-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
