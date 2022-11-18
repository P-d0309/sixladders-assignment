<?php

namespace App\Http\Livewire;

use App\Models\Invoice as ModelsInvoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Invoice extends Component
{
    public $products;
    public $selectedProducts = [];
    public $preSeletedProductID = null;
    public $totalFinalAmount = 0;
    public $stateData = [
        'customer' => null,
        'rate' => 0,
        'qty' => 0,
        'discount' => 0,
        'product' => null,
        'unit' => 0,
        "net_amount" => 0,
        "total_amount" => 0,
    ];
    public $state = [];

    protected $validationAttributes = [
        'state.customer' => 'Customer',
        'state.product' => 'Product',
        'state.qty' => 'Quantity',
        'state.discount' => 'Discount',
    ];

    public $rules = [
        "state.customer" => 'required',
        "state.discount" => 'required|numeric|min:0|max:100',
        "state.product" => 'required',
        "state.unit" => 'required|numeric|integer|min:1',
        "state.qty" => 'required|numeric|integer|min:1',
    ];

    public function mount() {
        $this->setInitialState();
        $this->products = Product::all();
    }

    public function updated() {
        if($this->state['product']) {
            $selectedProduct = $this->products->filter(function($value, $key){
                return $value->Product_ID === (int) $this->state['product'];
            })->first();

            // Set rate and unit of the product

            $this->state['rate'] = $selectedProduct->Rate;
            $this->state['unit'] = $selectedProduct->Unit;

            // Apply discount on the  product and calculate the net amount

            if($this->state['discount']) {
                $this->validate([
                    "state.discount" => 'required|numeric|min:0|max:100',
                ]);
                $discountAmount = $this->calculateDiscountAmount($this->state);
                $this->state['net_amount'] = $this->state['rate'] - $discountAmount;
            } else {
                $this->state['net_amount'] = $this->state['rate'];
            }

            $this->validate([
                "state.qty" => 'required|integer|min:1',
            ]);

            // Calculate the total amount

            if($this->state['qty']) {
                $this->state['total_amount'] = $this->calculateTotalAmount($this->state);
            } else {
                $this->state['total_amount'] = 0;
            }
        }

        // Update the products which are already selected

        if(count($this->selectedProducts) > 0) {
            $this->updatePreselectedProducts();
        }
    }
    public function render()
    {
        return view('livewire.invoice');
    }

    public function saveInvoice() {
        $this->validate();

        $this->selectedProducts[] = $this->state;
        $this->setInitialState();
    }

    private function updatePreselectedProducts() {
        foreach($this->selectedProducts as $key => $product) {
            $this->preSeletedProductID = $product['product'];

            // Get the selected product details

            $selectedProduct = $this->products->filter(function($value, $key){
                return $value->Product_ID === (int) $this->preSeletedProductID;
            }, $product)->first();

            // Set rate and unit of the product

            $validatedData = $this->validate(
                [
                    "selectedProducts.$key.customer" => 'required',
                    "selectedProducts.$key.discount" => 'required|numeric|min:0|max:100',
                    "selectedProducts.$key.product" => 'required',
                    "selectedProducts.$key.unit" => 'required|numeric|integer|min:1',
                    "selectedProducts.$key.qty" => 'required|numeric|integer|min:1',
                    "selectedProducts.$key.rate" => "required"
                ],
                [],
                [
                    "selectedProducts.$key.customer" => "Customer",
                    "selectedProducts.$key.product" => "Product",
                    "selectedProducts.$key.qty" => "Quantity",
                    "selectedProducts.$key.discount" => "Discount",
                ]
            );

            $this->selectedProducts[$key]['rate'] = $selectedProduct->Rate;
            $this->selectedProducts[$key]['unit'] = $selectedProduct->Unit;

            // Apply discount on the  product and calculate the net amount

            if($this->selectedProducts[$key]['discount'] && is_numeric($this->selectedProducts[$key]['discount']) && $this->selectedProducts[$key]['discount'] > 0) {
                $discountAmount = $this->calculateDiscountAmount($this->selectedProducts[$key]);

                $this->selectedProducts[$key]['net_amount'] = $this->selectedProducts[$key]['rate'] - $discountAmount;
            } else {
                $this->selectedProducts[$key]['net_amount'] = $this->selectedProducts[$key]['rate'];
            }

            // Calculate the total amount

            if($this->selectedProducts[$key]['qty'] && is_numeric($this->selectedProducts[$key]['qty']) && $this->selectedProducts[$key]['qty'] > 0) {
                $this->selectedProducts[$key]['total_amount'] = $this->calculateTotalAmount($this->selectedProducts[$key]);
            } else {
                $this->selectedProducts[$key]['total_amount'] = 0;
            }
        }
    }

    private function setInitialState() {
        $this->state = $this->stateData;
    }

    private function calculateDiscountAmount($data) {
        return $data['rate']*$data['discount']/100;
    }

    private function calculateTotalAmount($data) {
        return $data['net_amount']*$data['qty'];
    }

    public function removeProduct($productKey) {
        $products = $this->selectedProducts;
        unset($products[$productKey]);
        $this->selectedProducts = array_values($products);
    }

    public function submitInvoiceData() {
        foreach($this->selectedProducts as $key => $product) {
            $validatedData = $this->validate(
                [
                    "selectedProducts.$key.customer" => 'required',
                    "selectedProducts.$key.discount" => 'required|numeric|min:0|max:100',
                    "selectedProducts.$key.product" => 'required',
                    "selectedProducts.$key.unit" => 'required|numeric|integer|min:1',
                    "selectedProducts.$key.qty" => 'required|numeric|integer|min:1',
                    "selectedProducts.$key.rate" => "required"
                ],
                [],
                [
                    "selectedProducts.$key.customer" => "Customer",
                    "selectedProducts.$key.product" => "Product",
                    "selectedProducts.$key.qty" => "Quantity",
                    "selectedProducts.$key.discount" => "Discount",
                ]
            );

            $this->totalFinalAmount = $this->totalFinalAmount + $product['total_amount'];
        }

        $InvoiceNo = 1000;

        $lastInvoice = ModelsInvoice::latest('Invoice_Id')->first();
        if($lastInvoice) {
            $InvoiceNo = $lastInvoice->Invoice_no + 1;
        }

        $invoice = new ModelsInvoice;
        $invoice->Invoice_no = $InvoiceNo;
        $invoice->Invoice_Date = Carbon::now();
        $invoice->CustomerName = $this->selectedProducts[0]['customer'];
        $invoice->TotalAmount = $this->totalFinalAmount;
        $invoice->save();

        foreach($this->selectedProducts as $key => $product) {
            $invoiceDetail = new InvoiceDetail;
            $invoiceDetail->Invoice_Id = $invoice->Invoice_Id;
            $invoiceDetail->Product_Id = (int)$product['product'];
            $invoiceDetail->Rate = $product['rate'];
            $invoiceDetail->Unit = $product['unit'];
            $invoiceDetail->Qty = (int)$product['qty'];
            $invoiceDetail->Disc_Percentage = (float)$product['discount'];
            $invoiceDetail->NetAmount = $product['net_amount'];
            $invoiceDetail->TotalAmount = $product['total_amount'];
            $invoiceDetail->save();
        }
        Session::flash('message.level', 'success');
        Session::flash('message.content', 'Invoice addeed sucessfully');

        return redirect()->route('invoices');
    }
}
