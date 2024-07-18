<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PaypalTokens;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $invoices = $user->invoices()->orderBy('created_at', 'desc')->orderBy('paid')->get();

        $invoicesformat = [];
        foreach ($invoices as $invoice) {
            $due_date = Carbon::parse($invoice->due_date)->startOfDay();
            $now = Carbon::now()->startOfDay();
            $days_until_due = $now->diffInDays($due_date);
            $invoice_color = "";

            if($invoice->paid == 0) {
                if($days_until_due <= 0) {
                    $invoice_color = "bg-red-600";
                }
                else if($days_until_due <= 7) {
                    $invoice_color = "bg-yellow-500";
                }
                else {
                    $invoice_color = "bg-green-500";
                }
            } else {
                $invoice_color = "bg-gray-800";
            }

            $invoicesformat[] = ["id" => $invoice->id, "due_date" => $invoice->due_date->format('j.n.Y'), "invoice_uuid," => $invoice->uuid, "price" => $invoice->price, "color" => $invoice_color, 'paid' => $invoice->paid];
        }

        return Inertia::render('Invoices', [
            'invoices' => $invoicesformat,
        ]);
    }

    public function pay(Request $request)
    {
        $invoice = Invoice::findOrFail($request->post('invoice'));
        $json = json_decode($this->paypalRedirect($invoice), true);

        return Inertia::location($json["url"]);
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
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function success(Request $request)
    {
        if (!isset($request->token)) {
            return redirect()->route('invoices')->with([
                'message' => 'Maksu epäonnistui',
                'status' => 'failed'
            ]);
        } else {
            $token = PaypalTokens::where('paypal_token', $request->token)->firstOrFail();
            $response = Http::withBasicAuth(env("PAYPAL_CLIENT_ID"), env("PAYPAL_CLIENT_SECRET"))
                ->get("https://api-m.sandbox.paypal.com/v2/checkout/orders/" . $token->paypal_token . "/");

            $respj = json_decode($response->body(), true);
            if ($respj["status"] == "APPROVED") {
                $headers = [
                    'Content-Type' => 'application/json',
                ];
                $response2 = Http::withBasicAuth(env("PAYPAL_CLIENT_ID"), env("PAYPAL_CLIENT_SECRET"))->withHeaders($headers)
                    ->post("https://api-m.sandbox.paypal.com/v2/checkout/orders/" . $token->paypal_token . "/capture", ['json' => []])->json();

                if($response2["status"] == "COMPLETED"){
                    $invoice = $token->invoice;
                    $invoice->paid = 1;
                    $invoice->paid_at = Carbon::now()->toDateTimeString();
                    $invoice->save();

                    $token->delete();

                    $invoice_uuid = str()->random(8);
                    Invoice::create(['product_id' => $invoice->product_id, 'due_date' => Carbon::now()->addMonths(1)->toDateTimeString(), 'user_id' => $invoice->user_id, 'payment_method' => 'paypal', 'price' => $invoice->price, 'paid' => 0, 'paid_at' => null, 'uuid' => $invoice_uuid]);

                    return redirect()->route('invoices')->with([
                        'message' => 'Lasku maksettu onnistuneesti',
                        'status' => 'success'
                    ]);

                }
            } else {
                return redirect()->route('invoices')->with([
                    'message' => 'Maksu epäonnistui',
                    'status' => 'failed'
                ]);
            }
        }
    }

    public function paypalRedirect($invoice)
    {

        $redirdata = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => $invoice->price,
                        "custom_id" => $invoice->uuid,
                        "invoice_id" => $invoice->uuid,
                    ]
                ]
            ],
            "payment_source" => [
                "paypal" => [
                    "experience_context" => [
                        "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
                        "locale" => "en-US",
                        "landing_page" => "LOGIN",
                        "shipping_preference" => "NO_SHIPPING",
                        "user_action" => "PAY_NOW",
                        "return_url" => env("APP_URL") . "/invoice/success",
                        "cancel_url" => env("APP_URL") . "/invoice/cancel",
                    ]
                ]
            ]
        ];

        $response = Http::withBasicAuth(env("PAYPAL_CLIENT_ID"), env("PAYPAL_CLIENT_SECRET"))
            ->post("https://api-m.sandbox.paypal.com/v2/checkout/orders", $redirdata);

        $respj = json_decode($response->body(), true);
        $resplink = end($respj["links"]);
        PaypalTokens::create(['invoice_id' => $invoice->id, 'paypal_token' => $respj["id"]]);
        if ($resplink["rel"] == "payer-action") {
            return json_encode(['url' => $resplink["href"]], true);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
}
