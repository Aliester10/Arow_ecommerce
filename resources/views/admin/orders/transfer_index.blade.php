@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Order Langsung (Transfer)
        </h2>
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
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">ID</th>
                        <th class="min-w-[200px] py-4 px-4 font-medium text-black dark:text-white">Customer</th>
                        <th class="min-w-[160px] py-4 px-4 font-medium text-black dark:text-white">Tanggal</th>
                        <th class="min-w-[140px] py-4 px-4 font-medium text-black dark:text-white">Total</th>
                        <th class="min-w-[160px] py-4 px-4 font-medium text-black dark:text-white">Status Pembayaran</th>
                        <th class="min-w-[160px] py-4 px-4 font-medium text-black dark:text-white">Bukti Transfer</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        @php
                            $payment = $order->payment;
                            $hasProof = !empty($payment->bukti_transfer);
                            $status = $payment->status ?? 'pending';
                            $statusClass = match($status) {
                                'paid' => 'bg-success text-success',
                                'failed' => 'bg-danger text-danger',
                                default => 'bg-warning text-warning'
                            };
                        @endphp
                        <tr>
                            <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-gray-700 xl:pl-11">
                                <p class="text-black dark:text-white font-medium">#{{ $order->id_order }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white font-medium">{{ $order->user->nama_user ?? '-' }}</p>
                                <p class="text-sm text-gray-500">{{ $order->user->email_user ?? '' }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ optional($order->tanggal_order)->format('d M Y H:i') }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white font-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <span class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium {{ $statusClass }}">
                                    {{ strtoupper($status) }}
                                </span>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <span class="text-sm {{ $hasProof ? 'text-green-600' : 'text-gray-500' }}">
                                    {{ $hasProof ? 'Ada' : 'Belum' }}
                                </span>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <a href="{{ route('admin.orders.show', $order->id_order) }}" class="text-primary hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border-b border-[#eee] py-5 px-4 dark:border-gray-700 text-center">
                                Tidak ada order.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 p-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
