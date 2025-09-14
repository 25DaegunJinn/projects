const resumeBtn = document.getElementById("input-resume");
const fileInput = document.getElementsByClassName("file-input");

resumeBtn.addEventListener("click", function() {
    fileInput[0].click();
});

fileInput[0].addEventListener("change", function() {
    if(fileInput[0].files.length > 1) {
        return alert("파일은 하나만 업로드 할 수 있습니다." + fileInput[0].type);
    }

    if(fileInput[0].files.length === 1) {
        const formData = new FormData();
        formData.append("file", fileInput[0].files[0]);

        fetch("/api/analysis.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.log(error);
        })
    }
});