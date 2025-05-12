<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Str; // Import Str untuk membuat slug

class ProductController extends Controller
{
    // Tampilkan semua produk dengan pencarian
    public function index(Request $request)
    {
        // Mendapatkan query pencarian
        $q = $request->get('q', ''); // Menangani parameter pencarian dengan default kosong

        // Mencari produk berdasarkan nama dan deskripsi jika ada pencarian
        $products = Product::when($q, function ($query, $q) {
            return $query->where('name', 'like', "%{$q}%")
                         ->orWhere('description', 'like', "%{$q}%");
        })->paginate(10); // Menampilkan hasil produk dengan pagination
        
        return view('dashboard.products.index', compact('products', 'q'));
    }

    // Tampilkan form tambah produk
    public function create()
    {
        $categories = Categories::all();
        return view('dashboard.products.create', compact('categories')); 
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        // Validasi input produk
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',  // Validasi URL untuk image_url
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validasi gambar upload
        ]);

        // Cek apakah ada file gambar diupload
        $imageUrl = null;
        if ($request->hasFile('image')) {
            // Jika ada gambar yang diupload
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName); // Menyimpan gambar di public/uploads
            $imageUrl = 'uploads/' . $imageName; // Menyimpan path gambar
        } else if ($request->filled('image_url')) {
            // Jika URL gambar diisi
            $imageUrl = $request->image_url;  // Menggunakan URL yang diinputkan
        }

        // Membuat slug dari nama produk
        $slug = Str::slug($request->name);

        // Membuat SKU produk
        $sku = 'SKU-' . strtoupper(Str::random(8));

        // Simpan produk baru dengan slug dan gambar URL
        Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'sku' => $sku,
            'price' => $request->price,
            'stock' => $request->stock,
            'product_category_id' => $request->product_category_id,
            'description' => $request->description,
            'image_url' => $imageUrl,  // Menyimpan URL gambar
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Tampilkan form edit produk
    public function edit(Product $product)
    {
        $categories = Categories::all();
        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    // Perbarui produk
    public function update(Request $request, Product $product)
    {
        // Validasi input produk
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validasi gambar
            'image_url' => 'nullable|url',  // Validasi URL gambar
        ]);

        // Jika nama produk berubah, update slug
        if ($product->name != $request->name) {
            $product->slug = Str::slug($request->name);
        }

        // Update gambar jika ada file baru diupload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $product->image_url = 'uploads/' . $imageName;  // Update URL gambar dengan gambar yang baru
        } else if ($request->filled('image_url')) {
            // Jika URL gambar diisi, update dengan URL yang baru
            $product->image_url = $request->image_url;
        }

        // Update produk dengan atribut yang diizinkan
        $product->update($request->only(['name', 'price', 'stock', 'description', 'slug']));

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    // Tampilkan detail produk
    public function show($id)
    {
        $product = Product::findOrFail($id);  // Mencari produk berdasarkan ID
        return view('dashboard.products.show', compact('product'));  // Mengirim data produk ke view
    }
}
