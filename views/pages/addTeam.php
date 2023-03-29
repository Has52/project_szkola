<div id='component'>
    <div id="titleComponent">Dodaj Drużynę</div>
    <div id="contenerContent">
        <form method="post" style="flex-direction: row;" id="contenerContentTeamForm">
            <div class="leftContentContener">
                <div class="nameTeamContent">
                    <div class="contentBox">
                        <div class="contentTitle">Nazwa drużyny</div>
                        <div class="contentInput">
                            <input type="text" name="teamName" placeholder="Tekst..." required>
                        </div>
                    </div>
                </div>
                <div class="addPlayerContent">
                    <div class="contentBox">
                        <div class="contentTitle">Zawodnicy</div>
                        <div class="contentInput" id='contentInputs'>
                            <div class="classPlayer">
                                <div class="namePlayer" id='plusNewPlayer'><i class="fa-solid fa-plus"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rightContentContener">
                <div class="contentRight" style="justify-content: center;">
                    <div class="drop-zone">
                        <span class="drop-zone__prompt">Upuść plik z logo tutaj lub kliknij</span>
                        <input type="file" name="image" id="image" class="drop-zone__input" accept="image/png, image/jpeg" required>
                    </div>
                </div>
                <div class="contentRight">
                    <input type="submit" name='submit' class="buttonCreateTeam" value="Stwórz drużynę">
                </div>
            </div>
        </form>
    </div> 
</div>

<script>
let plusNewPlayer = document.getElementById('plusNewPlayer')

let removePlayer = (event) => {
    event.parentElement.remove();
}

let addNewPlayerFunction = () => {
    plusNewPlayer.parentElement.innerHTML = '<input type="text" placeholder="Nazwa..." required> <div class="playerX" onclick="removePlayer(this)"><i class="fa-solid fa-xmark"></i></div>'
    $("#contentInputs").append(`<div class="classPlayer"><div class="namePlayer" id='plusNewPlayer'><i class="fa-solid fa-plus"></i></div></div>`)
    plusNewPlayer = document.getElementById('plusNewPlayer')
    plusNewPlayer.addEventListener('click', addNewPlayerFunction)
}

plusNewPlayer.addEventListener('click', addNewPlayerFunction)


// CodePen
// Simple Drag and Drop File Upload Tutorial - HTML, CSS & JavaScript

document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
            updateThumbnail(dropZoneElement, inputElement.files[0]);
        }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    dropZoneElement.addEventListener("drop", (e) => {
        e.preventDefault();

        if (e.dataTransfer.files.length) {
            inputElement.files = e.dataTransfer.files;
            updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
});

/**
 * Updates the thumbnail on a drop zone element.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */
function updateThumbnail(dropZoneElement, file) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    // First time - remove the prompt
    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    // First time - there is no thumbnail element, so lets create it
    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }

    thumbnailElement.dataset.label = file.name;

    // Show thumbnail for image files
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();

        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    } else {
        thumbnailElement.style.backgroundImage = null;
    }
}
// end


$("#contenerContentTeamForm").submit(function(event){   
    event.preventDefault();
    let formData = new FormData($(this)[0]);
    
    Array.from(document.getElementById('contentInputs').children).forEach((e) => {
        if(e.children[0].nodeName == 'INPUT' && e.children[0].value !== ''){
            formData.append('players[]', e.children[0].value)
        }   
    })

    $.ajax({
        url: './api/createTeam.php',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (response) {
            if(response == 'ok'){
                Swal.fire(
                    'Stworzono!',
                    'Drużyna została utworzona.',
                    'success'
                ).then(() => {
                    location.reload();
                })
            } else {
                alert(response)
            }
        }
    });

    return false;

});

</script>