window.addEventListener("load", (event) => {
    //Find all elm with class 
    let fadeElms = document.getElementsByClassName("fade-in-section");
    createObserver(fadeElms);
  }, false);
  
  

  //Observe Elm
  function createObserver(fadeElms) {
    let observer;

    let options = {
      root: null,
      rootMargin: "0px",
      threshold: 0.15
    };

    observer = new IntersectionObserver(handleIntersect, options);
    
    for (let i = 0; i < fadeElms.length; i++) {
        observer.observe(fadeElms[i]);
     }
    
  }
  
  
  function handleIntersect(entries, observer){
      
    entries.forEach((entry) => {
        console.log('yes');
        
        if(entry.isIntersecting){
            //Once shown un-watch to save reources
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
        }  
    });
  }
  