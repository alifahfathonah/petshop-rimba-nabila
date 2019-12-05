    @foreach ($produks as $produk)
      {{$produk}}

          @endforeach
  <form class="" action="/" method="post">
    @csrf

      <input type="hidden" name="kBrg" value="">



      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
      <button  class="btn btn-success btn-sm">Tambahkan ke Keranjang</button>


  </form>
