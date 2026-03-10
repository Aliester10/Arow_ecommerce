<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Kategori;
use App\Models\Subkategori;
use App\Models\SubSubkategori;
use App\Models\Produk;
use App\Models\ProductImage;
use App\Exports\ProductImportTemplate;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductImportController extends Controller
{
    public function index()
    {
        // Get uploaded images from temp folder
        $uploadedImages = $this->getUploadedImages();
        return view('admin.products.import', compact('uploadedImages'));
    }

    private function getUploadedImages()
    {
        $tempPath = 'uploads/produk/temp';
        $images = [];
        
        if (Storage::disk('public')->exists($tempPath)) {
            $files = Storage::disk('public')->files($tempPath);
            foreach ($files as $file) {
                $filename = basename($file);
                $images[] = [
                    'filename' => $filename,
                    'size' => Storage::disk('public')->size($file),
                    'url' => Storage::disk('public')->url($file),
                    'uploaded_at' => Storage::disk('public')->lastModified($file)
                ];
            }
        }
        
        return collect($images)->sortByDesc('uploaded_at')->values();
    }

    public function uploadImages(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:2048'
        ]);

        $uploadedFiles = [];
        $errors = [];

        foreach ($request->file('images') as $image) {
            try {
                // Clean filename - remove spaces and special characters, but keep original name
                $originalName = $image->getClientOriginalName();
                $filename = $this->cleanFileName($originalName);
                
                // Check if file already exists, if yes, add suffix
                $finalFilename = $this->getUniqueFilename($filename);
                
                $path = $image->storeAs('uploads/produk/temp', $finalFilename, 'public');
                
                // Optimize image if possible
                $fullPath = storage_path('app/public/' . $path);
                try {
                    \Spatie\LaravelImageOptimizer\Facades\ImageOptimizer::optimize($fullPath);
                } catch (\Exception $e) {
                    // Continue without optimization
                }

                $uploadedFiles[] = [
                    'original_name' => $originalName,
                    'filename' => $finalFilename,
                    'display_name' => $finalFilename, // For display in Excel
                    'size' => $image->getSize(),
                    'url' => Storage::disk('public')->url($path)
                ];
            } catch (\Exception $e) {
                $errors[] = "Gagal upload {$image->getClientOriginalName()}: " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => true,
            'uploaded_files' => $uploadedFiles,
            'errors' => $errors,
            'total_uploaded' => count($uploadedFiles)
        ]);
    }

    private function cleanFileName($filename)
    {
        // Remove spaces and special characters, but keep the extension
        $pathInfo = pathinfo($filename);
        $extension = strtolower($pathInfo['extension']);
        $name = $pathInfo['filename'];
        
        // Replace spaces with underscores and remove special characters
        $cleanName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $name);
        $cleanName = preg_replace('/_+/', '_', $cleanName); // Replace multiple underscores with single
        
        return $cleanName . '.' . $extension;
    }

    private function getUniqueFilename($filename)
    {
        $pathInfo = pathinfo($filename);
        $name = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        
        $counter = 1;
        $finalFilename = $filename;
        
        // Check if file exists and add counter if needed
        while (Storage::disk('public')->exists('uploads/produk/temp/' . $finalFilename)) {
            $finalFilename = $name . '_' . $counter . '.' . $extension;
            $counter++;
        }
        
        return $finalFilename;
    }

    public function deleteImage(Request $request)
    {
        $request->validate([
            'filename' => 'required|string'
        ]);

        $filePath = 'uploads/produk/temp/' . $request->filename;
        
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'File not found']);
    }

    public function clearTempImages()
    {
        $tempPath = 'uploads/produk/temp';
        
        if (Storage::disk('public')->exists($tempPath)) {
            $files = Storage::disk('public')->files($tempPath);
            Storage::disk('public')->delete($files);
        }

        return response()->json(['success' => true]);
    }

    public function downloadTemplate()
    {
        return Excel::download(new ProductImportTemplate(), 'template_import_produk.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls|max:10240', // Max 10MB
        ]);

        try {
            $file = $request->file('excel_file');
            $import = new ProductImport();
            Excel::import($import, $file);

            // Move valid images to permanent folder after successful import
            $this->moveValidImages($import->getValidImages());

            return redirect()->route('admin.products.import')
                ->with('success', "Import selesai! {$import->getSuccessCount()} produk berhasil ditambahkan.")
                ->with('errors', $import->getErrors())
                ->with('warnings', $import->getWarnings())
                ->with('image_errors', $import->getImageErrors());

        } catch (\Exception $e) {
            return redirect()->route('admin.products.import')
                ->with('error', 'Terjadi kesalahan saat membaca file Excel: ' . $e->getMessage());
        }
    }

    private function moveValidImages($validImages)
    {
        $tempPath = 'uploads/produk/temp';
        $permanentPath = 'images/produk';

        foreach ($validImages as $filename) {
            $sourceFile = $tempPath . '/' . $filename;
            $destinationFile = $permanentPath . '/' . $filename;

            if (Storage::disk('public')->exists($sourceFile)) {
                Storage::disk('public')->move($sourceFile, $destinationFile);
            }
        }
    }
}

