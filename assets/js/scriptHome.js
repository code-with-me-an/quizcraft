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



const wordSpan = document.getElementById("changeText");
const words = ["fastest", "simplest", "free", "easiest"];

let wordIndex = 0;
let charIndex = 0;
let isDeleting = false;

function typeEffect() {
    const currentWord = words[wordIndex];
    if (isDeleting) {
        wordSpan.textContent = currentWord.substring(0, charIndex - 1);
        charIndex--;
    } else {
        wordSpan.textContent = currentWord.substring(0, charIndex + 1);
        charIndex++;
    }
    let typeSpeed = isDeleting ? 200 : 250; 
    if (!isDeleting && charIndex === currentWord.length) {
        typeSpeed = 2000; 
        isDeleting = true;
    } 
    else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        wordIndex = (wordIndex + 1) % words.length;
        typeSpeed = 500; 
    }
    setTimeout(typeEffect, typeSpeed);
}
document.addEventListener('DOMContentLoaded', typeEffect);



const numberElement = document.getElementById("people_number");
let started = false; 

function startCounter(targetElement) {
    const targetNumber = userCount; 
    let currentNumber = 0;
    const increment = Math.ceil(targetNumber / 100); 
    
    const interval = setInterval(() => {
        currentNumber += increment;
        
        if (currentNumber >= targetNumber) {
            currentNumber = targetNumber; 
            targetElement.innerText = currentNumber;
            clearInterval(interval);
        } else {
            targetElement.innerText = currentNumber;
        }
    }, 20); 
}

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !started) {
            started = true; 
            startCounter(entry.target);
        }
    });
}, { threshold: 0.5 }); 

observer.observe(numberElement);