let listMenu = document.getElementById("userTabs").querySelectorAll("li")
let listContent = document.getElementById("userContent").querySelectorAll("div")
let listArray = [...listContent];
let listCount = 0;
listArray[0].style.display = "block";

for(item of listMenu) {
    item.hiddenId = listCount;
    listCount++;
}
listMenu.forEach(item => {
    item.addEventListener("click", ev =>{
        listArray.forEach(item=>{
            item.style.display = 'none';
        })
        listMenu.forEach(item =>{
            item.classList.remove("active")
        })
        listArray[ev.target.hiddenId].style.display = "flex"
        item.classList.add("active")
    })
})

pseudoButton = document.getElementById("pseudo").nextElementSibling
pseudoButton.addEventListener("click", ev => {
    
    text = ev.target.previousElementSibling.value
    if(text.trim() == ""){
        ev.preventDefault();
        callErrorModal("Le pseudo ne peut pas être vide")
    }else if(text.trim().length > 50){
        ev.preventDefault();
        callErrorModal("Le pseudo dois contenir moins de 50 charactères (actuellement : " + text.trim().length + ")")
    }
})

emailButton = document.getElementById("email").nextElementSibling
emailButton.addEventListener("click", ev => {
    
    text = ev.target.previousElementSibling.value

    if(text.trim() == ""){
        ev.preventDefault();
        callErrorModal("Le mail ne peut pas être vide")
    }else if(!text.trim().toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
        ev.preventDefault();
        callErrorModal("Cet email est invalide");
    }
})