<script>
    $(document).ready( function() {
  $("#printPdf").click(function(){

        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        data = document.getElementById('main_div').innerHTML;
        // Done but error 414 request url is too larg solved by changing get to post

        $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
        url: "/pdf",
        type: 'post',
        // dataType: "json",
        data: { 'data':data },
        xhrFields: { responseType: 'blob' },
        success: function(response, status, xhr) {
            // https://github.com/barryvdh/laravel-dompdf/issues/404

            // console.log(response);
            // var filename = "" ;
            // var disposition = xhr.getResponseHeader('Content-Disposition');
            // if (disposition) {
            //     var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
            //     var matches = filenameRegex.exec(disposition);
            //     if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
            // }
            // var blob = new Blob([response], { type: 'application/octet-stream' });
            // var URL = window.URL || window.webkitURL;
            // var downloadUrl = URL.createObjectURL(blob);
            // var a = document.createElement("a");
            // a.href = downloadUrl;
            // // a.setAttribute('href', );
            // a.download = filename;
            // document.body.appendChild(a);
            // a.target = "_blank";
            // a.click();


            var filename = "";
            var disposition = xhr.getResponseHeader('Content-Disposition');

             if (disposition) {
                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var matches = filenameRegex.exec(disposition);
                if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
            }
            var linkelem = document.createElement('a');
            try {
                var blob = new Blob([response], { type: 'application/octet-stream' });

                if (typeof window.navigator.msSaveBlob !== 'undefined') {
                    //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                    window.navigator.msSaveBlob(blob, filename);
                } else {
                    var URL = window.URL || window.webkitURL;
                    var downloadUrl = URL.createObjectURL(blob);

                    if (filename) {
                        // use HTML5 a[download] attribute to specify filename
                        var a = document.createElement("a");

                        // safari doesn't support this yet
                        if (typeof a.download === 'undefined') {
                            window.location = downloadUrl;
                        } else {
                            a.href = downloadUrl;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.target = "_blank";
                            a.click();
                        }
                    } else {
                        window.location = downloadUrl;
                    }
                }

            } catch (ex) {
                console.log(ex);
            }

        },error: function (xhr, status, error)
           { console.log(xhr.responseText); },
        });
      });
   })
</script>