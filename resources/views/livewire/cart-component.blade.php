<div>
  <style>
    .image-product{
      width: 80px;
      height: 80px;
      object-fit: cover;
    }

    @media only screen and (max-width: 600px) {
      .image-product{
        width: 60px;
        height: 60px;
        object-fit: cover;
      }
    }
  </style>

  <section class="breadcrumb-section set-bg mb-3">{{-- data-setbg="{{ asset('banner/banner.png') }}" --}}
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="breadcrumb__text">
            <h2 class="text-dark">Your Cart <i class="fa fa-shopping-bag"></i></h2>
            <span class="text-dark">Shopping Cart</span>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="shoping__cart__table">
          <table>
            <thead>
              <tr>
                <th class="shoping__product">Products</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($products as $product)
                <tr>
                  <td class="shoping__cart__item">
                    <a href="{{ route('product.detail', ['product_id' => $product->id]) }}">
                      <img src="{{ asset('storage/' . colName('pr') . $product->image->image) }}" alt="" class="image-product">
                      <span style="color: black">{{ $product->name }}</span>
                    </a>
                  </td>
                  <td>
                    {{ currency_IDR($product->regular_price) }}
                  </td>
                  <td class="shoping__cart__quantity">
                    <div class="quantity">
                      <div class="pro-qty">
                        <a href="javascript:void(0)" class="dec qtybtn">-</a>
                        <input type="text" value="{{ $product->qty }}">
                        <a href="javascript:void(0)" class="inc qtybtn">+</a>
                      </div>
                    </div>
                  </td>
                  <td>
                    {{ currency_IDR($product->regular_price * $product->qty) }}
                  </td>
                  <td class="shoping__cart__item__close">
                    <span wire:click='deleteProduct({{ $product->id }})' class="icon_close"></span>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center">
                    No Product In Cart
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="shoping__cart__btns">
          <a href="{{ route('shop') }}" class="primary-btn">CONTINUE SHOPPING</a>
        </div>
        <div class="shoping__continue">
          <div class="shoping__discount">
            <h5 class="mb-2">Discount Codes: </h5>
            <form action="#">
              <input type="text" placeholder="Enter your coupon code">
              <button type="submit" class="site-btn">APPLY COUPON</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="shoping__checkout">
          <h5>Cart Total</h5>
          <ul>
            <li class="none">Subtotal <span>{{ currency_IDR($subTotal) }}</span></li>
            <li class="need">PPN 5&#37; <span>{{ currency_IDR($ppn) }}</span></li>
            <li class="need">Total <span class="text-danger">{{ currency_IDR($total) }}</span></li>
          </ul>
          <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
        </div>
      </div>
    </div>
  </div>
</div>