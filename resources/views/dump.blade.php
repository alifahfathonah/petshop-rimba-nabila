<div class="input-group number-spinner text-cart">
  <span class="input-group-btn">
    <button class="btn btn-default no-radius" data-dir="dwn"><span class="fa fa-minus">-</span></button>
  </span>
  <input type="text" name="jumlah" class="form-control numbers noAdults text-center w-25 text-cart" value="" readonly>
  <span class="input-group-btn">
    <form class="" action="/dump" method="post">
      @csrf
      <button class="btn btn-default no-radius" data-dir="up"><span class="fa fa-plus">plus</span></button>
    </form>
  </span>
</div>
