<script>
var modalConfirm = function(callback){
  // $("#btn-confirm").on("click", function(){
  //   $("#mi-modal").modal('show');
  // });

  $("#modal-btn-si").on("click", function(){
    callback(true);
    $("#confirem-modal").modal('hide');
  });

  $("#modal-btn-no").on("click", function(){
    callback(false);
    $("#confirem-modal").modal('hide');
  });
};
</script>
