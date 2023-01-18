var app = {
  init: function () {

    const deleteFriend = document.querySelector(".delete-friend");
    const header = document.querySelector("header");

    const inputSearch = document.querySelector(".add-group input");
    const addFriend = document.querySelector(".add-friend");

    // Supprime un ami à l'événement
    deleteFriend.addEventListener("click", function (e) {

      e.preventDefault();

      var data = this;

      fetch(data.getAttribute("href"))
        .then(function (res) {
          console.log(res);
          if (res.status == 200) {
            console.log("Votre ami a été supprimé de l'événement");
            data.parentElement.remove();

            let div = document.createElement('div');

            div.classList.add("alert");
            div.classList.add("alert-FLASH_SUCCESS");
            div.innerHTML = "Votre ami a été supprimé de l'événement";
            header.after(div);


          } else {
            console.log("une erreur est survenue");
          }


        })


        .catch(error => console.log("Erreur : " + error));
    })

    // Ajoute un ami à l'événement
    addFriend.addEventListener("click", function (e) {

      e.preventDefault();

      var data = this;

      fetch(data.getAttribute("href"))
        .then(function (res) {
          console.log(res);
          if (res.status == 200) {
            console.log("Votre ami a été ajouté à l'événement");
            data.parentElement.remove();

            let div = document.createElement('div');

            div.classList.add("alert");
            div.classList.add("alert-FLASH_SUCCESS");
            div.innerHTML = "Votre ami a été ajouté à l'événement";
            header.after(div);


          } else {
            console.log("une erreur est survenue");
          }


        })


        .catch(error => console.log("Erreur : " + error));
    })

  }
};


document.addEventListener('DOMContentLoaded', app.init);