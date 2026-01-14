function openGenerate(url) {
    window.location.href = url;
}
function openJoin(url) {
    window.location.href = url;
}
function loginPage(url) {
    window.location.href = url;
}

const menubar = document.getElementById("menu_bar");
const dropdown = document.getElementById("dropdown");

if (menubar) {
    menubar.addEventListener("click", () => {
        dropdown.classList.toggle("show_dropdown_1");
    })
}
if (menubar) {
    menubar.addEventListener("click", () => {
        setTimeout(() => {
            dropdown.classList.toggle("show_dropdown_2");
        })
    })
}

document.addEventListener("click", (e) => {
    if (!menubar.contains(e.target)) {
        dropdown.classList.remove("show_dropdown_1");
    }
})
document.addEventListener("click", (e) => {
    if (!menubar.contains(e.target)) {
        dropdown.classList.remove("show_dropdown_2");
    }
})



// join quiz error handling


function submitForm() {
    link = document.getElementsByName('link')[0].value.trim();
    examinee = document.getElementsByName('examinee')[0].value.trim();
    if ((link == null || link == '') || (examinee == null || examinee == '')) {
        window.alert("Please fill the options");
    } else {
        document.getElementById('form').submit();
    }
}


// create quiz handling

function nextBox(quizBox) {
    document.getElementById("emptyError1").innerText = "";
    document.getElementById("emptyError2").innerText = "";
    quizName = document.getElementById("name").value.trim();
    quizDesc = document.getElementById("desc").value.trim();
    if (quizBox == 1) {
        if ((quizName != "" && quizName != null) && (quizDesc != "" && quizDesc != null)) {
            document.getElementById("quizBox" + quizBox).classList.remove("active");
            document.getElementById("quizBox" + (quizBox + 1)).classList.add("active");
        }
        else {
            document.getElementById("emptyError1").innerText = "empty input field";
        }
    } else if (quizBox == 2) {
        num = document.getElementById("numQues").value.trim();
        if (num != null && num != "") {
            if (isNaN(num)) {
                document.getElementById("emptyError2").innerText = "not a number";
            } else {
                document.getElementById("quizBox" + quizBox).classList.remove("active");
                document.getElementById("quizBox" + (quizBox + 1)).classList.add("active");

                container = document.getElementById("quizBox3");
                if (num <= 50) {
                    console.log("hi");
                    container.innerHTML = '';
                    for (let i = 1; i <= num; i++) {
                        container.innerHTML += `
                        <h3>Question ${i}</h3>
                        <textarea name="question_text[${i}]" placeholder="Question ${i}" required></textarea>
                        <input type="text" name="option_a[${i}]" placeholder="Option A" required>
                        <input type="text" name="option_b[${i}]" placeholder="Option B" required>
                        <input type="text" name="option_c[${i}]" placeholder="Option C" required>
                        <input type="text" name="option_d[${i}]" placeholder="Option D" required>
                        Correct Option (A/B/C/D):
                        <input type="text" name="correct_option[${i}]" maxlength="1" required>
                        `;
                    }
                    container.innerHTML += "<div class='buttons'><button type='button' onclick='prevBox(3)'>Previous</button><button type='submit'>Generate</button></div>"
                } else {
                    alert('you can create upto 50 quizzes');
                }
            }
        } else {
            document.getElementById("emptyError2").innerText = "empty input field";
        }
    }
}

function prevBox(quizBox) {
    document.getElementById("quizBox" + quizBox).classList.remove("active");
    document.getElementById("quizBox" + (quizBox - 1)).classList.add("active");
}

function checkValid() {
    let num = document.getElementById("numQues").value.trim();
    let str = "ABCD";
    let submitFlag = true;

    for (let i = 1; i <= num; i++) {
        let val = document.getElementsByName('correct_option[' + i + ']')[0].value.trim();
        if (!str.includes(val) || val == '') {
            alert('Please enter a valid correct option (A, B, C, or D) for question ' + i);
            submitFlag = false;
            break;
        }
    }
    if (num == 0) {
        alert("No questions Added");
        submitFlag = false;
    }
    return submitFlag;
}




