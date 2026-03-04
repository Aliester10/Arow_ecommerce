@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Pembayaran</h1>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Billing & Shipping Details -->
            <div class="w-full lg:w-3/5">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Alamat Pengiriman</h3>
                    <div class="text-sm text-gray-600 mb-4">
                        <p class="font-bold text-gray-800">{{ Auth::user()->nama_user }}</p>
                        <p class="mt-1">{{ Auth::user()->email_user }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Penerima</label>
                            <input type="text" name="shipping_name" form="checkout-form"
                                value="{{ old('shipping_name', Auth::user()->nama_user) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                required>
                            @error('shipping_name')
                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">No. HP</label>
                            <input type="text" name="shipping_phone" form="checkout-form"
                                value="{{ old('shipping_phone') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                placeholder="08xxxxxxxxxx" required>
                            @error('shipping_phone')
                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="shipping_address" form="checkout-form" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan"
                                required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Provinsi (Dropdown from RajaOngkir V2) --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Provinsi</label>
                            <select id="shipping_province_id" name="shipping_province" form="checkout-form"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                required>
                                <option value="">Memuat provinsi...</option>
                            </select>
                            @error('shipping_province')
                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kota/Kabupaten --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kota/Kabupaten</label>
                            <select id="shipping_city_select" name="shipping_city" form="checkout-form"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                required disabled>
                                <option value="">Pilih provinsi dulu</option>
                            </select>
                            @error('shipping_city')
                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kecamatan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kecamatan</label>
                            <select id="shipping_district_select" name="shipping_district" form="checkout-form"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                required disabled>
                                <option value="">Pilih kota dulu</option>
                            </select>
                            @error('shipping_district')
                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Desa/Kelurahan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Desa/Kelurahan</label>
                            <select id="shipping_village_select" name="shipping_village" form="checkout-form"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                required disabled>
                                <option value="">Pilih kecamatan dulu</option>
                            </select>
                            @error('shipping_village')
                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kode Pos</label>
                            <input type="text" name="shipping_postcode" form="checkout-form"
                                value="{{ old('shipping_postcode') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                required>
                            @error('shipping_postcode')
                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Pilihan Kurir & Ongkos Kirim --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
                        <i class="fas fa-truck mr-2 text-orange-500"></i>Pilih Kurir & Layanan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kurir</label>
                            <select id="courier_select"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                disabled>
                                <option value="">Pilih desa/kelurahan dulu</option>
                                @foreach($couriers as $courier)
                                    <option value="{{ $courier }}">{{ strtoupper($courier) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Layanan</label>
                            <select id="service_select"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                disabled>
                                <option value="">Pilih kurir dulu</option>
                            </select>
                        </div>
                    </div>

                    {{-- Loading indicator --}}
                    <div id="shipping-loading" class="hidden text-center py-3">
                        <div class="inline-flex items-center text-sm text-gray-500">
                            <svg class="animate-spin h-4 w-4 mr-2 text-orange-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Menghitung ongkos kirim...
                        </div>
                    </div>

                    {{-- Shipping cost result --}}
                    <div id="shipping-result" class="hidden mt-3 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-800" id="result-courier-name">-</p>
                                <p class="text-sm text-gray-500" id="result-etd">-</p>
                            </div>
                            <p class="text-lg font-bold text-orange-600" id="result-cost">Rp 0</p>
                        </div>
                    </div>

                    {{-- Error --}}
                    <div id="shipping-error"
                        class="hidden mt-3 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
                        Gagal menghitung ongkos kirim. Pastikan API Key RajaOngkir sudah dikonfigurasi.
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Metode Pembayaran</h3>
                    <form id="checkout-form" action="{{ route('checkout.placeOrder') }}" method="POST">
                        @csrf
                        @if(request()->has('buy_now_item'))
                            <input type="hidden" name="buy_now_item" value="{{ request('buy_now_item') }}">
                        @endif
                        {{-- Hidden shipping fields --}}
                        <input type="hidden" name="shipping_cost" id="input_shipping_cost" value="0">
                        <input type="hidden" name="shipping_courier" id="input_shipping_courier" value="">
                        <input type="hidden" name="shipping_service" id="input_shipping_service" value="">
                        <input type="hidden" name="shipping_etd" id="input_shipping_etd" value="">
                        <input type="hidden" name="destination_city_id" id="input_destination_city_id" value="">
                        <input type="hidden" name="destination_village_code" id="input_destination_village_code" value="">

                        <div class="space-y-3">
                            @php
                                $selected = $selectedMethod ?? null;
                                $defaultMethod = in_array($selected, ['quotation', 'transfer'], true) ? $selected : 'transfer';
                             @endphp

                            <label
                                class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="quotation"
                                    class="form-radio text-orange-600 focus:ring-orange-500" {{ $defaultMethod === 'quotation' ? 'checked' : '' }}>
                                <div class="flex-1">
                                    <span class="block font-medium text-gray-800">Quotation</span>
                                    <span class="block text-xs text-gray-500">Ajukan penawaran (quotation) sebelum
                                        bayar</span>
                                </div>
                                <i class="fas fa-file-invoice text-gray-400"></i>
                            </label>

                            <label
                                class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="transfer"
                                    class="form-radio text-orange-600 focus:ring-orange-500" {{ $defaultMethod === 'transfer' ? 'checked' : '' }}>
                                <div class="flex-1">
                                    <span class="block font-medium text-gray-800">Transfer Bank</span>
                                    <span class="block text-xs text-gray-500">Transfer ke rekening bank tujuan</span>

                                    <div class="mt-3">
                                        <select name="payment_account_id"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
                                            <option value="">Pilih rekening tujuan</option>
                                            @foreach(($paymentAccounts ?? collect()) as $account)
                                                <option value="{{ $account->id }}" {{ (string) old('payment_account_id') === (string) $account->id ? 'selected' : '' }}>
                                                    {{ $account->bank_name }} - {{ $account->account_number }}
                                                    ({{ $account->account_holder }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('payment_account_id')
                                            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <i class="fas fa-university text-gray-400"></i>
                            </label>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="w-full lg:w-2/5">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Pesanan</h3>

                    <ul class="divide-y divide-gray-100 mb-4 max-h-64 overflow-y-auto pr-2">
                        @foreach($cart->details as $detail)
                            <li class="py-3 flex justify-between text-sm">
                                <div class="flex items-center">
                                    <span
                                        class="bg-gray-100 text-gray-500 w-6 h-6 rounded flex items-center justify-center text-xs mr-2">{{ $detail->qty_cart }}x</span>
                                    <span class="text-gray-600 line-clamp-1">{{ $detail->produk->nama_produk }}</span>
                                </div>
                                <span class="font-medium text-gray-800">Rp
                                    {{ number_format($detail->harga * $detail->qty_cart, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="border-t border-gray-100 pt-4 space-y-2 text-sm text-gray-600 mb-6">
                        <div class="flex justify-between">
                            <span>Subtotal Belanja</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkos Kirim</span>
                            <span id="summary-shipping-cost" class="font-medium text-gray-500">Belum dipilih</span>
                        </div>
                        <div class="flex justify-between items-center text-xs text-gray-400" id="summary-courier-info"
                            style="display:none;">
                            <span id="summary-courier-detail"></span>
                        </div>
                        <div
                            class="flex justify-between text-lg font-bold text-orange-600 border-t border-gray-100 pt-2 mt-2">
                            <span>Total Tagihan</span>
                            <span id="summary-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button id="btn-place-order" onclick="document.getElementById('checkout-form').submit()"
                        class="block w-full text-center bg-orange-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-orange-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Buat Pesanan
                    </button>
                    <p id="btn-hint" class="text-xs text-center text-gray-400 mt-2">Pilih kurir dan layanan pengiriman untuk
                        melanjutkan</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const provinceSelect = document.getElementById('shipping_province_id');
            const citySelect = document.getElementById('shipping_city_select');
            const districtSelect = document.getElementById('shipping_district_select');
            const villageSelect = document.getElementById('shipping_village_select');
            const courierSelect = document.getElementById('courier_select');
            const serviceSelect = document.getElementById('service_select');
            const shippingLoading = document.getElementById('shipping-loading');
            const shippingResult = document.getElementById('shipping-result');
            const shippingError = document.getElementById('shipping-error');
            const btnPlaceOrder = document.getElementById('btn-place-order');
            const btnHint = document.getElementById('btn-hint');

            // Hidden inputs
            const inputShippingCost = document.getElementById('input_shipping_cost');
            const inputShippingCourier = document.getElementById('input_shipping_courier');
            const inputShippingService = document.getElementById('input_shipping_service');
            const inputShippingEtd = document.getElementById('input_shipping_etd');
            const inputDestinationCityId = document.getElementById('input_destination_city_id');
            const inputDestinationVillageCode = document.getElementById('input_destination_village_code');

            // Summary elements
            const summaryShippingCost = document.getElementById('summary-shipping-cost');
            const summaryTotal = document.getElementById('summary-total');
            const summaryCourierInfo = document.getElementById('summary-courier-info');
            const summaryCourierDetail = document.getElementById('summary-courier-detail');

            const subtotal = {{ $total }};
            const totalWeight = {{ $totalWeight }};

            let costData = []; // store cost results for service selection

            // Formatter
            function formatRupiah(amount) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
            }

            // --- Load Provinces (V2: {data: [{id, name}]}) ---
            fetch('{{ route("shipping.provinces") }}')
                .then(r => r.json())
                .then(res => {
                    provinceSelect.innerHTML = '<option value="">-- Pilih Provinsi --</option>';
                    const provinces = res.data || [];
                    provinces.sort((a, b) => a.name.localeCompare(b.name));
                    provinces.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.name;
                        opt.dataset.id = p.code;
                        opt.textContent = p.name;
                        provinceSelect.appendChild(opt);
                    });
                })
                .catch(() => {
                    provinceSelect.innerHTML = '<option value="">Gagal memuat provinsi</option>';
                });

            // --- Province Change => Load Cities ---
            provinceSelect.addEventListener('change', function () {
                const selectedOpt = this.options[this.selectedIndex];
                const provinceId = selectedOpt?.dataset?.id;

                citySelect.innerHTML = '<option value="">Memuat kota...</option>';
                citySelect.disabled = true;
                districtSelect.disabled = true;
                villageSelect.disabled = true;
                courierSelect.disabled = true;
                serviceSelect.disabled = true;
                resetShippingResult();

                if (!provinceId) return;

                fetch('{{ url("/shipping/cities") }}/' + provinceId)
                    .then(r => r.json())
                    .then(res => {
                        citySelect.innerHTML = '<option value="">-- Pilih Kota --</option>';
                        const cities = res.data || [];
                        cities.sort((a, b) => a.name.localeCompare(b.name));
                        cities.forEach(c => {
                            const opt = document.createElement('option');
                            opt.value = c.name;
                            opt.dataset.id = c.code;
                            opt.textContent = c.name;
                            citySelect.appendChild(opt);
                        });
                        citySelect.disabled = false;
                    })
                    .catch(() => {
                        citySelect.innerHTML = '<option value="">Gagal memuat kota</option>';
                    });
            });

            // --- City Change => Load Districts ---
            citySelect.addEventListener('change', function () {
                const selectedOpt = this.options[this.selectedIndex];
                const cityId = selectedOpt?.dataset?.id;

                inputDestinationCityId.value = cityId || '';

                districtSelect.innerHTML = '<option value="">Memuat kecamatan...</option>';
                districtSelect.disabled = true;
                villageSelect.disabled = true;
                courierSelect.disabled = true;
                serviceSelect.disabled = true;
                resetShippingResult();

                if (!cityId) return;

                fetch('{{ url("/shipping/districts") }}/' + cityId)
                    .then(r => r.json())
                    .then(res => {
                        districtSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                        const districts = res.data || [];
                        districts.sort((a, b) => a.name.localeCompare(b.name));
                        districts.forEach(d => {
                            const opt = document.createElement('option');
                            opt.value = d.name;
                            opt.dataset.id = d.code;
                            opt.textContent = d.name;
                            districtSelect.appendChild(opt);
                        });
                        districtSelect.disabled = false;
                    })
                    .catch(() => {
                        districtSelect.innerHTML = '<option value="">Gagal memuat kecamatan</option>';
                    });
            });

            // --- District Change => Load Villages ---
            districtSelect.addEventListener('change', function () {
                const selectedOpt = this.options[this.selectedIndex];
                const districtId = selectedOpt?.dataset?.id;

                villageSelect.innerHTML = '<option value="">Memuat desa...</option>';
                villageSelect.disabled = true;
                courierSelect.disabled = true;
                serviceSelect.disabled = true;
                resetShippingResult();

                if (!districtId) return;

                fetch('{{ url("/shipping/villages") }}/' + districtId)
                    .then(r => r.json())
                    .then(res => {
                        villageSelect.innerHTML = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                        const villages = res.data || [];
                        villages.sort((a, b) => a.name.localeCompare(b.name));
                        villages.forEach(v => {
                            const opt = document.createElement('option');
                            opt.value = v.name;
                            opt.dataset.id = v.code;
                            opt.textContent = v.name;
                            villageSelect.appendChild(opt);
                        });
                        villageSelect.disabled = false;
                    })
                    .catch(() => {
                        villageSelect.innerHTML = '<option value="">Gagal memuat desa</option>';
                    });
            });

            // --- Village Change => Enable Courier ---
            villageSelect.addEventListener('change', function () {
                const selectedOpt = this.options[this.selectedIndex];
                const villageId = selectedOpt?.dataset?.id;

                inputDestinationVillageCode.value = villageId || '';
                resetShippingResult();

                if (villageId) {
                    courierSelect.disabled = false;
                    courierSelect.value = '';
                    serviceSelect.disabled = true;
                    serviceSelect.innerHTML = '<option value="">Pilih kurir dulu</option>';
                } else {
                    courierSelect.disabled = true;
                    serviceSelect.disabled = true;
                }
            });

            // --- Courier Change => Fetch Cost (V2: flat array {data: [{name, code, service, description, cost, etd}]}) ---
            courierSelect.addEventListener('change', function () {
                const courierCode = this.value;
                const villageId = inputDestinationVillageCode.value;

                if (!courierCode || !villageId) return;

                resetShippingResult();
                shippingLoading.classList.remove('hidden');
                serviceSelect.innerHTML = '<option value="">Memuat layanan...</option>';
                serviceSelect.disabled = true;

                fetch('{{ route("shipping.cost") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        destination: villageId,
                        weight: Math.round(totalWeight),
                        courier: courierCode,
                    }),
                })
                    .then(r => {
                        if (!r.ok) {
                            return r.json().then(err => { throw err; });
                        }
                        return r.json();
                    })
                    .then(res => {
                        shippingLoading.classList.add('hidden');

                        // V2 returns flat array: [{name, code, service, description, cost, etd}]
                        costData = res.data || [];

                        if (costData.length === 0) {
                            shippingError.textContent = 'Tidak ada layanan tersedia untuk rute ini.';
                            shippingError.classList.remove('hidden');
                            return;
                        }

                        serviceSelect.innerHTML = '<option value="">-- Pilih Layanan --</option>';
                        costData.forEach((svc, idx) => {
                            const opt = document.createElement('option');
                            opt.value = idx;
                            opt.textContent = svc.service + ' - ' + formatRupiah(svc.cost) + ' (' + svc.etd + ')';
                            opt.dataset.cost = svc.cost;
                            opt.dataset.etd = svc.etd;
                            opt.dataset.service = svc.service;
                            opt.dataset.description = svc.description || '';
                            opt.dataset.courierName = svc.name || courierCode.toUpperCase();
                            serviceSelect.appendChild(opt);
                        });
                        serviceSelect.disabled = false;
                    })
                    .catch(() => {
                        shippingLoading.classList.add('hidden');
                        shippingError.classList.remove('hidden');
                    });
            });

            // --- Service Change => Update Summary ---
            serviceSelect.addEventListener('change', function () {
                const selectedOpt = this.options[this.selectedIndex];
                if (!selectedOpt || !selectedOpt.dataset.cost) {
                    resetShippingResult();
                    return;
                }

                const cost = parseInt(selectedOpt.dataset.cost);
                const etd = selectedOpt.dataset.etd;
                const service = selectedOpt.dataset.service;
                const courierName = selectedOpt.dataset.courierName;
                const courierCode = courierSelect.value;
                const description = selectedOpt.dataset.description;

                // Update hidden inputs
                inputShippingCost.value = cost;
                inputShippingCourier.value = courierCode;
                inputShippingService.value = service;
                inputShippingEtd.value = etd;

                // Show result
                document.getElementById('result-courier-name').textContent = courierName + ' - ' + service;
                document.getElementById('result-etd').textContent = (description ? description + ' | ' : '') + 'Estimasi: ' + etd;
                document.getElementById('result-cost').textContent = formatRupiah(cost);
                shippingResult.classList.remove('hidden');
                shippingError.classList.add('hidden');

                // Update summary
                summaryShippingCost.textContent = formatRupiah(cost);
                summaryShippingCost.className = 'font-medium text-gray-800';
                summaryTotal.textContent = formatRupiah(subtotal + cost);

                summaryCourierDetail.textContent = courierName + ' ' + service + ' (' + etd + ')';
                summaryCourierInfo.style.display = '';

                // Enable button
                btnPlaceOrder.disabled = false;
                btnHint.style.display = 'none';
            });

            function resetShippingResult() {
                shippingResult.classList.add('hidden');
                shippingError.classList.add('hidden');
                inputShippingCost.value = '0';
                inputShippingCourier.value = '';
                inputShippingService.value = '';
                inputShippingEtd.value = '';

                summaryShippingCost.textContent = 'Belum dipilih';
                summaryShippingCost.className = 'font-medium text-gray-500';
                summaryTotal.textContent = formatRupiah(subtotal);
                summaryCourierInfo.style.display = 'none';

                btnPlaceOrder.disabled = true;
                btnHint.style.display = '';
            }
        });
    </script>
@endsection