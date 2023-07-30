<script>
  function printContent(dv,title,options = null) {

    data = document.getElementById(dv);
    var printWindow = window.open('', 'my div', 'height=500,width=500');
    printWindow.document.write('<html><head><title>'+title+'</title>');
    printWindow.document.write('</head><body style="direction: rtl;">');
    printWindow.document.write(data.innerHTML);
    printWindow.document.write('</body></html>');

    printWindow.print();
    //printWindow.close();

  };
</script>
