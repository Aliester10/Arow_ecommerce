@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Rekening Pembayaran
        </h2>
        <a href="{{ route('admin.payment_accounts.create') }}"
            class="inline-flex items-center justify-center rounded-md bg-primary py-4 px-10 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
            <i class="fas fa-plus mr-2"></i> Tambah Rekening
        </a>
    </div>

    <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-gray-700 dark:bg-gray-800 sm:px-7.5 xl:pb-1">
        @if(session('success'))
            <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-gray-700">
                        <th class="min-w-[160px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">Bank</th>
                        <th class="min-w-[180px] py-4 px-4 font-medium text-black dark:text-white">No. Rekening</th>
                        <th class="min-w-[180px] py-4 px-4 font-medium text-black dark:text-white">Nama Pemilik</th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">Status</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paymentAccounts as $account)
                        <tr>
                            <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-gray-700 xl:pl-11">
                                <p class="text-black dark:text-white font-medium">{{ $account->bank_name }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ $account->account_number }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ $account->account_holder }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <span class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium {{ $account->is_active ? 'bg-success text-success' : 'bg-danger text-danger' }}">
                                    {{ $account->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <div class="flex items-center space-x-3.5">
                                    <a href="{{ route('admin.payment_accounts.edit', $account->id) }}" class="hover:text-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.payment_accounts.destroy', $account->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekening ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:text-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border-b border-[#eee] py-5 px-4 dark:border-gray-700 text-center">
                                Tidak ada rekening pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 p-4">
            {{ $paymentAccounts->links() }}
        </div>
    </div>
@endsection
