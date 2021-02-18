import $ from 'jquery';

class Like {    
    constructor(){
        this.events();
    }

    events() {
     $(".like-box").on("click", this.ourClickDispatcher.bind(this));
    }

    //methods come here. (e) stands for event
    ourClickDispatcher(e){
        var currentLikeBox = $(e.target).closest(".like-box");

        if (currentLikeBox.attr('data-exists') == 'yes') {
            this.deleteLike(currentLikeBox);
        } else {
            this.createLike(currentLikeBox);
        }
    }

 //　⇩　likeboxをクリックしたときにlike-routeで設定したrouteのどちらかにデータを送るという動作を指定

    createLike(currentLikeBox){
        $.ajax({
    //jqueryのajaxツールを起動し、{}にjsのobjectとそのプロパティを与える。property 'type’はhttpリクエストタイプ、success/errorにはリクエストが受け付けられた/受け付けられなかった場合の挙動をfunctionで指定。dataプロパティはjsオブジェクトを{}内に指定、cookIDというデータが、どのオブジェクトとイコールかをコロンの後で指定。この際、ワードプレスを使っている場合には中に入るデータはurlの後ろに"コロン前のワード？コロン後のワード"と入力するのと同意義。ここで指定したデータをlike-routeのcreateLikeの中に落とし込む
            beforeSend: xhr => {
                xhr.setRequestHeader('X-WP-Nonce', zestiiData.nonce);
            },
            url: zestiiData.root_url　+ '/wp-json/zestii/v1/manageLike',
            type: 'POST',
            data: {'cookId': currentLikeBox.data('cooks')},
            success: (response)=> {
                currentLikeBox.attr('data-exists', 'yes');
                var likeCount = parseInt(currentLikeBox.find(".like-count").html(),10);
                likeCount++;
                currentLikeBox.find(".like-count").html(likeCount);
                currentLikeBox.attr("data-like", response);
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }

    deleteLike(currentLikeBox){
        $.ajax({
            beforeSend: xhr => {
                xhr.setRequestHeader('X-WP-Nonce', zestiiData.nonce);
            },
            url: zestiiData.root_url　+ '/wp-json/zestii/v1/manageLike',
            data: {'like': currentLikeBox.attr('data-like')},
            type: 'DELETE',
            success: (response)=> {
                currentLikeBox.attr('data-exists', 'no');
                var likeCount = parseInt(currentLikeBox.find(".like-count").html(),10);
                likeCount--;
                currentLikeBox.find(".like-count").html(likeCount);
                currentLikeBox.attr("data-like", "");
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }
}

export default Like;