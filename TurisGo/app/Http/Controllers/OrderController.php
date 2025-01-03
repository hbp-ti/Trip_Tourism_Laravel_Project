<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use PDF;

class OrderController extends Controller
{
    public function getOrderDetail(Request $request)
    {

        $locale = $request->route('locale');

        if (!Auth::check()) {
            return redirect()->route('auth.login.form', ['locale' => $locale])->with('error', 'Not Authorized');
        }

        
    }

    public function downloadOrder(Request $request, $id)
    {
        // Buscar o pedido (order) pelo ID
        $order = Order::with('orderItems')->findOrFail($id);

        // Dados para o PDF
        $data = [
            'order' => $order,
            'date' => now()->format('d-m-Y'),
        ];

        // Gerar PDF usando a view 'invoice'
        $pdf = PDF::loadView('components/pdfInvoice', $data);

        // Retornar o PDF para download
        return $pdf->download("invoice_order_{$id}.pdf");
    }
}
