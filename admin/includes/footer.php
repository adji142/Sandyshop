
<footer class="text-center" id="footer">&copy; Copyright 2018 AIS System, Created By : AIS System</footer>

<script type="text/javascript">

  function updateSizes(){
      var sizeString = '';
      for (var i=1;i<12;i++) {
        if ($('#size'+i).val() != '') {
          sizeString += $('#size'+i).val()+':'+$('#qty'+i).val()+':'+$('#threshold'+i).val()+',';
        }
      }
      $('#sizes').val(sizeString);
    }

  function get_child_options(selected){
    if(typeof selected === 'undefined'){
      var selected = '';
    }

    var parentID = $('#parent').val();
    $.ajax({
      url: '/SandyShop/admin/parsers/child_categories.php',
      type: 'POST',
      data: {parentID : parentID, selected : selected},
      success: function(data){
        $('#child').html(data);
      },
      error: function(){alert("Maaf tunggu sebentar, Terjadi kesalahan.")},
    });
  }
  function CloseModal() {
    $('#kirim').modal('toggle');
  }
  function OpenModal(idorder) {
    $('#id_orders').val(idorder);
    $('#kirim').modal('show');
  }
  function Kirim() {
    var id = $('#id_orders').val();
    var noresi = $('#resi').val();
    $.ajax({
      url : "/SandyShop/admin/parsers/update_orders.php",
      method : "POST",
      data : {id:id,noresi:noresi},
      success : function(){
        location.reload();
      },
      error : function(){alert('Sepertinya ada kesalahan!');}
    });
  }
  // function Proses_hajar_data() {
  //   var tglawal = $('#tglawal').val();
  //   var tglakhir = $('#tglakhir').val();
  //   loaddatalaporan(tglawal,tglakhir);
  // }
  // function loaddatalaporan(tglawal,tglakhir) {
  //   $.ajax({
  //     type    :'post',
  //     url     : 'parsers/laporanpenjualan.php',
  //     data    : {tglawal,tglakhir},
  //     dataType: 'json',
  //     success : function (response) {
  //       var html = '';
  //       var i;
  //       for (i = 0; i < response.data.length; i++) {
  //         var number = i+1;
  //         html += '<tr>' +
  //                   '<td>' + parseInt(number) +'</td>' +
  //                   '<td>' + response.data[i].tgl_order+'</td>' +
  //                   '<td>' + response.data[i].nama_lengkap + '</td>' +
  //                   '<td>' + response.data[i].Email + '</td>' +
  //                   '<td>' + response.data[i].id_produk + '</td>' +
  //                   '<td>' + response.data[i].nama_produk + '</td>' +
  //                   '<td>' + formatNumber(response.data[i].Qty) + '</td>' +
  //                   '<td>' + formatNumber(response.data[i].Harga) + '</td>' +
  //                   '<td>' + formatNumber(response.data[i].Total) + '</td>' +
  //                 '<tr>';
  //       }
  //       $('#load_data').html(html);
  //     }
  //   });
  // }
  // function formatNumber(num) {
  //   return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
  // }
  $('select[name="parent"]').change(function(){
    get_child_options();
  });
</script>

</body>
</html>
