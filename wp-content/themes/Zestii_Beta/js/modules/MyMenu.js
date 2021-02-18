import axios from "axios";

class MyMenu{
  constructor() {
  if (document.querySelector("#my-notes")) {
    axios.defaults.headers.common["X-WP-Nonce"] = zestiiData.nonce
    this.myMenu = document.querySelector("#my-notes")
    this.events()
  }
}

  events() {
    this.myMenu.addEventListener("click", e => this.clickHandler(e))
    document.querySelector(".submit-note").addEventListener("click", () => this.createMenu())
  }

  clickHandler(e) {
    if (e.target.classList.contains("delete-note") || e.target.classList.contains("fa-trash-o")) this.deleteMenu(e)
    if (e.target.classList.contains("edit-note") || e.target.classList.contains("fa-pencil") || e.target.classList.contains("fa-times")) this.editMenu(e)
    if (e.target.classList.contains("update-note") || e.target.classList.contains("fa-arrow-right")) this.updatedMenu(e)
  }

  findNearestParentLi(el) {
    let thisMenu = el
    while (thisMenu.tagName != "LI") {
      thisMenu = thisMenu.parentElement
    }
    return thisMenu
  }

 /*通常サーバーにhttpのGETリクエストを送る場合にはjqueryの.getJSONが使える。
 .ajaxを使うと、どこにどの種類のリクエストを送るかを指定できる urlで送り先を指定、
 typeでリクエストの種類を指定、successとerrorでそれぞの場合のアクションを指定*/
     
    editMenu(e) {  
      const thisMenu = this.findNearestParentLi(e.target)


       if(thisMenu.getAttribute("data-state") == "editable") {
        this.makeMenuReadOnly(thisMenu);
       } else {
        this.makeMenuEditable(thisMenu);
       }
     }
     
     makeMenuEditable(thisMenu){
        thisMenu.querySelector(".edit-note").innerHTML ='<i class="fa fa-times" aria-hidden="true"></i> Cancel';
        thisMenu.querySelector(".note-title-field").removeAttribute("readonly")
        thisMenu.querySelector(".note-body-field").removeAttribute("readonly")
        thisMenu.querySelector(".note-title-field").classList.add("note-active-field")
        thisMenu.querySelector(".note-body-field").classList.add("note-active-field")
        thisMenu.querySelector(".update-note").classList.add("update-note--visible")
        thisMenu.setAttribute("data-state", "editable")
     }

     makeMenuReadOnly(thisMenu){
      thisMenu.querySelector(".edit-note").innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i> Edit'
      thisMenu.querySelector(".note-title-field").setAttribute("readonly", "true")
      thisMenu.querySelector(".note-body-field").setAttribute("readonly", "true")
      thisMenu.querySelector(".note-title-field").classList.remove("note-active-field")
      thisMenu.querySelector(".note-body-field").classList.remove("note-active-field")
      thisMenu.querySelector(".update-note").classList.remove("update-note--visible")
      thisMenu.setAttribute("data-state", "cancel")
  }

    async deleteMenu(e) {
      const thisMenu = this.findNearestParentLi(e.target)

      try {
        const response = await axios.delete(zestiiData.root_url + "/wp-json/wp/v2/menu/" + thisMenu.getAttribute("data-id"))
        thisMenu.style.height = `${thisMenu.offsetHeight}px`
        setTimeout(function () {
          thisMenu.classList.add("fade-out")
        }, 20)
        setTimeout(function () {
          thisMenu.remove()
        }, 401)
        if (response.data.userMenuCount < 5) {
          document.querySelector(".note-limit-message").classList.remove("active")
        }
      } catch (e) {
        console.log("Sorry")
      }
    }

  async updatedMenu(e) {
    const thisMenu = this.findNearestParentLi(e.target)

    var updatedMenu = {
      "title": thisMenu.querySelector(".note-title-field").value,
      "content": thisMenu.querySelector(".note-body-field").value
    }

    try {
      const response = await axios.post(zestiiData.root_url + "/wp-json/wp/v2/menu/" + thisMenu.getAttribute("data-id"), updatedMenu)
      this.makeMenuReadOnly(thisMenu)
    } catch (e) {
      console.log("Sorry")
    }
  }

  async createMenu() {
        var newMenu = {
            'title': document.querySelector(".new-note-title").value,
            'content': document.querySelector(".new-note-body").value,
            'status': 'publish'
        }

        try {
          const response = await axios.post(zestiiData.root_url + "/wp-json/wp/v2/menu/", newMenu)
    
          if (response.data != "You have reached your post limit.") {
            document.querySelector(".new-note-title").value = ""
            document.querySelector(".new-note-body").value = ""
            document.querySelector("#my-notes").insertAdjacentHTML(
              "afterbegin",
              ` <li data-id="${response.data.id}" class="fade-in-calc">
                <input readonly class="note-title-field" value="${response.data.title.raw}">
                <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                <textarea readonly class="note-body-field">${response.data.content.raw}</textarea>
                <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
              </li>`
            )
    
            // notice in the above HTML for the new <li> I gave it a class of fade-in-calc which will make it invisible temporarily so we can count its natural height
    
            let finalHeight // browser needs a specific height to transition to, you can't transition to 'auto' height
            let newlyCreated = document.querySelector("#my-notes li")
    
            // give the browser 30 milliseconds to have the invisible element added to the DOM before moving on
            setTimeout(function () {
              finalHeight = `${newlyCreated.offsetHeight}px`
              newlyCreated.style.height = "0px"
            }, 30)
    
            // give the browser another 20 milliseconds to count the height of the invisible element before moving on
            setTimeout(function () {
              newlyCreated.classList.remove("fade-in-calc")
              newlyCreated.style.height = finalHeight
            }, 50)
    
            // wait the duration of the CSS transition before removing the hardcoded calculated height from the element so that our design is responsive once again
            setTimeout(function () {
              newlyCreated.style.removeProperty("height")
            }, 450)
          } else {
            document.querySelector(".note-limit-message").classList.add("active")
          }
        } catch (e) {
          console.error(e)
        }
      }
    }  

export default MyMenu;