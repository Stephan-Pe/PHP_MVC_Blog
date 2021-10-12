import { toggleNav } from "./modules/topnav.js";
import { showPassword } from "./modules/showPassword.js";
const dropZoneInput = document.querySelectorAll(".drop__zone--input");
const errorDisplay = document.querySelector(".image-feedback");
const dropZonePromt = document.querySelector(".drop__zone--prompt");

// const myForm = document.getElementById("myForm");
const avatar = document.querySelector("#drop-zone--input");
// myForm.addEventListener("click", uploadFile);
if (dropZonePromt) {
  dropZonePromt.innerText = "Drop file here or click to upload";
}

dropZoneInput.forEach((inputElement) => {
  const dropZoneElement = inputElement.closest(".drop__zone");

  dropZoneElement.addEventListener("click", (e) => {
    inputElement.click();
  });

  inputElement.addEventListener("change", (e) => {
    if (inputElement.files.length) {
      dropZonePromt.innerText = "";
      let imageToPost = inputElement.files[0];
      let fileSize = inputElement.files[0].size;
      let extName = imageToPost.name;
      let allowedExt = /(\jpg|\jpeg|\png)$/i;
      console.log(imageToPost);
      if (fileSize >= 500000) {
        errorDisplay.innerHTML = "Datei ist zu gross";
      } else if (!allowedExt.exec(extName)) {
        errorDisplay.innerHTML = "Dateityp nicht unterstützt!";
      } else {
        updateThumbnail(dropZoneElement, imageToPost);
      }
    }
  });

  dropZoneElement.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZoneElement.classList.add("drop__zone--over");
  });

  ["dragleave", "dragend"].forEach((type) => {
    dropZoneElement.addEventListener(type, (e) => {
      dropZoneElement.classList.remove("drop__zone--over");
    });
  });

  dropZoneElement.addEventListener("drop", (e) => {
    e.preventDefault();

    if (e.dataTransfer.files.length) {
      inputElement.files = e.dataTransfer.files;
      updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
    }

    dropZoneElement.classList.remove("drop__zone--over");
  });
});

// async function uploadFile() {
//   const endpoint = "includes/upload.php";
//   const formData = new FormData();
//   let uploadFile = avatar.files[0];
//   let header = new Headers();
//   header.append("Accept", "multipart/form-data");

//   formData.append("image", uploadFile);
//   try {
//     const response = await fetch(endpoint, {
//       method: "POST",
//       headers: header,
//       mode: "no-cors",
//       body: formData,
//     });

//     const result = await response.json();
//   } catch (error) {
//     console.log(error);
//   }
// }

/**
 * Updates the thumbnail on a drop zone element.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */

function updateThumbnail(dropZoneElement, file) {
  // remove Prompt
  let thumbnailElement = dropZoneElement.querySelector(".drop__zone--thumb");
  let dropZonePrompt = dropZoneElement.querySelector(".drop__zone--prompt");
  if (dropZonePrompt) {
    dropZonePrompt.remove();
  }

  // Create Thumbnail if not There
  if (!thumbnailElement) {
    thumbnailElement = document.createElement("div");
    thumbnailElement.classList.add("drop__zone--thumb");
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

document.addEventListener("DOMContentLoaded", function (event) {
  toggleNav();
  showPassword();
});
