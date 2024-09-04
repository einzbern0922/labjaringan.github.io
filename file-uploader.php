
<!DOCTYPE html>
<!-- Coding By CodingNepal - www.codingnepalweb.com -->
<html lang="en">
  <head>
    <style>
  /* Importing Inter Font from Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Inter", sans-serif;
}

body {
  display: flex;
  align-items: center;
  padding: 15px;
  justify-content: center;
  min-height: 100vh;
  background: #5145BA;
}

.file-uploader {
  width: 500px;
  background: #fff;
  border-radius: 5px;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.file-uploader .uploader-header {
  display: flex;
  padding: 20px;
  background: #EEF1FB;
  align-items: center;
  border-radius: 5px 5px 0 0;
  justify-content: space-between;
}

.uploader-header .uploader-title {
  font-size: 1.2rem;
  font-weight: 700;
  text-transform: uppercase;
}

.uploader-header .file-completed-status {
  font-size: 1rem;
  font-weight: 500;
  color: #333;
}

.file-uploader .file-list {
  list-style: none;
  width: 100%;
  padding-bottom: 10px;
  max-height: 400px;
  overflow-y: auto;
  scrollbar-color: #999 transparent;
  scrollbar-width: thin;
}

.file-uploader .file-list:has(li) {
  padding: 20px;
}

.file-list .file-item {
  display: flex;
  gap: 14px;
  margin-bottom: 22px;
}

.file-list .file-item:last-child {
  margin-bottom: 0px;
}

.file-list .file-item .file-extension {
  height: 50px;
  width: 50px;
  color: #fff;
  display: flex;
  text-transform: uppercase;
  align-items: center;
  justify-content: center;
  border-radius: 15px;
  background: #5145BA;
}

.file-list .file-item .file-content-wrapper {
  flex: 1;
}

.file-list .file-item .file-content {
  display: flex;
  width: 100%;
  justify-content: space-between;
}

.file-list .file-item .file-name {
  font-size: 1rem;
  font-weight: 600;
}

.file-list .file-item .file-info {
  display: flex;
  gap: 5px;
}

.file-list .file-item .file-info small {
  color: #5c5c5c;
  margin-top: 5px;
  display: block;
  font-size: 0.9rem;
  font-weight: 500;
}

.file-list .file-item .file-info .file-status {
  color: #5145BA;
}

.file-list .file-item .cancel-button {
  align-self: center;
  border: none;
  outline: none;
  background: none;
  cursor: pointer;
  font-size: 1.4rem;
}

.file-list .file-item .cancel-button:hover {
  color: #E3413F;
}

.file-list .file-item .file-progress-bar {
  width: 100%;
  height: 3px;
  margin-top: 10px;
  border-radius: 30px;
  background: #d9d9d9;
}

.file-list .file-item .file-progress-bar .file-progress {
  width: 0%;
  height: inherit;
  border-radius: inherit;
  background: #5145BA;
}

.file-uploader .file-upload-box {
  margin: 10px 20px 20px;
  border-radius: 5px;
  min-height: 100px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px dashed #B1ADD4;
  transition: all 0.2s ease;
}

.file-uploader .file-upload-box.active {
  border: 2px solid #5145BA;
  background: #F3F6FF;
}

.file-uploader .file-upload-box .box-title {
  font-size: 1.05rem;
  font-weight: 500;
  color: #626161;
}

.file-uploader .file-upload-box.active .box-title {
  pointer-events: none;
}

.file-upload-box .box-title .file-browse-button {
  color: #5145BA;
  cursor: pointer;
}

.file-upload-box .box-title .file-browse-button:hover {
 text-decoration: underline;
}</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Uploader JavaScript | CodingNepal</title>
    <link rel="stylesheet" href="style.css">
    <!-- Linking Box Icon for Icons -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <script src="script.js" defer></script>
  </head>
  <body>
    <div class="file-uploader">
      <div class="uploader-header">
        <h2 class="uploader-title">File Uploader</h2>
        <h4 class="file-completed-status"></h4>
      </div>
      <ul class="file-list"></ul>
      <div class="file-upload-box">
        <h2 class="box-title">
          <span class="file-instruction">Drag files here or</span>
          <span class="file-browse-button">browse</span>
        </h2>
        <input class="file-browse-input" type="file" multiple hidden>
      </div>
    </div>
  </body>

  <script>
  const fileList = document.querySelector(".file-list");
const fileBrowseButton = document.querySelector(".file-browse-button");
const fileBrowseInput = document.querySelector(".file-browse-input");
const fileUploadBox = document.querySelector(".file-upload-box");
const fileCompletedStatus = document.querySelector(".file-completed-status");

let totalFiles = 0;
let completedFiles = 0;

// Function to create HTML for each file item
const createFileItemHTML = (file, uniqueIdentifier) => {
    // Extracting file name, size, and extension
    const {name, size} = file;
    const extension = name.split(".").pop();
    const formattedFileSize = size >= 1024 * 1024 ? `${(size / (1024 * 1024)).toFixed(2)} MB` : `${(size / 1024).toFixed(2)} KB`;

    // Generating HTML for file item
    return `<li class="file-item" id="file-item-${uniqueIdentifier}">
                <div class="file-extension">${extension}</div>
                <div class="file-content-wrapper">
                <div class="file-content">
                    <div class="file-details">
                    <h5 class="file-name">${name}</h5>
                    <div class="file-info">
                        <small class="file-size">0 MB / ${formattedFileSize}</small>
                        <small class="file-divider">•</small>
                        <small class="file-status">Uploading...</small>
                    </div>
                    </div>
                    <button class="cancel-button">
                    <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="file-progress-bar">
                    <div class="file-progress"></div>
                </div>
                </div>
            </li>`;
}

// Function to handle file uploading
const handleFileUploading = (file, uniqueIdentifier) => {
    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append("file", file);

    // Adding progress event listener to the ajax request
    xhr.upload.addEventListener("progress", (e) => {
        // Updating progress bar and file size element
        const fileProgress = document.querySelector(`#file-item-${uniqueIdentifier} .file-progress`);
        const fileSize = document.querySelector(`#file-item-${uniqueIdentifier} .file-size`);

        // Formatting the uploading or total file size into KB or MB accordingly
        const formattedFileSize = file.size >= 1024 * 1024  ? `${(e.loaded / (1024 * 1024)).toFixed(2)} MB / ${(e.total / (1024 * 1024)).toFixed(2)} MB` : `${(e.loaded / 1024).toFixed(2)} KB / ${(e.total / 1024).toFixed(2)} KB`;

        const progress = Math.round((e.loaded / e.total) * 100);
        fileProgress.style.width = `${progress}%`;
        fileSize.innerText = formattedFileSize;
    });

    // Opening connection to the server API endpoint "api.php" and sending the form data
    xhr.open("POST", "api.php", true);
    xhr.send(formData);

    return xhr;
}

// Function to handle selected files
const handleSelectedFiles = ([...files]) => {
    if(files.length === 0) return; // Check if no files are selected
    totalFiles += files.length;

    files.forEach((file, index) => {
        const uniqueIdentifier = Date.now() + index;
        const fileItemHTML = createFileItemHTML(file, uniqueIdentifier);
        // Inserting each file item into file list
        fileList.insertAdjacentHTML("afterbegin", fileItemHTML);
        const currentFileItem = document.querySelector(`#file-item-${uniqueIdentifier}`);
        const cancelFileUploadButton = currentFileItem.querySelector(".cancel-button");

        const xhr = handleFileUploading(file, uniqueIdentifier);

        // Update file status text and change color of it 
        const updateFileStatus = (status, color) => {
            currentFileItem.querySelector(".file-status").innerText = status;
            currentFileItem.querySelector(".file-status").style.color = color;
        }

        xhr.addEventListener("readystatechange", () => {
            // Handling completion of file upload
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                completedFiles++;
                cancelFileUploadButton.remove();
                updateFileStatus("Completed", "#00B125");
                fileCompletedStatus.innerText = `${completedFiles} / ${totalFiles} files completed`;
            }
        });

        // Handling cancellation of file upload
        cancelFileUploadButton.addEventListener("click", () => {
            xhr.abort(); // Cancel file upload
            updateFileStatus("Cancelled", "#E3413F");
            cancelFileUploadButton.remove();
        });

        // Show Alert if there is any error occured during file uploading
        xhr.addEventListener("error", () => {
            updateFileStatus("Error", "#E3413F");
            alert("An error occurred during the file upload!");
        });
    });

    fileCompletedStatus.innerText = `${completedFiles} / ${totalFiles} files completed`;
}

// Function to handle file drop event
fileUploadBox.addEventListener("drop", (e) => {
    e.preventDefault();
    handleSelectedFiles(e.dataTransfer.files);
    fileUploadBox.classList.remove("active");
    fileUploadBox.querySelector(".file-instruction").innerText = "Drag files here or";
});

// Function to handle file dragover event
fileUploadBox.addEventListener("dragover", (e) => {
    e.preventDefault();
    fileUploadBox.classList.add("active");
    fileUploadBox.querySelector(".file-instruction").innerText = "Release to upload or";
});

// Function to handle file dragleave event
fileUploadBox.addEventListener("dragleave", (e) => {
    e.preventDefault();
    fileUploadBox.classList.remove("active");
    fileUploadBox.querySelector(".file-instruction").innerText = "Drag files here or";
});

fileBrowseInput.addEventListener("change", (e) => handleSelectedFiles(e.target.files));
fileBrowseButton.addEventListener("click", () => fileBrowseInput.click());
</script>
</html>