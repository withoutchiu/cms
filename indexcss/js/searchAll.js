function fetchCategories(searchAll) {
    //Fetching the provincial id using this url below
    fetch("../cms/search.php?query=" + searchAll)
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
      fetch("../cms/searchItem.php?query=" + searchAll)
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
