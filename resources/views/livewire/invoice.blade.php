<div>
    <div class="row">
        <div class="col-md-12 card">
            <div class="card-body">
                <form wire:submit.prevent="saveInvoice">
                    <div class="row mb-3">
                        <label for="customer" class="col-sm-2 col-form-label">Customer:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="customer"
                                wire:model='state.customer'>
                            @error('state.customer')
                                <p class="text-danger text-start">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="product" class="col-sm-2 col-form-label">Name Product:</label>
                        <div class="col-sm-10">
                            <select id="product" class="form-control" wire:model='state.product'>
                                <option value="">Select</option>
                                @forelse ($products as $product)
                                    <option value="{{ $product->Product_ID }}">{{ $product->Product_Name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('state.product')
                                <p class="text-danger text-start">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="rate" class="col-sm-2 col-form-label">Rate:</label>
                        <div class="col-sm-10">
                            <p class="text-start">{{ $state['rate'] }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="unit" class="col-sm-2 col-form-label">Unit:</label>
                        <div class="col-sm-10">
                            <p class="text-start">{{ $state['unit'] }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="qty" class="col-sm-2 col-form-label">Qty:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="qty" wire:model='state.qty'>
                            @error('state.qty')
                                <p class="text-danger text-start">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="discount" class="col-sm-2 col-form-label">Discount (%):</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="discount" wire:model='state.discount'>
                            @error('state.discount')
                                <p class="text-danger text-start">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="net_amount" class="col-sm-2 col-form-label">Net Amount:</label>
                        <div class="col-sm-10">
                            <p class="text-start">{{ $state['net_amount'] }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="total_amount" class="col-sm-2 col-form-label">Total Amount:</label>
                        <div class="col-sm-10">
                            <p class="text-start">{{ $state['total_amount'] }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="offset-sm-2 col-sm-2">
                            <button class="btn btn-success"><i class="fa-solid fa-plus mr-3"></i>Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if(count($selectedProducts) > 0)
        <form wire:submit.prevent='submitInvoiceData'>
            <div class="col-md-12 card mt-3">
                <div class="card-body">
                    <h3 class="text-center">Selected Products</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Rate</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Disc%</th>
                                <th scope="col">Net Amount.</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($selectedProducts as $key => $selectedProduct)
                                    <tr>
                                    <th scope="row">
                                        <select class="form-control" wire:model="selectedProducts.{{$key}}.product">
                                            @forelse ($products as $product)
                                                <option value="{{ $product->Product_ID }}">{{ $product->Product_Name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error("selectedProducts.$key.product")
                                            <p class="text-danger text-start">{{ $message }}</p>
                                        @enderror
                                    </th>
                                    <th scope="row">{{ $selectedProduct['rate'] }}</th>
                                    <th scope="row">{{ $selectedProduct['unit'] }}</th>
                                    <th scope="row">
                                        <input type="text" class="form-control" wire:model="selectedProducts.{{$key}}.qty">
                                        @error("selectedProducts.$key.qty")
                                            <p class="text-danger text-start">{{ $message }}</p>
                                        @enderror
                                    </th>
                                    <th scope="row">
                                        <input type="text" class="form-control" wire:model="selectedProducts.{{$key}}.discount">
                                        @error("selectedProducts.$key.discount")
                                            <p class="text-danger text-start">{{ $message }}</p>
                                        @enderror
                                    </th>
                                    <th scope="row">{{ $selectedProduct['net_amount'] }}</th>
                                    <th scope="row">{{ $selectedProduct['total_amount'] }}</th>
                                    <th scope="row"><button type="button" class="btn btn-danger" wire:click="removeProduct({{ $key }})"><i class="fa fa-trash"></i></button></th>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endif
    </div>
</div>
