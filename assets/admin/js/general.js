$(document).ready(function(){
$(document).on('click','#update_image',function(e){
    e.preventDefault();
    if(!$("#photo").length){ 
 $("#update_image").hide();
$("#cancel_update_image").show();
  $("#oldimage").html('<br><input type="file" onchange="readURL(this)"  name="photo" id="photo" > ');

    }
return false;
});

$(document).on('click','#cancel_update_image',function(e){
    e.preventDefault();
  
 $("#update_image").show();
$("#cancel_update_image").hide();
  $("#oldimage").html('');

 
return false;
});

$(document).on('click','.are_you_shue',function(e){
var res =confirm("هل انت متأكد ؟");
if(!res)
{
  return false;
}
});



});

var url = window.location;
// for sidebar menu but not for treeview submenu
$('ul.sidebar-menu a').filter(function() {
    return this.href == url;
}).parent().siblings().removeClass('active').end().addClass('active');
// for treeview which is like a submenu
$('ul.treeview-menu a').filter(function() {
    return this.href == url;
}).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active menu-open').end().addClass('active menu-open');

function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
          $('#uploadedimg').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
  }
}