function load(){

  document.getElementById("categoryImage").addEventListener('change', function(event){

    var tmppath = URL.createObjectURL(event.target.files[0]);
    $("img").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
  });
}


document.addEventListener('DOMContentLoaded', load);
