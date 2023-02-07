document.addEventListener('DOMContentLoaded', () => {
  
  const stars = document.querySelectorAll(".fa-star"); 
  let currentStars = document.querySelector(".invisible");
  
  let check = false;

  stars.forEach(star => {
    star.addEventListener('mouseover', selectStars);
    star.addEventListener('mouseleave', unselectStars);
    star.addEventListener('click', activeSelect);
  })

  function selectStars(e) {
    const data = e.target;
    const etoiles = previousSiblings(data);
    if(!check) {
      etoiles.forEach(etoile => {
        etoile.classList.add('checked');
      })
    }
  }

  function unselectStars(e) {
    const data = e.target;
    const etoiles = previousSiblings(data);
    if(!check) {
      etoiles.forEach(etoile => {
        etoile.classList.remove('checked');
      })
    }
  }

  function activeSelect(e) {
    check = true;
    
    currentStars.value = e.target.getAttribute("data-star");
    
    // console.log(currentStars.value);
   }

  function previousSiblings(data) {
    let values = [data];
    
    while (data = data.previousSibling) {
      if(data.nodeName === 'I') {
        values.push(data);
      }
    }

    return values;
  }
});