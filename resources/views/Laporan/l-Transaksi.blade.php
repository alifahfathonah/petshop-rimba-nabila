<style type="text/css">
       @page {
           margin: 0px;
       }
       body {
           margin: 0px;
       }
       * {
           font-family: Verdana, Arial, sans-serif;
       }
       a {
           color: #fff;
           text-decoration: none;
       }
       table {
           font-size: x-small;
       }
       tfoot tr td {
           font-weight: bold;
           font-size: x-small;
       }
       .invoice table {
           margin: 15px;
       }
       .invoice h3 {
           margin-left: 15px;
       }
       .information {
           background-color:rgba(37, 65, 210, 0.75) !important;
           color: #FFF;
       }
       .information .logo {
           margin: 5px;
       }
       .information table {
           padding: 10px;
       }
   </style>
<body>
  <div class="information">
    <table>
      <tr>
           <td align="center" style="width: 40%;">
               <h1>Laporan Transaksi</h1>
               <pre>
                 Tanggal : {{$filawal}} - {{$filakhir}}
              </pre>
           </td>
           <td></td>
           <td align="right" style="width: 40%;">

                <h3>Rimba Petshop</h3>
                <pre>


                    Jl. Dr. Setiabudi No.64, Pamulang Timur, Pamulang,
                    Kota Tangerang Selatan, Banten 15417

                </pre>
            </td>
    </table>
  </div>
<div class="invoice">


  <table width="100%" border="1">
    <thead>
      <tr>


      <td>Kode Transaksi</td>
      <td>Status</td>
      <td>Tanggal Pemesanan</td>
      <td>Total Pembelian</td>
      </tr>
    </thead>



      @foreach ($getTrans as $repo)


      <tr>
        <td>{{$repo->kd_trans}}</td>
        <td>{{$repo->status}}</td>
        <td>{{date('d-m-Y', strtotime($repo->created_at))}}</td>
            <td>Rp.{{$repo->grand_biaya}}</td>
      </tr>
      @endforeach
      <tr>
        <td></td>
        <td>Jumlah Pemasukan</td>
        <td></td>
        <td>Rp.{{ $getTrans->sum('grand_biaya')}}</td>
      </tr>
  </table>

</div>
</body>
