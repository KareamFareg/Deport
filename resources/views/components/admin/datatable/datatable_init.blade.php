<!-- <script src="{{ asset('assets/admin/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> -->
<!-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" type="text/javascript"></script> -->
<!-- <script src="{{ asset('assets/admin/js/demo1/pages/crud/datatables/advanced/multiple-controls.js') }}" type="text/javascript"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-colvis-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/datatables.min.js">
</script>

<script>
    $(document).ready(function() {
        var table = $('#kt_table_1').DataTable({
            dom: 'fBptipr', // pBfrtip    Blfrtip
            // buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ]
            'ordering': false,
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'excel'
                },
                {
                    extend: 'csv'
                },
                {
                    extend: 'print'
                },
                {
                    text: 'pdf',
                    action: function() {

                        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        data = document.getElementById("kt_table_1").innerHTML;
                        // Done but error 414 request url is too larg solved by changing get to post

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });
                        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: "{{ url('/') }}/pdf",
                            type: 'post',
                            // dataType: "json",
                            data: {
                                'data': data
                            },
                            xhrFields: {
                                responseType: 'blob'
                            },
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
                                var disposition = xhr.getResponseHeader(
                                    'Content-Disposition');

                                if (disposition) {
                                    var filenameRegex =
                                        /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                    var matches = filenameRegex.exec(disposition);
                                    if (matches !== null && matches[1]) filename =
                                        matches[1].replace(/['"]/g, '');
                                }
                                var linkelem = document.createElement('a');
                                try {
                                    var blob = new Blob([response], {
                                        type: 'application/octet-stream'
                                    });

                                    if (typeof window.navigator.msSaveBlob !==
                                        'undefined') {
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

                            },
                            error: function(xhr, status, error) {
                                console.log(xhr.responseText);
                            },
                        });
                    }
                }
            ]
        });



        deleteWord = "Delete";
        $('#kt_table_1 tbody').on('click', 'tr', function() {
            $(this).toggleClass('selected');

            if (table.rows('.selected').data().length > 0) {
                $('#delete').removeClass('btn btn-outline-danger');
                $('#delete').addClass('btn btn-danger btn-elevate');
                $('#delete').text(deleteWord + ' : ' + table.rows('.selected').data().length);
            } else {
                $('#delete').removeClass('btn btn-danger btn-elevate');
                $('#delete').addClass('btn btn-outline-danger');
                $('#delete').text(deleteWord);
            }
        });



    });

</script>
