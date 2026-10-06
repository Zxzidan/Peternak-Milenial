<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Region;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarketplaceController extends Controller
{
    /**
     * Display marketplace catalog, active orders, and filters.
     */
    public function index(Request $request): View
    {
        $categories = ProductCategory::all();
        $regions = Region::orderBy('name')->get();

        $query = Product::with(['category', 'region', 'seller'])
            ->where('status', 'active');

        // Filter: Kategori
        if ($request->filled('kategori')) {
            $catSlug = $request->kategori;
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug)->orWhere('id', $catSlug);
            });
        }

        // Filter: Wilayah
        if ($request->filled('wilayah')) {
            $query->where('region_id', $request->wilayah);
        }

        // Search: Keyword
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort
        if ($request->sort === 'termurah') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'termahal') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->get();

        // Orders list
        $orders = Order::with(['items.product', 'buyer'])
            ->latest()
            ->take(10)
            ->get();

        return view('marketplace', [
            'products' => $products,
            'categories' => $categories,
            'regions' => $regions,
            'orders' => $orders,
            'selectedCategory' => $request->kategori,
            'selectedRegion' => $request->wilayah,
            'selectedSort' => $request->sort,
            'searchQuery' => $request->q,
        ]);
    }

    /**
     * Store a new product into the marketplace.
     */
    public function storeProduct(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'price' => ['required', 'numeric', 'min:100'],
            'stock' => ['required', 'integer', 'min:1'],
            'unit' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $seller = auth()->user() ?? User::where('role', 'peternak')->first() ?? User::first();
        $slug = Str::slug($validated['name']).'-'.time();

        $product = Product::create([
            'user_id' => $seller->id,
            'product_category_id' => $validated['product_category_id'],
            'region_id' => $validated['region_id'] ?? Region::first()?->id,
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? 'Produk peternakan terverifikasi langsung dari peternak Jawa Timur.',
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'unit' => $validated['unit'],
            'is_verified' => true,
            'status' => 'active',
        ]);

        return redirect()->route('marketplace')
            ->with('success', "Produk '{$product->name}' berhasil ditambahkan ke katalog marketplace!");
    }

    /**
     * Create an order when a buyer clicks "Beli".
     */
    public function buyProduct(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$product->stock],
            'buyer_name' => ['required', 'string', 'max:255'],
            'buyer_phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $qty = $validated['quantity'];
        $buyer = auth()->user() ?? User::first();
        $total = $product->price * $qty;

        $orderCode = '#ORD-'.date('ymd').'-'.rand(100, 999);

        $order = Order::create([
            'order_code' => $orderCode,
            'buyer_id' => $buyer->id,
            'total_amount' => $total,
            'status' => 'processing',
            'shipping_address' => $validated['shipping_address'].', Kontak: '.$validated['buyer_name'],
            'buyer_phone' => $validated['buyer_phone'],
            'notes' => $validated['notes'] ?? 'Pesanan via Marketplace Peternak Milenial',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'seller_id' => $product->user_id,
            'quantity' => $qty,
            'price_per_unit' => $product->price,
            'subtotal' => $total,
        ]);

        // Decrement stock
        $product->decrement('stock', $qty);

        $formattedTotal = 'Rp '.number_format($total, 0, ',', '.');

        return redirect()->route('marketplace')
            ->with('success', "Pesanan {$orderCode} ({$qty} {$product->unit} {$product->name}) berhasil dibuat! Total: {$formattedTotal}. Status: Diproses.");
    }

    /**
     * Update order status (Process / Complete / Cancel).
     */
    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,processing,shipped,completed,cancelled'],
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->route('marketplace')
            ->with('success', "Status pesanan {$order->order_code} berhasil diperbarui menjadi {$validated['status']}!");
    }

    /**
     * Delete product.
     */
    public function destroyProduct(Product $product): RedirectResponse
    {
        $name = $product->name;
        $product->delete();

        return redirect()->route('marketplace')
            ->with('success', "Produk '{$name}' berhasil dihapus dari marketplace.");
    }
}
