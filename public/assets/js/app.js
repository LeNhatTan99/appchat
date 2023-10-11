
//  show file img when choose file
 
 function myfunction() {
   const inputImg = document.getElementById("inputImg");
   const previewContainer = document.getElementById("imgPreview");
   const previewImg = previewContainer.querySelector(".img-preview-img");
   const previewText = previewContainer.querySelector(".img-preview-text");
   const previewImgEdit = previewContainer.querySelector(".img-preview-edit");
   inputImg.addEventListener("change", function () {
     const file = this.files[0];
     if (file) {
       const reader = new FileReader();
       previewText.style.display = "none";
       previewImg.style.display = "block";
       reader.addEventListener("load", function () {
       previewImg.setAttribute("src", this.result);
       });
       reader.readAsDataURL(file);
     } else {
       previewText.style.display = null;
       previewImg.style.display = null;
     }
   })

}

// show preview when create or edit product
function getInput() {
    var valSku = document.querySelector(".value-sku");
    var valName = document.querySelector(".value-name");
    var valPrice = document.querySelector(".value-price");
    var valStock = document.querySelector(".value-stock");
    var valExp = document.querySelector(".value-exp");
    var showImg = document.querySelector(".show-img");
    var file    = document.querySelector('input[type=file]').files[0];
    var reader  = new FileReader();

    document.getElementById('show-sku').innerText = valSku.value;
    document.getElementById('show-name').innerText = valName.value;
    document.getElementById('show-price').innerText = valPrice.value;
    document.getElementById('show-stock').innerText = valStock.value;
    document.getElementById('show-exp').innerText = valExp.value;     
    reader.onloadend = function () {
        showImg.setAttribute("src", this.result);
    }
    if (file) {
     reader.readAsDataURL(file);
        }
}

// Delete record by ajax

$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
function deleteRecord(id, url) {
  $.ajax({
        url:'products/'+id,
       type: 'DELETE',
       dataType: 'JSON',
       data: {
         id
       },
       success: function(response)
       {
         if(response) {
           var message = response.success;
           location.reload();
           Swal.fire({
             icon: 'success',
             title: message,
            });
         } else {
          Swal.fire({
            icon: 'error',
              title: 'error',
          });
         }
       }
     })
}

