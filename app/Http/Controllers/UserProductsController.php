<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProducts;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);

        $user_products = [];
        $data = $user->products()->get();
        foreach ($data as $product) {
            $user_products[] = ["id" => $product->id, "name" => $product->product->name];
        }
        return Inertia::render('UserProducts', [
            'user_products' => $user_products,
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
    public function show(UserProducts $userProducts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserProducts $userProducts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserProducts $userProducts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProducts $userProducts)
    {
        //
    }
}
