const videoId = new URL(window.location.href).searchParams.get('id');
const xmlHttp = new XMLHttpRequest();
const actionUrl = './library/Actions.php';
window.onload = function(){
    var bigBtn = document.querySelector('.vjs-big-play-button');
    var poster = document.querySelector('.vjs-poster');
    bigBtn.addEventListener('click',function(){
        videoStart();
    })
    poster.addEventListener('click',function(){
        videoStart();
    })
    var like = document.querySelector('.video-like');
    like.addEventListener('click',function(){
        likeVideo();
    });
    var dislike = document.querySelector('.video-dislike');
    dislike.addEventListener('click',function(){
        dislikeVideo();
    })
}

function videoStart(){
    if(videoId != null || videoId != ''){
        xmlHttp.open('POST',actionUrl);
        xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xmlHttp.send('action=pressedPlay&videoId='+videoId);
    }
}

function likeVideo(){
    if(videoId != null || videoId != ''){
        xmlHttp.onreadystatechange = function(){
            if(xmlHttp.readyState === 4){
                let count = xmlHttp.responseText.split(',');
                document.getElementsByClassName('video-like-count')[0].innerHTML = count[0];
                document.getElementsByClassName('video-dislike-count')[0].innerHTML = count[1];
            }
        }
        xmlHttp.open('POST',actionUrl);
        xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xmlHttp.send('action=like&videoId='+videoId);
    }
}

function dislikeVideo(){
    if(videoId != null || videoId != ''){
        xmlHttp.onreadystatechange = function(){
            if(xmlHttp.readyState === 4){
                let count = xmlHttp.responseText.split(',');
                document.getElementsByClassName('video-like-count')[0].innerHTML = count[0];
                document.getElementsByClassName('video-dislike-count')[0].innerHTML = count[1];
            }
        }
        xmlHttp.open('POST',actionUrl);
        xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xmlHttp.send('action=dislike&videoId='+videoId);
    }
}

var viewComments = document.getElementById('view-comments');
viewComments.addEventListener('click',function(){
    fetchComments();
})

var postBtn = document.getElementById('post-comment');
postBtn.addEventListener('click',function(){
    let comment = document.getElementById('comment-body');
    if(comment.value != '' && (videoId != null || videoId != '')){
        xmlHttp.onreadystatechange = function(){
            if(xmlHttp.readyState === 4){
                comment.value = '';
                fetchComments()
            }
        }
        xmlHttp.open('POST',actionUrl)
        xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xmlHttp.send('action=comment&video='+videoId+'&body='+comment.value);
    }
})
var addPlaylist = document.querySelector('.add-to-playlist');
if(addPlaylist){
    addPlaylist.addEventListener('click',function(){
        xmlHttp.onreadystatechange = function(){
            if(xmlHttp.responseText === 'added'){
                addPlaylist.remove();
            }
        }
        xmlHttp.open('POST',actionUrl);
        xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xmlHttp.send('action=addToPlaylist&video='+videoId);
    })
}

function fetchComments(){
    if(videoId != null || videoId != '' || viewComments != undefined){
        xmlHttp.onreadystatechange = function(){
            try {
                var div = '';
                var deleteComment;
                const result = JSON.parse(xmlHttp.response)
                if(result != ''){
                    for (let i = 0; i < result.length; i++) {
                        deleteComment = result[i].delete == 'yes' ? '<a href="javascript:" class="text text-danger" id="'+result[i].id+'" onclick="deleteComment(this)">Delete Comment</a>' : '';
                        div += '<div class="alert alert-primary mb-2"><div class="d-flex justify-content-between"><strong style="font-size:14px">'+result[i].name+'</strong><i style="font-size:12px">'+relativeTime(result[i].created_at)+' ago</i></div><p class="pt-2 mb-0">'+result[i].body+'</p><span>'+deleteComment+'</span></div>';
                    }
                }else{
                    div = '<div class="alert alert-secondary"></div>';
                }
                document.getElementById('comment-section').innerHTML = div
            } catch (error) {

            }
            viewComments = undefined;
        }
        xmlHttp.open('GET',actionUrl + '?action=getComments&video='+videoId);
        xmlHttp.send();
    }
}

function deleteComment(e){
    swal({
        title: "Are you sure?",
        text: "Do You Want To Delete This Comment?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            xmlHttp.onreadystatechange = function(){
                if(xmlHttp.responseText === 'deleted'){
                    swal("Your comment has been deleted", {
                        icon: "success",
                    });
                    fetchComments();
                }
            }
            xmlHttp.open('GET',actionUrl + '?action=deleteComment&id=' + e.id);
            xmlHttp.send();
        }
    });
}

function relativeTime(timeStamp) {
    timeStamp = new Date(timeStamp * 1000);
    let msg;
    var now = new Date(),
        secondsPast = (now.getTime() - timeStamp.getTime() ) / 1000;
    if(secondsPast < 60){
        let seconds = Math.floor(secondsPast);
        msg = seconds == 1 ? ' second' : ' seconds'
        return seconds + msg;
    }
    if(secondsPast < 3600){
        let minutes = parseInt(secondsPast/60);
        msg = minutes == 1 ? ' minute' : ' minutes'
        return minutes + msg;
    }
    if(secondsPast <= 86400){
        let hours = parseInt(secondsPast/3600);
        msg = hours == 1 ? ' hour' : 'hours';
        return hours + msg;
    }
    if(secondsPast <= 2628000){
        let days = parseInt(secondsPast/86400);
        msg = days == 1 ? ' day' : ' days';
        return days + msg;
    }
    if(secondsPast <= 31536000){
        let months = parseInt(secondsPast/26280000);
        msg = months == 1 ? ' month' : ' months';
        return months + msg;
    }
    if(secondsPast > 31536000){
        let years = parseInt(secondsPast/31536000);
        msg = years == 1 ? ' year' : 'years';
        return years + msg;
    }
}