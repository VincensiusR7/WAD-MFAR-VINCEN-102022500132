<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'asc')->get();

        return view('products.index', compact('products'));
    }

    public function manage()
    {
        $products = Product::orderBy('id', 'desc')->get();

        return view('products.manage', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_condition' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:255',
            'likes' => 'nullable|integer|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $validated['size'] = $validated['size'] ?? '-';
        $validated['image'] = $validated['image'] ?? '';
        $validated['likes'] = $validated['likes'] ?? 0;

        Product::create($validated);

        return redirect()
            ->route('products.manage')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_condition' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:255',
            'likes' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()
            ->route('products.manage')
            ->with('success', 'Produk dan stok berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('products.manage')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
