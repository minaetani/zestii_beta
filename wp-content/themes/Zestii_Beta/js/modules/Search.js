import axios from "axios"

//  jQUeryのライブラリを使用する場合には初めに以上のラインを記述

class Search {
 // 1.オブジェクトを作成 -  constructor　オブジェクトのプロパティ設定 this.events();を最後に付け加えることで、場面がきたらすぐmethodsが起動するように設定。 
 constructor() {
    this.addSearchHTML();
    this.resultsDiv = document.querySelector("#search-overlay__results");
    this.openButton = document.querySelectorAll(".js-search-trigger");
    this.closeButton = document.querySelector(".search-overlay__close");
    this.searchOverlay = document.querySelector(".search-overlay");
    this.searchField = document.querySelector("#search-term");
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.typingTimer;
    this.events();
    }

// 2. オブジェクトを起動する場面設定 - event
events(){
    this.openButton.forEach(el => {
        el.addEventListener("click", e => {
          e.preventDefault()
          this.openOverlay()
        })
      })
  
      this.closeButton.addEventListener("click", () => this.closeOverlay())
      document.addEventListener("keydown", e => this.keyPressDispatcher(e))
      this.searchField.addEventListener("keyup", () => this.typingLogic())
    }
  

// 3. 何をするか(function, actionなど) - methods
typingLogic(){
    if (this.searchField.value != this.previousValue) {
        clearTimeout(this.typingTimer)
  
        if (this.searchField.value) {
          if (!this.isSpinnerVisible) {
            this.resultsDiv.innerHTML = '<div class="spinner-loader"></div>';
            this.isSpinnerVisible = true;
          }
          this.typingTimer = setTimeout(this.getResults.bind(this), 750);
        } else {
          this.resultsDiv.innerHTML = "";
          this.isSpinnerVisible = false;
        }
      }
  
      this.previousValue = this.searchField.value
    }

/*$.getJSONはふたつのargumentをとる。ひとつ目はqueryを送るURL、ふたつ目はサーバーのresponseを受けて行うアクション。JSの中に入れるhtmlは
｀backtick｀で囲んだtemplate literalの中に入れる。phpのコードは中に入らないので、jsに置き換える${results.xxx.length}　？　は条件分岐
で、"もし該当する検索結果がある場合には"の意。その後のxは条件に当てはまる場合のアクション、：yはelseのアクション。呼び出して表示するデータは
.の後ろに呼応するJSONのデータtypeを入力する。　*/

async getResults() {
     try {
        const response = await axios.get(zestiiData.root_url + "/wp-json/zestii/v1/search?term=" + this.searchField.value) 
        const results = response.data
        this.resultsDiv.innerHTML = `
        <div class="row">
        <div class="one-third">
         <h2 class="search-overlay__section-title">General Information</h2>
            ${results.fromBlogsAndPages.length ? '<ul class="link-list min-list">' : "<p>No results matched that search.</p>"}
             ${results.fromBlogsAndPages.length.map(item => `<li><a href="${item.permalink}">${item.title}</a> ${item.postType == "post" ? `by ${item.authorName}` : ""}</li>`).join("")}
            ${results.fromBlogsAndPages.length ? "</ul>" : ""} 
        </div>

        <div class="one-third">
            <h2 class="search-overlay__section-title">Areas</h2>
            ${results.areas.length ? '<ul class="link-list min-list">' : `<p>No results matched that search.<a href="${zestiiData.root_url}/areas">View all areas</a></p>`}
            ${results.areas.length.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join("")}
            ${results.areas.length ? "</ul>" : ""} 

           
            <h2 class="search-overlay__section-title">Locations</h2>
            ${results.locations.length ? '<ul class="link-list min-list">' : `<p>No results matched that search.<a href="${zestiiData.root_url}/locations">View all locations</a></p>`}
            ${results.locations.length.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join("")}
            ${results.locations.length ? "</ul>" : ""}   
        </div>

        <div class="one-third">
            <h2 class="search-overlay__section-title">Cooks</h2>
                ${results.cooks.length ? '<ul class="professor-cards">' : `<p>No results matched that search.</p>`}
                ${results.cooks
                .map(
                item => `
                <li　class="professor-card__list-item">
                <a class="professor-card" href="${item.permalink}">
                <img class="professor-card__image" src="${item.image}">
                <span class="professor-card__name">${item.title}</span>
                </a></li>
                `
                )
                .join("")}
                ${results.cooks.length ? "</ul>" : ""} 
            
            <h2 class="search-overlay__section-title">Events</h2>
            ${results.events.length ? "" : `<p>No results matched that search.<a href="${zestiiData.root_url}/events">View all events</a></p>`}
            ${results.events
                .map(
                item => `
                <div class="event-summary">
                <a class="event-summary__date t-center" href="${item.permalink}">
                <span class="event-summary__month">${item.month}</span>
                <span class="event-summary__day">${item.day}</span>
                </a>
                <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                <p>${item.description}<a href ="${item.permalink}" class="nu gray">Learn more</a></p>
                </div>
                </div>
                `).join("")}
        </div>
    </div>
        `
        this.isSpinnerVisible = false;
        } catch (e) {
            console.log(e)

    } 
}

/*下記のコードは、postsとpagesのポストタイプに対して検索クエリを送り、帰ってきた結果をふたつまとめて表示するという内容  。
         when-then構文　whenで指定したアクションを行ってからthenで指定したアクションを行う（）内のパラメーターはそれぞれ順番通りに呼応する　aをやったらoneをやり、bをやったらtwoをやる　$.when(a,b).then((one, two)
        
         $.when(
            $.getJSON(zestiiData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val()),
            $.getJSON(zestiiData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val())
            ).then((posts,pages)=> {
            var combinedResults = posts[0].concat(pages[0]);
            this.resultsDiv.html(`
            <h2 class="search-overlay__section-title">General Information</h2>
           　 ${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No results available</p>'}
              ${combinedResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a>${item.type == 'post' ? ` by ${item.authorName}`: ''}</li>`).join("")}
           ${combinedResults.length ? '</ul>' : ''} 
           `);
           this.isSpinnerVisible = false;
         },()=>{
             this.resultsDiv.html('<p>Unexpected error; please try again.</p>')
         });  
          */


keyPressDispatcher(e){
    if(e.keyCode == 83 && !this.isOverlayOpen && document.activeElement.tagName != "INPUT" && document.activeElement.tagName != "TEXTAREA") {
        this.openOverlay();
    }

    if(e.keyCode == 27 && this.isOverlayOpen){
        this.closeOverlay();
    }
}

openOverlay(){
    this.searchOverlay.classList.add("search-overlay--active");
    document.body.classList.add("body-no-scroll");
    this.searchField.value = "";
    setTimeout(() => this.searchField.focus(),301);
    console.log("our open method just ran!")
    this.isOverlayOpen = true ;
    return false;
}

closeOverlay(){
    this.searchOverlay.classList.remove("search-overlay--active");
    document.body.classList.remove("body-no-scroll");
    console.log("our close method just ran!")
    this.isOverlayOpen = false ;
}

addSearchHTML(){
    document.body.insertAdjacentHTML( 
    "beforeend",
    `
    <div class="search-overlay">
     <div class="search-overlay__top">
      <div class="container">
      <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
      <input type="text" class="search-term" placeholder="What do you like to eat?" id="search-term" autocomplete="off">
      <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
      </div>
    </div>
  
    <div class="container">
        <div id="search-overlay__results"></div>
      </div>
    </div>
      `
      );
    }

}   

export default Search;
