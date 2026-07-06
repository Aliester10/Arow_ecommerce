<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Produk;
use App\Models\PromoCampaign;

class UpdatePromoCampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $promoCampaign = $this->route('promo_campaign');
        $promoId = is_object($promoCampaign) ? $promoCampaign->id : $promoCampaign;

        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:promo_campaigns,slug,' . $promoId,
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:aktif,nonaktif',
            'selected_products' => 'required|array|min:1',
            'selected_products.*' => 'required|exists:produk,id_produk',
            'discount_type' => 'required|array',
            'discount_value' => 'required|array',
        ];
    }

    /**
     * Custom error messages or post-validation hooks.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $selectedProducts = $this->input('selected_products', []);
            $discountTypes = $this->input('discount_type', []);
            $discountValues = $this->input('discount_value', []);
            $startDate = $this->input('start_date');
            $endDate = $this->input('end_date');
            $status = $this->input('status');

            $promoCampaign = $this->route('promo_campaign');
            $promoId = is_object($promoCampaign) ? $promoCampaign->id : $promoCampaign;

            if (empty($selectedProducts)) {
                return;
            }

            foreach ($selectedProducts as $productId) {
                $product = Produk::find($productId);
                if (!$product) {
                    continue;
                }

                $type = $discountTypes[$productId] ?? null;
                $value = $discountValues[$productId] ?? null;

                // 1. Diskon tidak boleh kosong
                if (is_null($value) || $value === '') {
                    $validator->errors()->add("discount_value.{$productId}", "Diskon untuk produk {$product->nama_produk} tidak boleh kosong.");
                    continue;
                }

                $value = floatval($value);

                // 2. Diskon persen maksimal 100%
                if ($type === 'percent') {
                    if ($value <= 0 || $value > 100) {
                        $validator->errors()->add("discount_value.{$productId}", "Persentase diskon untuk produk {$product->nama_produk} harus antara 1% sampai 100%.");
                    }
                }

                // 3. Diskon nominal tidak boleh lebih besar dari harga produk
                if ($type === 'nominal') {
                    if ($value <= 0) {
                        $validator->errors()->add("discount_value.{$productId}", "Nominal diskon untuk produk {$product->nama_produk} harus lebih besar dari 0.");
                    } elseif ($value > $product->harga_produk) {
                        $validator->errors()->add("discount_value.{$productId}", "Nominal diskon untuk produk {$product->nama_produk} tidak boleh melebihi harga asli produk (Rp. " . number_format($product->harga_produk, 0, ',', '.') . ").");
                    }
                }

                // 4. Overlap check: Satu produk dapat ikut promo lain setelah promo sebelumnya selesai.
                if ($status === 'aktif' && $startDate && $endDate) {
                    $overlappingPromo = PromoCampaign::where('status', 'aktif')
                        ->when($promoId, function ($query) use ($promoId) {
                            $query->where('id', '!=', $promoId);
                        })
                        ->whereHas('products', function ($query) use ($productId) {
                            $query->where('product_id', $productId);
                        })
                        ->where(function ($query) use ($startDate, $endDate) {
                            $query->where(function ($q) use ($startDate, $endDate) {
                                $q->where('start_date', '<=', $startDate)
                                  ->where('end_date', '>=', $startDate);
                            })->orWhere(function ($q) use ($startDate, $endDate) {
                                $q->where('start_date', '<=', $endDate)
                                  ->where('end_date', '>=', $endDate);
                            })->orWhere(function ($q) use ($startDate, $endDate) {
                                $q->where('start_date', '>=', $startDate)
                                  ->where('end_date', '<=', $endDate);
                            });
                        })
                        ->first();

                    if ($overlappingPromo) {
                        $validator->errors()->add("selected_products", "Produk '{$product->nama_produk}' sudah terdaftar pada promo campaign aktif lain '{$overlappingPromo->title}' ({$overlappingPromo->start_date->format('Y-m-d H:i')} s/d {$overlappingPromo->end_date->format('Y-m-d H:i')}) pada periode ini.");
                    }
                }
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Nama promo wajib diisi.',
            'slug.required' => 'Slug promo wajib diisi.',
            'slug.unique' => 'Slug promo sudah digunakan, silakan pilih nama promo lain.',
            'selected_products.required' => 'Minimal memilih 1 produk.',
            'selected_products.min' => 'Minimal memilih 1 produk.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'end_date.required' => 'Tanggal berakhir wajib diisi.',
            'end_date.after_or_equal' => 'Tanggal berakhir harus sama atau setelah tanggal mulai.',
        ];
    }
}
