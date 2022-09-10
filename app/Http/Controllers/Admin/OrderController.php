<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class OrderController extends Controller
{

    public function index()
    {
        return Inertia::render('Admin/Orders/Index', [
            'filters' => Request::all('search'),
            'orders' => Order::query()
                ->filter(Request::only('search'))
                ->paginate(10)
                ->withQueryString()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreOrderRequest $request)
    {
        //
    }

    public function show(Order $order)
    {
        //
    }

    public function edit(Order $order)
    {
        //
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return Redirect::back()->with('success', 'Order deleted.');
    }

    public function restore(Order $order)
    {
        $order->restore();

        return Redirect::back()->with('success', 'Order restored.');
    }
}
