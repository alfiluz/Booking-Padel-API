<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\order;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = order::select('id', 'field_id', 'user_id', 'date', 'quantity', 'end_time', 'start_time', 'total_price')->get();

        return response()->json([
            'status' => 'Success',
            'message' => 'Berhasil index order',
            'data' => $order
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'field_id' => 'required|exists:fields,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        //Hitung quantity
        $start = strtotime($request->start_time);
        $end = strtotime($request->end_time);
        $quantity = ($end - $start) / 3600;

        if ($quantity <= 0) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Waktu tidak valid',
            ], 400);
        }

        $field = Field::find($request->field_id);
        if (!$field) {
            return response()->json([
                'status' => 'error',
                'message' => 'Field tidak ditemukan',
            ], 404);
        }

        // order yang sudah dipesan di jam yang sama
        $booking = order::where('field_id', $request->field_id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->exists();

        if ($booking) {
            return response()->json([
                'status' => 'error',
                'message' => 'Waktu sudah dibooking oleh pengguna lain!',
            ], 409);
        }

        // totalan harga
        $total_price = $quantity * $field->price;

        $order = new order();
        $order->field_id = $request->field_id;
        $order->user_id = Auth::user()->id;
        $order->date = $request->date;
        $order->start_time = $request->start_time;
        $order->end_time = $request->end_time;
        $order->quantity = $quantity;
        $order->total_price = $total_price;
        $order->status = 'pending';

        $order->save();


        return response()->json([
            'status' => 'Success',
            'message' => 'Order Berhasil disimpan!',
            'data' => $order
        ], 201);
    }
}
