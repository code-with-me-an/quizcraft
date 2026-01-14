const word = document.getElementById("changetext");
const words = ["fastest", "simplest", "free", "easiest"];
let currentIndex = 0;

function changeText() {
    word.innerText = words[currentIndex];
    currentIndex = (currentIndex + 1) % words.length;
}
setInterval(changeText, 3000);

const number = document.getElementById("people_number");

let counter = 0;
const limit = 200;
let start = false;

function startCounter(){
    if(start) return;
    start = true;
    const interval = setInterval(() => {
        if (counter <= limit) {
            number.innerHTML = counter;
            counter++;
        }
        else {
            clearInterval(interval);
        }
    }, 20);
}

window.addEventListener("load", startCounter);

