<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrentDateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'hello world';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function test(Request $request)
    {
        logger()->info(sprintf('user: %s, coupon: %s', request()->input('user'), request()->input('coupon')));
        \Modules\Coupon\Job\SendCoupon::dispatch(request()->input('user'), request()->input('coupon'));

        return response()->json([
            'code' => 200,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
