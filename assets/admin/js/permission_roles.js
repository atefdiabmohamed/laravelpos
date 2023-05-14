$(document).ready(function() {



      $(document).on('click', '.load_add_permission_roles_sub_menu', function(e) {
    
        var id=$(this).data('id');
          var token_search = $("#token_search").val();
          var ajax_url = $("#ajax_search_load_add_permission_roles_sub_menu").val();
  
          jQuery.ajax({
              url: ajax_url,
              type: 'post',
              dataType: 'html',
              cache: false,
              data: {
                  id: id,
                  "_token": token_search
              },
              success: function(data) {
           
              $("#load_add_permission_roles_sub_menuModalBody").html(data);
              $("#load_add_permission_roles_sub_menuModal").modal("show");
              $('.select2').select2({
                theme: 'bootstrap4'
              });  
            
              },
              error: function() {
                  alert("لم تتم الاضافة من فضلك حاول مرة أخري !");
              }
          });
      });


      $(document).on('click', '.load_add_permission_roles_sub_menues_actions', function(e) {
    
        var id=$(this).data('id');
          var token_search = $("#token_search").val();
          var ajax_url = $("#ajax_search_load_add_permission_roles_sub_menues_actions").val();
  
          jQuery.ajax({
              url: ajax_url,
              type: 'post',
              dataType: 'html',
              cache: false,
              data: {
                  id: id,
                  "_token": token_search
              },
              success: function(data) {
           
              $("#load_add_permission_roles_sub_menues_actionsModalBody").html(data);
              $("#load_add_permission_roles_sub_menues_actionsModal").modal("show");
              $('.select2').select2({
                theme: 'bootstrap4'
              });  
            
              },
              error: function() {
                  alert("لم تتم الاضافة من فضلك حاول مرة أخري !");
              }
          });
      });


});