class ProductImport implements ToCollection
{
    protected $errors = [];
    protected $warnings = [];
    protected $imageErrors = [];
    protected $successCount = 0;
    protected $rowCount = 0;
    protected $validImages = [];

    public function collection(Collection $rows)
    {
        // Skip header row and instruction rows
        $dataRows = $rows->slice(1);
        
        // Get existing data for validation
        $brands = Brand::pluck('id_brand', 'nama_brand')->toArray();
        $categories = Kategori::pluck('id_kategori', 'nama_kategori')->toArray();
        $subcategories = Subkategori::pluck('id_subkategori', 'nama_subkategori')->toArray();
        $subSubcategories = SubSubkategori::pluck('id_sub_subkategori', 'nama_sub_subkategori')->toArray();
        
        // Get uploaded images from temp folder
        $uploadedImages = $this->getUploadedImagesFromTemp();

        foreach ($dataRows as $index => $row) {
            $this->rowCount = $index + 2; // +2 because Excel rows start at 1 and we skip header

            // Skip empty rows
            if ($this->isEmptyRow($row)) {
                continue;
            }

            // Skip instruction rows (rows that contain "CONTOH", "PETUNJUK", etc.)
            if ($this->isInstructionRow($row)) {
                continue;
            }

            $productData = $this->extractProductData($row, $this->rowCount);
            $validationResult = $this->validateProductData($productData, $brands, $categories, $subcategories, $subSubcategories, $uploadedImages);

            if (!empty($validationResult['errors'])) {
                $this->errors[] = "Baris {$this->rowCount}: " . implode(', ', $validationResult['errors']);
                continue;
            }

            if (!empty($validationResult['image_errors'])) {
                $this->imageErrors[] = "Baris {$this->rowCount}: " . implode(', ', $validationResult['image_errors']);
                continue;
            }

            if (!empty($validationResult['warnings'])) {
                $this->warnings[] = "Baris {$this->rowCount}: " . implode(', ', $validationResult['warnings']);
            }

            // Create product
            try {
                $this->createProduct($productData, $brands, $categories, $subcategories, $subSubcategories);
                $this->successCount++;
                
                // Add image to valid images list for moving
                if (!empty($productData['gambar_produk'])) {
                    $this->validImages[] = $productData['gambar_produk'];
                }
            } catch (\Exception $e) {
                $this->errors[] = "Baris {$this->rowCount}: Gagal menyimpan produk - " . $e->getMessage();
            }
        }
    }

    private function getUploadedImagesFromTemp()
    {
        $tempPath = 'uploads/produk/temp';
        $images = [];
        
        if (Storage::disk('public')->exists($tempPath)) {
            $files = Storage::disk('public')->files($tempPath);
            foreach ($files as $file) {
                $images[] = basename($file);
            }
        }
        
        return $images;
    }

    private function isEmptyRow($row)
    {
        return $row->filter(function($value) {
            return !empty(trim($value));
        })->isEmpty();
    }

    private function isInstructionRow($row)
    {
        $firstCell = $row->first();
        return is_string($firstCell) && (
            strpos($firstCell, 'CONTOH') !== false ||
            strpos($firstCell, 'PETUNJUK') !== false ||
            strpos($firstCell, 'BRAND') !== false ||
            strpos($firstCell, 'KATEGORI') !== false ||
            strpos($firstCell, 'DATA') !== false ||
            empty(trim($firstCell))
        );
    }

    private function extractProductData($row, $rowNumber)
    {
        return [
            'nama_produk' => trim($row[0] ?? ''),
            'brand' => trim($row[1] ?? ''),
            'kategori' => trim($row[2] ?? ''),
            'sub_kategori' => trim($row[3] ?? ''),
            'sub_sub_kategori' => trim($row[4] ?? ''),
            'sku_produk' => trim($row[5] ?? ''),
            'tipe_produk' => trim($row[6] ?? ''),
            'asal_produk' => trim($row[7] ?? ''),
            'dimensi_produk' => trim($row[8] ?? ''),
            'harga_produk' => trim($row[9] ?? ''),
            'stok_produk' => trim($row[10] ?? ''),
            'berat_produk' => trim($row[11] ?? ''),
            'deskripsi_produk' => trim($row[12] ?? ''),
            'gambar_produk' => trim($row[13] ?? ''),
        ];
    }

