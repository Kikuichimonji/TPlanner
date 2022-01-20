newBoard = document.querySelector("#dashboardTop div div:first-child");
newBoard.hiddenId = newBoard.getAttribute("user");
newBoard.removeAttribute("user");

newBoard.addEventListener("click", ev =>{

    let newBox = document.createElement("input"); //we create a new text input
    newBox.setAttribute("type","text");
    newBox.classList.add("instantInput");

    let newButton = document.createElement("button"); //we create the confirm button
    newButton.innerHTML = "Valider";
    newButton.hiddenId = ev.target.hiddenId;
    newButton.classList.add("confirmButton");

    ev.target.parentNode.appendChild(newBox)
    ev.target.parentNode.appendChild(newButton) //We append the input and the button 
    ev.target.outerHTML = ""
    newBox.focus();
    ev.stopImmediatePropagation();
    newButton.addEventListener("click", (ev) => { //the click function to confirm the new title value
        if(newBox.value.trim()!=""){
            args = {"type" : "newBoard", 'text' : newBox.value, "id" : ev.target.hiddenId}; //the argument list for the fetch
            newBox.value.trim().length < 50 ? goFetch(args) : callErrorModal("Le titre ne peux pas dépasser 50 charactères") //we fetch the sql to save the value

        }else{
            callErrorModal("Le titre ne peux pas être vide")
        }   
        
        
    });
});


function goFetch(args) // function that fetch the board content depending on the args
{

    myHeaders = new Headers(); //If we want custom headers
    let formData = new FormData(); //We append the POST data here
    
    if(args["type"]){
        formData.append('act',args['type']) //The action is saved in POST so nobody can mess by typing directly the link
        switch(args['type']) {
            case "newBoard" :
                formData.append('text',args['text']) //We pass all the users inputs in POST
                link = "dashboard.php?id=" + args["id"]; 
                break
            default:
                link = null;
        }
    }else{
        link = null;
        console.log("goFetch need a type to operate");
    }
    
    let myInit = { method: 'POST', //Fetch settings
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body:  formData};

    //console.log(link)
    if(link){
        let myRequest = new Request(link,myInit); //We prepare the fetch request with settings and our link destination
        fetch(myRequest).then((response) => { //We fetch the result
            response.text().then(response => {
                console.log(response) //My check of the controler response
                if(response === 'false')    //If the controler writes 'false' , i know it's shit but i haven't found out how to return a boolean with fetch
                    console.log("Problème de paramètres")
                else{
                    console.log("good doggy")
                    window.location.href = "board.php?id=" + response;
                }
            })
            if(!response.ok) { // If fetch failed somehow , maybe permission? dunno
                console.log("Mauvaise réponse du réseau")
            }
        })
    }else{
        console.log("Link null")
    }
    
}

function callErrorModal(message)
{
    popup = document.getElementById("popupModal")
    if(!popup.classList.contains("popupUp")){
        popup.style.display = 'block';
        popup.classList.add("popupUp")
        popup.innerHTML = message;
        
        setTimeout(() =>{
            popup.classList.remove("popupUp");
        },3000)
    }
}