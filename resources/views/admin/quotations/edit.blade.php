@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Edit Quotation - Order #{{ $order->id_order }}
            </h2>
            <div class="text-sm text-gray-500">Customer: {{ $order->user->nama_user ?? '-' }}</div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.quotations.download', $order->id_order) }}"
                class="inline-flex items-center justify-center rounded-md bg-orange-600 py-3 px-5 text-center font-medium text-white hover:bg-orange-700">
                Download (Excel)
            </a>
            <a href="{{ route('admin.orders.show', $order->id_order) }}"
                class="inline-flex items-center justify-center rounded-md bg-gray-200 py-3 px-5 text-center font-medium text-gray-800 hover:bg-gray-300">
                Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.quotations.update', $order->id_order) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                <h3 class="font-medium text-black dark:text-white">Item Quotation</h3>
            </div>

            <div class="p-6.5">
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-2 text-left dark:bg-gray-700">
                                <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white">Produk</th>
                                <th class="min-w-[100px] py-4 px-4 font-medium text-black dark:text-white">Qty</th>
                                <th class="min-w-[160px] py-4 px-4 font-medium text-black dark:text-white">Harga</th>
                                <th class="min-w-[260px] py-4 px-4 font-medium text-black dark:text-white">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotation->items as $i => $item)
                                <tr>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                        <input type="hidden" name="items[{{ $i }}][id]" value="{{ $item->id }}" />
                                        <input type="text" name="items[{{ $i }}][product_name]"
                                            value="{{ old('items.' . $i . '.product_name', $item->product_name ?? ($item->product->nama_produk ?? '')) }}"
                                            class="w-full rounded border border-gray-300 bg-transparent py-2 px-3 text-sm outline-none focus:border-primary" />
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                        <input type="number" min="1" name="items[{{ $i }}][qty]"
                                            value="{{ old('items.' . $i . '.qty', $item->qty) }}"
                                            class="w-full rounded border border-gray-300 bg-transparent py-2 px-3 text-sm outline-none focus:border-primary" />
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                        <input type="number" min="0" step="1" name="items[{{ $i }}][price]"
                                            value="{{ old('items.' . $i . '.price', (float) $item->price) }}"
                                            class="w-full rounded border border-gray-300 bg-transparent py-2 px-3 text-sm outline-none focus:border-primary" />
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                        <textarea name="items[{{ $i }}][description]" rows="2"
                                            class="w-full rounded border border-gray-300 bg-transparent py-2 px-3 text-sm outline-none focus:border-primary">{{ old('items.' . $i . '.description', $item->description) }}</textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="mt-6 flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                    Simpan Perubahan Quotation
                </button>
            </div>
        </div>
    </form>
@endsection
