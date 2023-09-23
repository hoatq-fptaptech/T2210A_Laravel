@extends("layouts.app")
@section("main")
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code
                </h6>
            </div>
        </div>
        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form action="#">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="checkout__input">
                            <p>Full Name<span>*</span></p>
                            <input name="full_name" type="text">
                        </div>
                        <div class="checkout__input">
                            <p>Address<span>*</span></p>
                            <input name="address" type="text" placeholder="Street Address" class="checkout__input__add">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Telephone<span>*</span></p>
                                    <input name="tel" type="tel">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input name="email" type="email">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input__checkbox">
                            <p>Shipping method<span>*</span></p>
                            <label for="acc">
                                Express
                                <input name="shipping_method" value="Express" type="checkbox" id="acc">
                                <span class="checkmark"></span>
                            </label>
                            <br/>
                            <label for="free">
                                Free Shipping
                                <input name="shipping_method" value="free_shipping" type="checkbox" id="free">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul>
                                @foreach($cart as $item)
                                    <li>{{$item->name}} (x{{$item->buy_qty}})<span>${{$item->price * $item->buy_qty}}</span></li>
                                @endforeach
                            </ul>
                            <div class="checkout__order__subtotal">Subtotal <span>${{$subtotal}}</span></div>
                            <div class="checkout__order__subtotal">VAT <span>10%</span></div>
                            <div class="checkout__order__total">Total <span>${{$total}}</span></div>

                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    COD
                                    <input name="payment_medhot" value="COD" type="checkbox" id="payment">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input name="payment_medhot" value="Paypal" type="checkbox" id="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
