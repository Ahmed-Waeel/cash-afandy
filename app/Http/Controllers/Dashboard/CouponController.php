<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Client;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\Representative;
use Illuminate\Http\Request;
use Redot\Http\Controllers\Controller;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.coupons.create', [
            'clients' => Client::query(),
            'countries' => Country::query(),
            'representatives' => Representative::query(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $coupon = Coupon::create($validated);
        $coupon->countries()->attach($validated['countries']);

        return $this->created(__('Coupon'), 'dashboard.coupons.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('dashboard.coupons.edit', [
            'coupon' => $coupon,
            'clients' => Client::query(),
            'countries' => Country::query(),
            'representatives' => Representative::query(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validated = $this->validated($request, $coupon);

        $coupon->update($validated);
        $coupon->countries()->sync($validated['countries']);

        return $this->updated(__('Coupon'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return $this->deleted(__('Coupon'));
    }

    /**
     * Validate the request for storing/updating a coupon.
     */
    protected function validated(Request $request, ?Coupon $coupon = null): array
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon?->id,
            'client_id' => 'required|exists:clients,id',
            'representative_id' => 'required|exists:representatives,id',
            'countries' => 'required|array',
            'countries.*' => 'exists:countries,id',
            'description' => 'nullable|array',
            'description.*' => 'nullable|string',
            'tips' => 'nullable|array',
            'tips.*' => 'nullable|string',
            'fixed_discount' => 'nullable|boolean',
            'discount' => 'required|numeric|min:0|max:100',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_amount' => 'nullable|numeric|min:0',
            'minimum_usages' => 'nullable|integer|min:0',
            'maximum_usages' => 'nullable|integer|min:0',
            'launch_date' => 'required|date',
            'expiration_date' => 'nullable|date|after:launch_date',
            'active' => 'nullable|boolean',
        ]);

        $validated['fixed_discount'] = $request->boolean('fixed_discount');
        $validated['active'] = $request->boolean('active');

        return $validated;
    }
}
