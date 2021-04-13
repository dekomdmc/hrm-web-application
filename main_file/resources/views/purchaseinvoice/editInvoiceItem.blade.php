<form>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="">Item</label>
            <input type="text" class="form-control" value="{{ $purchase_invoice_product->item }}"/>
        </div>
        <div class="form-group col-md-6">
            <label for="">Price</label>
            <input type="text" class="form-control" value="{{ $purchase_invoice_product->price }}"/>
        </div>
        <div class="form-group col-md-6">
            <label for="">Quantity</label>
            <input type="text" class="form-control" value="{{ $purchase_invoice_product->quantity }}"/>
        </div>
        <div class="form-group col-md-6">
            <label for="">Discount</label>
            <input type="text" class="form-control" value="{{ $purchase_invoice_product->discount }}"/>
        </div>
    </div>
</form>
