
document.getElementById('button2').addEventListener('click', loadUsers);
document.getElementById('showMessages').addEventListener('click', addData);
document.getElementById('buttonDelete').addEventListener('click', deleteFirdaus);
document.getElementById('buttonAdd').addEventListener('click', addFirdaus);


function loadVideos() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'slim.php/video_path', true);

    xhr.onload = function () {
        // console.log(this.status);
        if (this.status == 200) {
            var videos = JSON.parse(this.responseText);

            // var output = '';


            // for(var i in users){
            //    output += '<button>' + users[i].name+'</button><br>';
            // }

            // document.getElementById('users').innerHTML = output;

            var video1 = videos[0].video_path;
            var video2 = videos[1].video_path;
            var video3 = videos[2].video_path;
            // var video4 = videos[3].video_path;
            var video4 = 'https://www.youtube.com/watch?v=b7d60eS516c&t=129s';

            document.getElementById('play1stwebcam').src = video1;
            document.getElementById('play2ndwebcam').src = video2;
            document.getElementById('play3rdwebcam').src = video3;
            document.getElementById('play4thwebcam').src = video4;
            document.getElementById('1stselect').value = video1;
            document.getElementById('2ndselect').value = video2;
            document.getElementById('3rdselect').value = video3;
            document.getElementById('4thselect').value = video4;
            document.getElementById('streamVideo').src = video2;


            btnChangeVideo.addEventListener("click", function () {
                var choosenVideo = document.getElementById("streamVideoSelect").value;
                document.getElementById("streamVideo").src = choosenVideo;
            });

            play1stwebcam.addEventListener("click", function () {
                document.getElementById("streamVideo").src = video1;
            });
            play2ndwebcam.addEventListener("click", function () {
                document.getElementById("streamVideo").src = video2;
            });
            play3rdwebcam.addEventListener("click", function () {
                document.getElementById("streamVideo").src = video3;
            });
            play4thwebcam.addEventListener("click", function () {
                document.getElementById("streamVideo").src = video4;
            });
        }
    }

    xhr.send();
}

function loadUsers() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'slim.php/participants', true);

    xhr.onload = function () {
        console.log(this.status);
        // console.log(JSON.parse(this.responseText)[2].name);
        if (this.status == 200) {
            var users = JSON.parse(this.responseText);

            var output = '';

            for (var i in users) {
                output += '<button>' + users[i].name + '</button><br>';
            }

            document.getElementById('users').innerHTML = output;
        }
    }

    xhr.send();
}

function addData() {
    form =
        '<div style="margin: 0%; padding: 0%;">' +
        '<form id="addiForm">' + '<br>' +
        '<input type="text" name="name" placeholder="Insert Name" style="background-color: transparent; height: 35px;">' +
        '<input type="text" name="id" placeholder="ID" style="background-color: transparent; height: 35px;">' +
        '<input type="submit" value="Add Participants" class="btn btn-primary">' +
        '</form> <br>' +
        '<form id="deliForm">' +
        '<input type="text" name="name" placeholder="Insert Name" style="background-color: transparent; height: 35px;">' +
        '<input type="submit" value="Delete Participants" class="btn btn-danger">' +
        '</form>' +
        '</div>';

    document.getElementById('users').innerHTML = form;

    addiForm.onsubmit = async (e) => {
        e.preventDefault();

        let response = await fetch('slim.php/addForm', {
            method: 'POST',
            body: new FormData(addiForm)
        });

        let result = await response.json();
        console.log(result);
        alert('Click the Participants button to check');
    };

    deliForm.onsubmit = async (e) => {
        e.preventDefault();

        let response = await fetch('slim.php/deleteForm', {
            method: 'POST',
            body: new FormData(deliForm)
        });

        let result = await response.json();
        console.log(result);
        alert('Click the Participants button to check');
    };
}

function deleteFirdaus() {
    var xhr = new XMLHttpRequest();
    xhr.open('DELETE', 'slim.php/participants/delete/Firdaus', true);

    xhr.send();
    alert("Firdaus has been kicked from the meeting");
    loadUsers();
}

function addFirdaus() {
    var xhr = new XMLHttpRequest();
    xhr.open('PUT', 'slim.php/participants/add/Firdaus', true);

    xhr.send();
    alert("Firdaus is added into the meeting");
    loadUsers();
}

var myVideo = document.getElementById("streamVideo");
btnPlay.addEventListener("click", function () {
    if (myVideo.paused)
        myVideo.play();
});
btnPause.addEventListener("click", function () {
    if (myVideo.play)
        myVideo.pause();
});

function btnPlayPause() {
    if (myVideo.paused)
        myVideo.play();
    else
        myVideo.pause();
}

function btnMuteUnmute() {
    if (myVideo.muted)
        myVideo.muted = false;
    else
        myVideo.muted = true;
}