    private function validateProductData($data, $brands, $categories, $subcategories, $subSubcategories, $uploadedImages)
    {
        $errors = [];
        $warnings = [];
        $imageErrors = [];

        // Required fields validation
        if (empty($data['nama_produk'])) {
            $errors[] = 'Nama Produk wajib diisi';
        }

        if (empty($data['brand'])) {
            $errors[] = 'Brand wajib diisi';
        } elseif (!isset($brands[$data['brand']])) {
            $errors[] = "Brand '{$data['brand']}' tidak ditemukan di database";
        }

        if (empty($data['kategori'])) {
            $errors[] = 'Kategori wajib diisi';
        } elseif (!isset($categories[$data['kategori']])) {
            $errors[] = "Kategori '{$data['kategori']}' tidak ditemukan di database";
        }

        // Optional fields validation
        if (!empty($data['sub_kategori']) && !isset($subcategories[$data['sub_kategori']])) {
            $errors[] = "Sub Kategori '{$data['sub_kategori']}' tidak ditemukan di database";
        }

        if (!empty($data['sub_sub_kategori']) && !isset($subSubcategories[$data['sub_sub_kategori']])) {
            $errors[] = "Sub-Sub Kategori '{$data['sub_sub_kategori']}' tidak ditemukan di database";
        }

        // Numeric validation
        if (!empty($data['harga_produk']) && !is_numeric($data['harga_produk'])) {
            $errors[] = 'Harga harus berupa angka';
        }

        if (empty($data['stok_produk'])) {
            $errors[] = 'Stok wajib diisi';
        } elseif (!is_numeric($data['stok_produk']) || $data['stok_produk'] < 0) {
            $errors[] = 'Stok harus berupa angka dan tidak boleh negatif';
        }

        if (empty($data['berat_produk'])) {
            $errors[] = 'Berat wajib diisi';
        } elseif (!is_numeric($data['berat_produk']) || $data['berat_produk'] < 0) {
            $errors[] = 'Berat harus berupa angka dan tidak boleh negatif';
        }

        if (empty($data['deskripsi_produk'])) {
            $errors[] = 'Spesifikasi Produk wajib diisi';
        }

        // Image validation
        if (!empty($data['gambar_produk'])) {
            if (!in_array($data['gambar_produk'], $uploadedImages)) {
                $imageErrors[] = "Gambar '{$data['gambar_produk']}' tidak ditemukan di folder upload. Upload gambar terlebih dahulu atau periksa nama file.";
            }
        }

        // Warnings
        if (empty($data['sku_produk'])) {
            $warnings[] = 'SKU kosong, akan digenerate otomatis';
        }

        if (empty($data['gambar_produk'])) {
            $warnings[] = 'Gambar Produk kosong, produk akan dibuat tanpa gambar';
        }

        return ['errors' => $errors, 'warnings' => $warnings, 'image_errors' => $imageErrors];
    }

    private function createProduct($data, $brands, $categories, $subcategories, $subSubcategories)
    {
        $productData = [
            'nama_produk' => $data['nama_produk'],
            'id_brand' => $brands[$data['brand']],
            'id_kategori' => $categories[$data['kategori']],
            'id_subkategori' => !empty($data['sub_kategori']) ? ($subcategories[$data['sub_kategori']] ?? null) : null,
            'id_sub_subkategori' => !empty($data['sub_sub_kategori']) ? ($subSubcategories[$data['sub_sub_kategori']] ?? null) : null,
            'sku_produk' => !empty($data['sku_produk']) ? $data['sku_produk'] : $this->generateSKU($data['nama_produk']),
            'tipe_produk' => $data['tipe_produk'],
            'asal_produk' => $data['asal_produk'],
            'dimensi_produk' => $data['dimensi_produk'],
            'harga_produk' => !empty($data['harga_produk']) ? floatval($data['harga_produk']) : null,
            'stok_produk' => intval($data['stok_produk']),
            'berat_produk' => floatval($data['berat_produk']),
            'deskripsi_produk' => $data['deskripsi_produk'],
            'status_produk' => 'aktif',
        ];

        $product = Produk::create($productData);

        // Handle image if provided
        if (!empty($data['gambar_produk'])) {
            $this->handleProductImage($product, $data['gambar_produk']);
        }

        return $product;
    }

    private function generateSKU($productName)
    {
        $base = Str::upper(Str::slug($productName, ''));
        $sku = $base . '-' . rand(1000, 9999);
        
        // Ensure unique SKU
        while (Produk::where('sku_produk', $sku)->exists()) {
            $sku = $base . '-' . rand(1000, 9999);
        }
        
        return $sku;
    }

    private function handleProductImage($product, $imageName)
    {
        // Image will be moved from temp to permanent folder after successful import
        // So we just create the record with the final path
        $finalPath = 'images/produk/' . $imageName;
        
        ProductImage::create([
            'id_produk' => $product->id_produk,
            'image_path' => $finalPath,
            'sort_order' => 0,
            'is_primary' => true
        ]);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getWarnings()
    {
        return $this->warnings;
    }

    public function getImageErrors()
    {
        return $this->imageErrors;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getValidImages()
    {
        return $this->validImages;
    }
}
