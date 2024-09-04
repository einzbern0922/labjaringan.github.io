<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM user_productivity where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>




<div class="container-fluid">
	<form action="" method="post" enctype="multipart/form-data" id="manage-progress" >
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-5">
					<?php if(!isset($_GET['tid'])): ?>
					 <div class="form-group">
		              <label for="" class="control-label">Project Manager</label>
		              <select class="form-control form-control-sm select2" name="task_id">
		              	<option></option>
		              	<?php 
		              	$tasks = $conn->query("SELECT * FROM task_list where project_id = {$_GET['pid']} order by task asc ");
		              	while($row= $tasks->fetch_assoc()):
		              	?>
		              	<option value="<?php echo $row['id'] ?>" <?php echo isset($task_id) && $task_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['task']) ?></option>
		              	<?php endwhile; ?>
		              </select>
		            </div>
		            <?php else: ?>
					<input type="hidden" name="task_id" value="<?php echo isset($_GET['tid']) ? $_GET['tid'] : '' ?>">
		            <?php endif; ?>
					<div class="form-group">
						<label for="">Subject</label>
						<input type="text" class="form-control form-control-sm" name="subject" value="<?php echo isset($subject) ? $subject : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="">Date</label>
						<input type="date" class="form-control form-control-sm" name="date" value="<?php echo isset($date) ? date("Y-m-d",strtotime($date)) : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="">Start Time</label>
						<input type="time" class="form-control form-control-sm" name="start_time" value="<?php echo isset($start_time) ? date("H:i",strtotime("2020-01-01 ".$start_time)) : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="">End Time</label>
						<input type="time" class="form-control form-control-sm" name="end_time" value="<?php echo isset($end_time) ? date("H:i",strtotime("2020-01-01 ".$end_time)) : '' ?>" required>
					</div>
					<div class="form-group">
					<div class="file-uploader">
						<div class="uploader-header">
							<label for="" class="control-label">Files</label>
							<h4 class="file-completed-status"></h4>
						</div>
							<div class="custom-file">
							<ul class="file-list"></ul>
							<div class="file-upload-box">
							<div class="custom-file">
							<h2 class="box-title">
								<span class="file-instruction">Drag files here or</span>
								<span class="file-browse-button">browse</span>
							</h2>
							  <input class="file-browse-input" type="file" multiple hidden value="<?php echo isset($my_files) ? $my_files : '' ?>" required>
		            		</div>
							</div>
							</div>
						<div class="form-group d-flex justify-content-center align-items-center">
						<br><br><br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<style>
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
.uploader-header .uploader-title {
  font-size: 1.2rem;
  font-weight: 700;
  text-transform: uppercase;
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
.file-upload-box .box-title .file-browse-button {
  color: #5145BA;
  cursor: pointer;
}

.file-upload-box .box-title .file-browse-button:hover {
 text-decoration: underline;
}
</style>
<script>
	$(document).ready(function(){
	$('.summernote').summernote({
        height: 200,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    })

     $('.select2').select2({
	    placeholder:"Please select here",
	    width: "100%"
	  });
     })
    $('#manage-progress').submit(function(e){
    	e.preventDefault()
    	start_load()

    	$.ajax({
    		url:'ajax.php?action=save_progress',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
    	})
    })
</script>

<script>
	$('[name="password"],[name="cpass"]').keyup(function(){
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cpass"]').val()
		if(cpass == '' ||pass == ''){
			$('#pass_match').attr('data-status','')
		}else{
			if(cpass == pass){
				$('#pass_match').attr('data-status','1').html('<i class="text-success">Password Matched.</i>')
			}else{
				$('#pass_match').attr('data-status','2').html('<i class="text-danger">Password does not match.</i>')
			}
		}
	})

	$('#manage_user').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')

		$.ajax({
			url:'ajax.php?action=save_user',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=user_list')
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
					$('[name="email"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>

<script>
  const fileList = document.querySelector(".file-list");
const fileBrowseButton = document.querySelector(".file-browse-button");
const fileBrowseInput = document.querySelector(".file-browse-input");
const fileUploadBox = document.querySelector(".custom-file");
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