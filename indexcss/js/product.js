function fetchCategories(search) {
    //Fetching the provincial id using this url below
    fetch("../cms/search.php?query=" + search)
      //then() to register a callback to handle fulfilled promises. This callback will be called once the promise has fulfilled. We can chain .then()s together to link together a series of async tasks.
      .then(function(result){ // Promise for parsed JSON.
        return result.json();
      }).then(function(response){ //// Executed when promised JSON is ready.
        //{success: true, message: "Found 20 cities.", cities: Array(20)}
        //CHECK IF SUCCESS
        if(response['success']){
          console.log("YOU ARE IN SUCCESS");
          addCategories(response['categories']);
        }
        if(!response['categories']){
          console.log("not success");
          event.target.select();
        }
      });
}

function addCategories(categories){
  var img = new Image();
  console.log(categories.length);
  if(categories.length >= 1){
    document.getElementById('myTableTbody').removeChild(document.getElementById('myTableTbody').firstChild);
    $('.img-portfolio').remove();
    $("#myTable").show();
    for(var i = 0; i < categories.length; i++){
    var tbody = document.getElementById('myTableTbody');
    var tr = document.createElement('tr');
    var primary = document.createElement('td');
    var cross = document.createElement('td');
    var boundaries = document.createElement('td');
    var direction = document.createElement('td');
    var tag = document.createElement('td');
    var aTag = document.createElement('a');
    aTag.setAttribute('href',"items.php?id=" + categories[i]['categoryId']);
    aTag.innerText = "Go to category";
    var image = new Image(250,250);
    image.src = categories[i]['categoryImage'];
    primary.appendChild(document.createTextNode(categories[i]['categoryTitle']));
    cross.appendChild(document.createTextNode(categories[i]['categoryPlainDescription']));
    boundaries.appendChild(image);
    direction.appendChild(document.createTextNode(new Date(categories[i]['createdDate'])));
    tag.appendChild(aTag);

    tr.appendChild(primary);
    tr.appendChild(cross);
    tr.appendChild(boundaries);
    tr.appendChild(direction);
    tr.appendChild(tag)

    tbody.appendChild(tr);
    }
  }else{
    alert("No Records Found.");
  }
}

function onBlur(input){
      console.log(input.value);
      fetchCategories(input.value);
}
function load(){
$("#myTable").hide();
}
document.addEventListener('DOMContentLoaded', load);
