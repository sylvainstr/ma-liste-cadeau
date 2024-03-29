var app = {
  init: function () {

    const header = document.querySelector("header");
    const searchFriend = document.querySelector(".add-group input");
    const friendList = document.querySelector(".friend-list");
    const friendListEvent = document.querySelector(".list-friend-event ul");

    // Supprime un ami à l'événement
    document.querySelectorAll(".delete-friend").forEach(friend => deleteFunction(friend));

    // Recherche un ami
    searchFriend.addEventListener("input", function (e) {

      e.preventDefault();

      var data = this;
      var eventId = data.dataset.event;

      fetch(data.getAttribute("href") + data.value, {
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json'
          }
        })
        .then((response) => {
          return response.json();
        })
        .then(function (body) {

          friendList.innerHTML = "<ul>";
          body.forEach(element => {
            friendList.innerHTML += "<li><a class='add-friend-link' href='http://localhost/PHP-project/ma-liste-cadeau/public/evenements/" + eventId + "/amis/ajouter/" + element.id + "'>" + element.name + "</a></li>";
          });
          friendList.innerHTML += "</ul>";
        })


        .catch(error => console.log("Erreur : " + error));
    })

    // Ajoute un ami à l'événement
    document.addEventListener("click", function (e) {

      const target = e.target.closest(".add-friend-link");
      // Or any other selector.    
      if (target) {
        // Do something with `target`.   
        e.preventDefault();

        fetch(target.getAttribute("href"), {
            headers: {
              "Content-Type": "application/json; charset=UTF-8"
            }
          })
          .then(async function (res) {
            console.log('response');
            if (res.status == 200) {
              console.log("Votre ami a été ajouté à l'événement");

              let div = document.createElement('div');

              div.classList.add("alert");
              div.classList.add("alert-FLASH_SUCCESS");
              div.innerHTML = "Votre ami a été ajouté à l'événement";
              header.after(div);

              const data = await res.json();

              var eventId = searchFriend.dataset.event;

              var li = document.createElement("li");

              li.innerHTML = `<p>${data.name}</p><a class="delete-friend" href="http://localhost/PHP-project/ma-liste-cadeau/public/evenements/${eventId}/amis/supprimer/${data.id}"><img src="http://localhost/PHP-project/ma-liste-cadeau/public/assets/images/cross.png" alt="image d'une croix"></a>`;

              friendListEvent.prepend(li);
              document.querySelectorAll(".delete-friend").forEach(friend => deleteFunction(friend));

            } else if (res.status == 400) {

              const data = await res.text();
              throw data;

            } else {
              throw new Error("une erreur est survenue");
            }

          })


          .catch(function (error) {
            let div = document.createElement('div');

            div.classList.add("alert");
            div.classList.add("alert-FLASH_ERROR");
            div.innerHTML = error;
            header.after(div);
            console.log(error);
          });
      }

    })

  }
};

function deleteFunction(friend) {

  friend.addEventListener("click", function (e) {

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
          document.querySelector("header").after(div);
  
        } else {
          console.log("une erreur est survenue");
        }
      })
  
      .catch(error => console.log("Erreur : " + error));
  })

}

document.addEventListener('DOMContentLoaded', app.init);