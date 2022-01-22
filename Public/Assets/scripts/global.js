let popupMenu = null;
popupMenu = document.getElementById("popUpProfile");

popupMenu ? document.querySelector("#headerContainer .icon").addEventListener("click",(ev) => { //We open and close the user menu
                popupMenu.style.display = popupMenu.style.display == "block" ? "none" : "block" //If the display is block, then we hide it, and vice versa
            })
            : null;

            
function youSure(func,elem,message = null)
{
    let modal = document.createElement("div");
    modal.classList.add("youSure");
    let title = document.createElement("h4");
    message ? title.innerHTML = message: title.innerHTML = "Etes vous sûr ?"
    let buttonYes = document.createElement("button");
    buttonYes.innerHTML = "Oui";
    let buttonNo = document.createElement("button");
    buttonNo.innerHTML = "Non";

    modal.appendChild(title);
    modal.appendChild(buttonYes);
    modal.appendChild(buttonNo);
    document.querySelector("body").appendChild(modal);
    buttonYes.addEventListener("click", ev =>{
        func(elem);
        modal.outerHTML = "";
    })
    buttonNo.addEventListener("click", ev =>{
        modal.outerHTML = "";
    })
}

function callErrorModal(message)
{
    popupEl = document.createElement("div")
    popupEl.id = "popupModal"
    document.querySelector("body").appendChild(popupEl)
    popup = document.getElementById("popupModal")
    if(!popup.classList.contains("popupUp")){
        popup.style.display = 'block';
        popup.classList.add("popupUp")
        popup.classList.remove("success")
        popup.innerHTML = message;
        
        setTimeout(() =>{
            popup.classList.remove("popupUp");
            setTimeout(() =>{
                popup.outerHTML = "";
            },500)
        },3000)
    }
}
function callSuccessModal(message)
{
    popupEl = document.createElement("div")
    popupEl.id = "popupModal"
    document.querySelector("body").appendChild(popupEl)
    popup = document.getElementById("popupModal")
    if(!popup.classList.contains("popupUp")){
        popup.style.display = 'block';
        popup.classList.add("popupUp")
        popup.classList.add("success")
        popup.innerHTML = message;
        
        setTimeout(() =>{
            popup.classList.remove("popupUp");
            setTimeout(() =>{
                popup.outerHTML = "";
            },1000)
        },3000)
    }
}
