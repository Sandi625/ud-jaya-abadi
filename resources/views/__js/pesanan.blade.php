
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#id_pesanan').change(function() {
      var pesananId = $(this).val();

      if (pesananId) {
        $.ajax({
          url: 'http://127.0.0.1:8000/api/guides-by-kriteria/3/' + pesananId,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            var guideSelect = $('#id_guide');
            guideSelect.empty();
            guideSelect.append('<option value="">-- Pilih Guide --</option>');

            if (response.status && response.data.length > 0) {
              $.each(response.data, function(index, guide) {
                var kriteriaUnggulText = guide.kriteria_unggulan ? guide.kriteria_unggulan : 'Belum Dinilai';
                guideSelect.append('<option value="' + guide.id + '">' + guide.nama_guide + ' - ' + kriteriaUnggulText + '</option>');
              });
            } else {
              guideSelect.append('<option value="">Tidak ada guide untuk pesanan ini</option>');
            }
          },
          error: function() {
            alert('Gagal mengambil data guide dari API');
          }
        });
      } else {
        $('#id_guide').empty().append('<option value="">-- Pilih Guide --</option>');
      }
    });
  });
</script>

