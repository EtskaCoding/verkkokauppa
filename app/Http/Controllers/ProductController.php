<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\UserProducts;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\InvoiceController;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return Inertia::render('Dashboard', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return Inertia::render('Products/Order', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function order(Request $request)
    {
        $product = Product::findOrFail($request->post('product'));
        $user_id = Auth::id();

        $user_product = UserProducts::create(['product_id' => $product->id, 'user_id' => $user_id]);

        $invoice_uuid = str()->random(8);
        $invoice = Invoice::create(['product_id' => $user_product->id, 'due_date' => Carbon::now()->toDateTimeString(), 'user_id' => $user_id, 'payment_method' => 'paypal', 'price' => $product->price, 'paid' => 0, 'paid_at' => null, 'uuid' => $invoice_uuid]);

        $invoiceController = new InvoiceController();
        $json = json_decode($invoiceController->paypalRedirect($invoice), true);

        return Inertia::location($json["url"]);
    }

}
