let cards = null
let lists = null
let board = null
let draggedElement = null;
let newListButton = null;
let boardTitle = null;
let invButton = null;
let okayToClose = false;
let options = null;
let cardOptions = null;
let target = null;
let listoptions = null
let lastChangeTime = null;
let busy = false;
let timerChecks = [];
let timeToReload = 10000;
let creator = null;
let user = null;

function init() { //Initialisation of all the basic elements, necessary to make the board page work, can be recalled when the page is fetched
    if(!document.querySelector(".board")){
        isBusy(true);
    }

    creator = document.getElementById("creator") ? document.getElementById("creator").querySelector(".tooltiptext").lastChild.textContent : null;

    user = document.querySelector("main").getAttribute("creator");
    document.querySelector("main").removeAttribute("creator")
    cards = document.querySelectorAll(".card"); //all the cards in the page
    lists = document.querySelectorAll(".list"); //all the lists in the page
    board = document.querySelector(".board");   //The board
    board.hiddenId = board.id;  //We hide the id inside a JS parameter so it cannot be tempered with
    board.removeAttribute("id");
    document.querySelector("main").removeAttribute("id")
    options = document.getElementById("cardMenu").getElementsByTagName("li") //we put a hidden value for each card menu option (small menu)
    for (let item of options) {
        item.hiddenFunc = item.getAttribute("func");
        item.removeAttribute("func")
    }
    cardOptions = document.getElementById("cardDetail").getElementsByTagName("li") //we put a hidden value for each card menu option (detailed menu)
    for (let item of cardOptions) {
        item.hiddenFunc = item.getAttribute("func");
        item.removeAttribute("func")
    }
    listOptions = document.getElementById("listMenu").getElementsByTagName("li") //we put a hidden value for each card menu option (detailed menu)
    for (let item of listOptions) {
        item.hiddenFunc = item.getAttribute("func");
        item.removeAttribute("func")
    }
    newListButton = document.getElementById("addList");
    boardTitle = document.querySelector("#leftside div div:first-child");
    invButton = document.getElementById("inviteButton");
    archive = document.getElementById("rightside").firstElementChild;
    archiveList = document.getElementById("archive").querySelectorAll(".listContainer");
    deleteBoardButton = document.querySelector("#rightside .delete");
    lastChange = document.getElementById("lastChange");
    lastChangeTime = lastChange.textContent;
    lastChange.outerHTML = "";
    userIcons = document.getElementsByClassName("tooltip")
    isBusy(false);
    
    handler = function (ev) { //The function that change the board title into an input, then change it back into a clickable title
        isBusy(true);
        let newBox = document.createElement("input"); //we create a new text input
        newBox.setAttribute("type", "text");
        ev.target.id != "inviteButton" ? newBox.value = ev.target.textContent : newBox.placeholder = "Entrer un email";
        newBox.classList.add("instantInput");
        let newButton = document.createElement("button"); //we create the confirm button
        newButton.innerHTML = "Valider";
        newButton.hiddenId = board.hiddenId;
        newButton.classList.add("confirmButton");
        newButton.hiddenclass = ev.target.id
        newButton.oldElement = ev.target.outerHTML;
        ev.target.parentNode.appendChild(newBox)
        ev.target.parentNode.appendChild(newButton) //We append the input and the button 
        ev.target.outerHTML = ""    //we remove the title
        newBox.focus();
        newButton.addEventListener("click", (ev) => { //the click function to confirm the new title value
            if (ev.target.hiddenclass == "inviteButton") {
                args = { "type": "invite", 'idBoard': ev.target.hiddenId, 'mail': newBox.value }; //the argument list for the fetch
            } else {
                args = { "type": "changeBoard", 'board': ev.target, 'text': newBox.value }; //the argument list for the fetch
            }
            if(newBox.value.trim() != "") {
                if(newBox.value.trim().length <50 || ev.target.hiddenclass == "inviteButton"){
                    parent = ev.target.parentNode;
                    parent.innerHTML = ev.target.oldElement
                    parent.firstElementChild.innerHTML = ev.target.hiddenclass == "inviteButton" ? "+ Inviter" : newBox.value;
                    parent.firstElementChild.addEventListener("click", handler); // we reatach the click event on the new element
                    goFetch(args); //we fetch the sql to save the value
                    isBusy(false);
                }else{
                    callErrorModal("Le titre ne peux pas d??passer 50 charact??res");
                }
            }else{
                ev.target.hiddenclass == "inviteButton" ? callErrorModal("Veuillez entrer une adresse email") : callErrorModal("Le titre ne peux pas ??tre vide");
                
            }
        });
    };
    boardTitle.addEventListener("click", handler);
    invButton.addEventListener("click", handler);
    cards.forEach((item) => { // We hide the id in a parameter so people can't mess with the positions
        item.hiddenId = item.id; //We hide the id inside a JS parameter
        item.hiddenType = "card"; //This attribute is used for drag and drop purpose, to detect what part of the element it is
        item.isCard = true;
        item.removeAttribute('id');
        item.originalText = item.querySelector(".cardBody").getAttribute("originalText");
        item.querySelector(".cardBody").removeAttribute("originalText");
        item.querySelector(".menu").hiddenClass = "menu"
        item.childNodes.forEach(child => { //we put the attribute on all cards childrens
            child.hiddenType = "card";
            child.hiddenId = child.parentNode.hiddenId;
            child.childNodes.forEach(child => {
                child.hiddenType = "card";
                child.hiddenId = child.parentNode.hiddenId;
            })
        })
        item.files = item.getAttribute("data-files")
        item.removeAttribute("data-files")
        if(item.files){
            item.files = JSON.parse(item.files)
        }

        cardTitle = item.querySelector(".cardTitle"); //We look for the title of each card
        handlerCard = function (ev) { //The function that change the card title into an input, then change it back into a clickable title
            ev.stopImmediatePropagation();
            ev.target.removeEventListener("click",handlerList)
            if(!ev.target.classList.contains("instantInput") && !ev.target.classList.contains("confirmButton")){
                let newBox = document.createElement("input"); //we create a new input
                newBox.setAttribute("type", "text");
                newBox.value = ev.target.textContent
                newBox.classList.add("instantInput");
                let newButton = document.createElement("button"); //we create the confirm button
                newButton.innerHTML = "Valider";
                newButton.hiddenId = ev.target.parentNode.parentNode.hiddenId;
                newButton.classList.add("confirmButton");
                ev.target.parentNode.nextElementSibling.style.display = 'none'; //we hide the menu icon to gain some space
                ev.target.parentNode.oldText = ev.target.innerHTML
                ev.target.innerHTML = ""; //we remove the title
                ev.target.classList.add("specialInputOpen")
                ev.target.appendChild(newBox);
                ev.target.appendChild(newButton);
                newBox.focus();
                newButton.addEventListener("click", (ev) => {
                    if(newBox.value.trim() != ""){
                        if(newBox.value.trim().length <50){
                            args = { "type": "changeCard", 'card': ev.target.hiddenId, 'text': newBox.value, "idBoard": board.hiddenId }; //The arg list for the fetch
                            goFetch(args); //we fetch the SQL to save
                            ev.target.parentNode.classList.remove("specialInputOpen");
                            ev.target.parentNode.parentNode.nextElementSibling.style.display = 'block'; //the menu icon comes back       
                            ev.target.parentNode.textContent = newBox.value;
                        }else{
                            callErrorModal("Le titre ne peux pas d??passer 50 charact??res");
                        }
                    }else{
                        callErrorModal("Le titre de la carte ne peux pas ??tre vide");
                    }
                });
            }
        }
        if (item.hiddenFunc != "archive") {
            cardTitle.addEventListener("click", handlerCard);
        }
    });
    lists.forEach((item) => { //Same as cards, we hide id
        item.hiddenId = item.id;
        if (item.hasAttribute("archive")) {
            item.removeAttribute("archive");
            item.hiddenFunc = "archive";
            item.previousElementSibling.hiddenFunc = "archive";
            item.previousElementSibling.childNodes.forEach(el => {  //we put the attribute on all lists childrens
                el.hiddenFunc = "archive";
                el.childNodes.forEach(el => {
                    el.hiddenFunc = "archive";
                })
            })
        }
        if (item.previousElementSibling.querySelector(".menu")) {
            item.previousElementSibling.querySelector(".menu").hiddenClass = "menu"
        }
        item.hiddenType = "list"; //This attribute is used for drag and drop purpose, to detect what part of the element it is
        item.previousElementSibling.hiddenId = item.id;
        item.previousElementSibling.hiddenType = "list";
        item.previousElementSibling.childNodes.forEach(el => {  //we put the attribute on all lists childrens
            el.hiddenType = "list";
            el.hiddenId = el.parentNode.hiddenId;
            el.childNodes.forEach(el => {
                el.hiddenType = "list";
                el.hiddenId = el.parentNode.hiddenId;
            })
        })
        listTitle = item.previousElementSibling.querySelector(".listTitle"); //We look for the title of each lists
        handlerList = function (ev) { //The function that change the list title into an input, then change it back into a clickable title
            ev.stopImmediatePropagation();
            ev.target.removeEventListener("click",handlerList)
            if(!ev.target.classList.contains("instantInput") && !ev.target.classList.contains("confirmButton")){
                let newBox = document.createElement("input"); //we create a new input
                newBox.setAttribute("type", "text");
                newBox.value = ev.target.textContent
                newBox.classList.add("instantInput");
                let newButton = document.createElement("button"); //we create the confirm button
                newButton.innerHTML = "Valider";
                newButton.hiddenId = ev.target.parentNode.parentNode.hiddenId;
                newButton.classList.add("confirmButton");
                ev.target.parentNode.nextElementSibling.style.display = 'none'; //we hide the menu icon to gain some space
                ev.target.parentNode.oldText = ev.target.innerHTML
                ev.target.innerHTML = ""; //we remove the title
                ev.target.classList.add("specialInputOpen")
                ev.target.appendChild(newBox);
                ev.target.appendChild(newButton);
                newBox.focus();
                newButton.addEventListener("click", (ev) => {
                    if(newBox.value.trim() != ""){
                        if(newBox.value.trim().length < 50){
                            args = { "type": "changeList", 'list': ev.target.hiddenId, 'text': newBox.value, "idBoard": board.hiddenId }; //The arg list for the fetch
                            goFetch(args); //we fetch the SQL to save
                            ev.target.parentNode.classList.remove("specialInputOpen");
                            ev.target.parentNode.parentNode.nextElementSibling.style.display = 'block'; //the menu icon comes back       
                            ev.target.parentNode.textContent = newBox.value;
                        }else{
                            callErrorModal("Le titre ne peux pas d??passer les 50 charact??res")
                        }
                    }else{
                        callErrorModal("Le titre ne peux pas ??tre vide")
                    }
                });
            } 
        }
        if (item.hiddenFunc != "archive") {
            listTitle.addEventListener("click", handlerList);
        }
        if (item.nextElementSibling) {
            item.parentNode.hiddenId = item.hiddenId;
            item.removeAttribute('id');
            item.nextElementSibling.hiddenId = item.hiddenId;
            item.nextElementSibling.hiddenType = "list";
            item.nextElementSibling.addEventListener("click", (ev) => //When we click in the "add card" area
            {
                ev.target.classList.contains("addCard") ? addNewEl(ev.target) : addNewEl(ev.target.parentNode); //if we click on the text or the box itself
            })
        }
        item.previousElementSibling.addEventListener("click", ev => {
            if (ev.target.hiddenType == "list" && ev.target.hiddenClass == "menu") {
                let menu = document.getElementById("listMenu");
                let list = ev.target.parentNode.parentNode;

                if (menu.style.display != "block" || (menu.style.display == "block" && menu.hiddenId != list.hiddenId)) //if the menu is hidden or is open at another place
                {
                    menu.style.display = "block";
                    menu.list = list; //we attach the list id to the menu (passing the arg to the listener)
                    menu.hiddenId = list.hiddenId;
                    let rect = ev.target.getBoundingClientRect(); //we place the menu to the side of the list
                    /*console.log(rect.x)
                    console.log(window.innerWidth)
                    console.log(window.innerWidth - (rect.x + menu.offsetWidth))*/
                    isTooBig = (window.innerWidth - (rect.x + menu.offsetWidth))
                    menu.style.left = isTooBig > 0 ? rect.x + 20 + "px" : menu.style.left = (rect.x + isTooBig - 10) + "px";
                    menu.style.top = rect.y + 20 + "px";

                    menu.firstElementChild.textContent = "Param??tres " + ev.target.previousElementSibling.textContent //We change the title according to the list
                    for (let item of listOptions) //we put an event listener on each menu link
                    {
                        item.list = list;
                        item.addEventListener("click", ev => {
                            let list = ev.currentTarget.list
                            item.hiddenFunc == "archive" ? ev.target.nodeName == "SPAN" ? (archiveEl(list), menu.style.display = "none") : null : null;
                            item.hiddenFunc == "delete" ? ev.target.nodeName == "SPAN" ? (youSure(deleteList,list), menu.style.display = "none") : null : null; //if we click on the delete part and it's actually the pic (not the full LI)
                            item.hiddenFunc == "edit" ? ev.target.nodeName == "SPAN" ? (openEditor(list), menu.style.display = "none") : null : null; // if we click on the edit span, and not the LI
                            ev.stopImmediatePropagation();
                        })
                    };
                }else { //if the menu is shown and click again on the card menu button
                    menu.style.display = "none";
                }
            }
        });
    });
    cards.forEach(item => item.addEventListener("click", (ev) => //Event for when we're gonna click on the cards
    {
        if(ev.target.classList.contains("cardBody") || ev.target.parentNode.classList.contains("cardBody")) { // When we click on the body, we open the editor
            openEditor(item);
        } else if (ev.target.hiddenType == "card" && ev.target.hiddenClass == "menu") { //if we click on the card menu button
            let menu = document.getElementById("cardMenu");
            let card = ev.target.parentNode.parentNode;
            if (menu.style.display != "block" || (menu.style.display == "block" && menu.hiddenId != card.hiddenId)) //if the menu is hidden or is open at another place
            {
                menu.style.display = "block";
                menu.hiddenId = card.hiddenId; //we attach the card id to the menu (passing the arg to the listener)
                let rect = ev.target.getBoundingClientRect(); //we place the menu to the side of the card
                isTooBig = (window.innerWidth - (rect.x + menu.offsetWidth))
                menu.style.left = isTooBig > 0 ? rect.x + 20 + "px" : menu.style.left = (rect.x + isTooBig - 10) + "px";
                menu.style.top = rect.y + 20 + "px";
                menu.firstElementChild.textContent = "Param??tres " + ev.target.previousElementSibling.textContent //We change the title according to the card
                for (let item of options) //we put an event listener on each menu link
                {
                    item.card = card; //we attach the card to the links for the listener
                    item.addEventListener("click", ev => {
                        let card = ev.currentTarget.card
                        item.hiddenFunc == "archive" ? ev.target.nodeName == "SPAN" ? (archiveEl(card), menu.style.display = "none") : null : null;
                        item.hiddenFunc == "delete" ? ev.target.nodeName == "SPAN" ? (youSure(deleteCard,card) ? null : null , menu.style.display = "none") : null : null;
                        //item.hiddenFunc == "delete" ? ev.target.nodeName == "IMG" ? (deleteCard(card), menu.style.display = "none") : null : null; //if we click on the delete part and it's actually the pic (not the full LI)
                        item.hiddenFunc == "edit" ? ev.target.nodeName == "SPAN" ? (openEditor(card), menu.style.display = "none") : null : null; // if we click on the edit span, and not the LI
                        ev.stopImmediatePropagation();
                    })
                };
            } else { //if the menu is shown and click again on the list menu button
                menu.style.display = "none";
            }
        }
    }));
    newListButton.addEventListener("click", (ev) => {
        ev.target.parentNode.hiddenId = board.hiddenId; // we pass the id to the target to then pass it to the new elements 
        addNewEl(ev.target.parentNode); //function that replace the text element by an input and a button, then we can save the datas
    });
    archive.addEventListener("click", ev => {
        arch = document.querySelector(".listContainer:last-child");
        arch.style.display == "block" ? (arch.style.display = "none", ev.target.classList.remove("purpleBorder")) : (arch.style.display = "block", ev.target.classList.add("purpleBorder"))
    });
    archiveList.forEach(list => {
        list.hiddenId = list.id;
        list.removeAttribute("id");
        if(list.querySelector(".delete")){
            list.querySelector(".delete").addEventListener("click", ev => {
                function findParentId(el){
                    return el.hiddenId ? el.hiddenId : findParentId(el.parentNode)
                }
                youSure(archiveDeleteList,findParentId(ev.target));
            })
        }
        
    });
    if(deleteBoardButton){
        deleteBoardButton.addEventListener("click", ev => {
            youSure(deleteBoard,board.hiddenId,"La suppression du tableau est d??finitive, ??tes vous s??r?");
        })
    }
    if(document.getElementById("creator")){
        let creatorDiv = document.getElementById("creator")
        document.querySelector("#listUser > .icon").removeChild(creatorDiv)
        document.querySelector("#listUser > .icon").prepend(creatorDiv) //We put the creator in the front of the user list
    }   
    if(user){
        for (let user of userIcons) { //We create the menu when we click on the user
            user.addEventListener("click", ev =>{
                if(document.querySelector(".userIcon")){
                    document.querySelector(".userIcon").outerHTML="";
                }
                uiMenu = document.createElement("div");
                uiMenu.classList.add("modalMenu");
                uiMenu.classList.add("userIcon");
                document.querySelector("body").appendChild(uiMenu)
                uiTitle = document.createElement("p")
                mail = ev.target.querySelector(".tooltiptext").lastChild.textContent;
                uiTitle.innerHTML = "Param??tres <br>'" + mail + "'"
                uiTitle.classList.add("userIcon");
                uiMenu.appendChild(uiTitle);
                uiDelete = document.createElement("span");
                uiDelete.textContent = "Retirer du tableau"
                uiDelete.classList.add("userIcon");
                uiDelete.mail = mail;
                uiMenu.appendChild(uiDelete);
                let rect = ev.target.getBoundingClientRect(); //we place the menu to the side of the card
                isTooBig = (window.innerWidth - (rect.x + uiMenu.offsetWidth))
                uiMenu.style.left = isTooBig > 0 ? rect.x + 20 + "px" : menu.style.left = (rect.x + isTooBig - 10) + "px";
                uiMenu.style.top = rect.y + 20 + "px";
                uiMenu.style.display = "block";
                uiDelete.addEventListener("click", ev => {
                    youSure(removeInvitedUser,ev.target.mail)
                })
            })
        }
    }
}
function isBusy(status) //Stop or start the sync reload
{
    //console.log(timerChecks.length)
    if( timerChecks.length !== 0){
        //console.log("busy")
        timerChecks.forEach(clearInterval)
        timerChecks = [];
    }
    if(!status){
        //console.log("not busy")
        timerCheck = setInterval(() => {
            args = { "type": "checkChange", 'board': board.hiddenId };
            goFetch(args);
        }, timeToReload);
        timerChecks.push(timerCheck)
    }
}
function openEditor(el)// Function that open the card editor
{
    let modal = document.getElementById("cardDetail");
    
    modal.querySelector(".modalMenu").firstElementChild.textContent = el.querySelector(".cardHeader").firstElementChild.textContent //e change the menu title to match the card title
    modal.style.display = "block";
    modal.el = el //again we pass the el here to grab it again in the listeners
    textarea = modal.querySelector("#cardDescription");
    textarea.value = el.originalText; // we put the text from the description into the textarea
    modal.color = el.querySelector(".cardHeader").getAttribute("style").split(':')
    modal.color = modal.color[modal.color.indexOf("background-color") + 1]
    modal.querySelector("input").value = modal.color;
    for (let item of cardOptions) //We put a listener on each editor link 
    {
        item.card = el;
        item.addEventListener("click", ev => {
            ev.stopImmediatePropagation();
            if(ev.target.hiddenFunc == "delete"){
                youSure(deleteCard,ev.target.card)
                modal.style.display = "none";
            }
        })
    }

    if(el.files){
        div = document.createElement("DIV");
        div.id ='modalFile';
        modal.querySelector("li:last-child").appendChild(div)
        el.files.forEach(file => {
            a = document.createElement("a");
            a.setAttribute("href",file.relPath);
            a.setAttribute("target","_blank");
            a.innerHTML = file.name;
            a.classList.add("files");
            deleteButton = document.createElement("span")
            div.appendChild(deleteButton)
            deleteButton.innerHTML = 'X';
            deleteButton.fileName= file.name
            div.appendChild(a)
            if(file.type.split('/')[0] == 'image'){
                img = document.createElement("IMG")
                img.height = 50;
                img.setAttribute('src',file.relPath)
                a.appendChild(img)
            }else{
                a.setAttribute("download",file.relPath)
            }
            icon = document.createElement("IMG")
            icon.height = 20;
            icon.setAttribute('src','../Assets/img/file.png')
            a.prepend(icon)
            deleteButton.addEventListener("click", ev =>{
                args = { "type": "deleteFile", 'card': modal.el, "idBoard": board.hiddenId,  'fileName': ev.target.fileName}; //the args for the fetch
                youSure(goFetch,args,"Voulez vous vraiment supprimer le fichier: ".ev.target.fileName);
            })
        });
        
    }
    modal.querySelector("button").addEventListener("click", ev => {
        args = { "type": "editCardDesc", 'card': modal.el, "text": textarea.value, "idBoard": board.hiddenId, 'color': modal.querySelector("input").value , 'file': modal.querySelector('#file').files}; //the args for the fetch
        ev.stopImmediatePropagation();
        if(textarea.value.length < 500) //We limite the length to 500 char for now, need more testing
        {
            goFetch(args); //we fetch the SQL to save
            modal.el.querySelector(".cardHeader").setAttribute("style","background-color:"+modal.querySelector("input").value)
            bodyText = document.createElement("p")
            bodyText.textContent = textarea.value.length > 200 ? textarea.value.substring(0, 200) + "..." : textarea.value;
            modal.el.querySelector(".cardBody").innerHTML = "";
            modal.el.querySelector(".cardBody").appendChild(bodyText);
            modal.el.originalText = textarea.value;
            modal.style.display = "none";
            modal.querySelector("#modalFile").outerHTML = "";
        }else{
            callErrorModal("La description est limit??e ?? 500 charact??res (Actuellement : " + textarea.value.length + ")")
        }
        
    })
}
function addNewEl(el) // Function that add a new list or card
{
    isBusy(true);
    let newBox = document.createElement("input"); //new input 
    newBox.setAttribute("type", "text");
    newBox.setAttribute("placeholder", "Enter a title here");
    newBox.classList.add("instantInput");
    let newButton = document.createElement("button");//new button
    newButton.innerHTML = "Confirm";
    newBox.hiddenId = el.hiddenId;
    newButton.hiddenId = el.hiddenId; // we attach the id to get it back in the listener
    newButton.classList.add("confirmButton");
    el.firstChild.parentNode.oldText = el.firstChild.parentNode.innerHTML //we save the text if we close it by clicking away
    el.firstChild.innerHTML = "";
    el.firstChild.appendChild(newBox); // we append the input and the button
    el.firstChild.appendChild(newButton);
    newBox.focus();
    newButton.parentNode.classList.add("inputOpen")
    //newButton.parentNode.hiddenStatus = "inputOpen"
    el.style.opacity = 1;
    newButton.addEventListener("click", ev => { //when we click on the button we look at the class to see if it's a card or a list, then we fetch to save and reload
        let el = ev.target.previousElementSibling
        let elText = el.value;
        if (el.parentNode.parentNode) {
            args = el.parentNode.parentNode.classList.contains("addCard") ? { "type": "newCard", 'card': el, "idBoard": board.hiddenId } : { "type": "newList", 'list': el }
        } else {
            args = { "type": "newList", 'list': el };
        }
        if (elText.trim() !== "") { //if the text is not empty and less than 50 char we save it
            elText.trim().length <50 ? goFetch(args) : callErrorModal("Le titre ne peux pas d??passer 50 charact??res");
            isBusy(false);
        } else {
            callErrorModal("Le titre ne peux pas ??tre vide");
        }
    })
}
function deleteCard(el) { //Function to delete a card
    let card = el.hiddenId
    let list = el.parentNode.querySelectorAll(".card") ;
    listArray = [...list]; //we transform the htmlCollection into an array to use indexOf to get the position of the item in the list
    pos = listArray.indexOf(el); 
    let args = {
        "type": "deleteCard",
        "el": card,
        "pos": pos,
        "list": el.parentNode.hiddenId,
        "idBoard": board.hiddenId
    };
    goFetch(args)
}
function archiveDeleteList(id) { // Function to definitely delete a list (from archive only)
    let args = {
        "type": "archiveDeleteList",
        "idList": id,
        "board": board.hiddenId
    };
    goFetch(args)
}
function deleteBoard(id) { // Function to definitely delete a list (from archive only)
    let args = {
        "type": "deleteBoard",
        "board": id
    };
    goFetch(args)
}
function removeInvitedUser(mail) { // Function to definitely delete a list (from archive only)
    let args = {
        "type": "removeInvitedUser",
        "mail": mail
    };
    creator == mail ? callErrorModal("Vous ne pouvez pas retirer le createur du tableau") : goFetch(args) ;
}
function deleteList(el) { // Function to delete a list 
    let list = el.parentNode.querySelectorAll(".listContainer");
    listArray = [...list];
    pos = listArray.indexOf(el); //we transform the htmlCollection into an array to use indexOf to get the position of the list in the board
    let args = {
        "type": "deleteList",
        "el": el,
        "pos": pos,
        "board": el.parentNode.hiddenId
    };
    goFetch(args)
}
function goFetch(args) // function that fetch the board content depending on the args
{
    myHeaders = new Headers(); //If we want custom headers
    let formData = new FormData(); //We append the POST data here
    if (args["type"]) {
        formData.append('act', args['type']) //The action is saved in POST so nobody can mess by typing directly the link
        switch (args['type']) {
            case "newCard":
                formData.append('text', args['card'].value) //We pass all the users inputs in POST
                link = "board.php?list=" + args['card'].hiddenId + "&board=" + args["idBoard"];
                break
            case "newList":
                formData.append('text', args['list'].value)
                link = "board.php?board=" + args['list'].hiddenId;
                break
            case "moveList":
                formData.append('isArchive', args["el"].hiddenFunc ? true : false);
                link = "board.php?list=" + args["el"].hiddenId + "&listPos=" + args["pos"] + "&board=" + args["idBoard"];
                break
            case "moveCard":
                if (!args["el"].oldList) { //Means that we click on 'Archiver'
                    args["el"].oldList = args["el"].actualList;
                    listId = args["el"].listId
                    formData.append('isArchive', true);
                } else {
                    listId = args["el"].parentNode.hiddenId
                    formData.append('isArchive', args["el"].parentNode.hiddenFunc ? true : false); //if we drag a card into the Archive list
                }
                link = "board.php?list=" + listId + "&pos=" + args["pos"] + "&card=" + args["el"].hiddenId + "&oldList=" + args["el"].oldList + "&board=" + args["idBoard"];
                break
            case "deleteCard":
                link = "board.php?card=" + args["el"] + "&pos=" + args["pos"] + "&list=" + args["list"] + "&board=" + args["idBoard"];
                break;
            case "deleteList":
                link = "board.php?list=" + args["el"].hiddenId + "&pos=" + args["pos"] + "&board=" + args["board"];
                break
            case "archiveDeleteList":
                link = "board.php?list=" + args["idList"] + "&board=" + args["board"];
                break
            case "changeBoard":
                formData.append("text", args['text'])
                link = "board.php?board=" + args["board"].hiddenId; //the link for changing the board title
                break
            case "changeList":
                formData.append("text", args['text'])
                link = "board.php?list=" + args["list"] + "&board=" + args["idBoard"]; //the link for changing the board title
                break
            case "changeCard":
                formData.append("text", args['text'])
                link = "board.php?card=" + args["card"] + "&board=" + args["idBoard"]; //the link for changing the board title
                break
            case "editCardDesc":
                formData.append("text", args['text'])
                formData.append("color", args['color'])
                formData.append("file", args['file'][0])
                link = "board.php?card=" + args["card"].hiddenId + "&board=" + args["idBoard"] ; //the link for changing the card description
                break
            case "deleteFile":
                formData.append("fileName", args['fileName'])
                link = "board.php?card=" + args["card"].hiddenId + "&board=" + args["idBoard"] ; //the link for changing the card description
                break
            case "invite":
                formData.append("mail", args['mail'])
                link = "board.php?&board=" + args["idBoard"]; //the link for changing the card description
                break
            case "deleteBoard":
                link = "board.php?&board=" + args["board"];
                break
            case "removeInvitedUser":
                formData.append("mail", args['mail'])
                link = "board.php?&board=" + board.hiddenId;
                break
            case "checkChange":
                formData.append("time", lastChangeTime)
                link = "board.php?id=" + args["board"];
                break
            case "reload":
                link = "board.php?id=" + args["board"];
                break
            default:
                link = null;
        }
    } else {
        link = null;
        //console.log("goFetch need a type to operate");
    }
    let myInit = {
        method: 'POST', //Fetch settings
        headers: myHeaders,
        mode: 'cors',
        cache: 'default',
        body: formData
    };
    //console.log(link)
    if (link) {
        let myRequest = new Request(link, myInit); //We prepare the fetch request with settings and our link destination
        fetch(myRequest).then((response) => { //We fetch the result
            response.text().then(response => {
                if (args["type"] != "reload") { //if we reload we dn't show the whole thing in console
                console.log(response) //My check of the controler response
                }
                error = response.split(":");
                if (response === 'false') {  //If the controler writes 'false' , i know it's shit but i haven't found out how to return a boolean with fetch
                    console.log("Probl??me de param??tres");
                }else if (error[0] === 'error') {
                    callErrorModal(error[1]);
                }else if (error[0] === 'relocate') {
                    window.location.href=error[1];
                }else {
                    document.getElementById("error").innerHTML = "";
                    if (args["type"] == "reload") { //if we called the reload
                        document.getElementsByTagName("main")[0].outerHTML = response; // we get the text in the response and paste it in the main to refresh actual board
                        init();
                        //console.log("good reload")
                    } else {
                        console.log("good doggy")
                    }
                    //if everything went okay and we got no errors
                    error[0] === 'success' ? callSuccessModal(error[1]) : null;
                    isArchive = args["el"] ? (args["el"].hiddenFunc == "archive") : false;
                    if (args["type"] == "newCard" || args["type"] == "deleteFile" || args["type"] == "deleteCard" || args["type"] == "newList" || args["type"] == "deleteList" || isArchive || args["type"] == "archiveDeleteList" ||args["type"] == "editCardDesc" || response ==="reload") { //we reload in thoses cases
                        args = { "type": "reload", 'board': board.hiddenId };
                        goFetch(args);
                    }
                }
            })
            if (!response.ok) { // If fetch failed somehow , maybe permission? dunno
                //console.log("Mauvaise r??ponse du r??seau")
            }
        })
    } else {
        //console.log("Link null")
    }
}
function findParentList(el) //Function made to find the list starting from a child (a card)
{
    let target = null
    if (el) {
        if (el.hiddenType || el.classList.contains("list")) { //if the item got an hidden type corresponding to card, we go 1 parent higher
            if (el.hiddenType == "card") {
                if (el.parentNode) {
                    target = findParentList(el.parentNode)
                }
            } else {
                target = el
            }
        }
    }
    return target
}
function getDraggedParent(el) //Function to get the parent of the element dragged into (for dragging limitation)
{
    let target = null
    if (el) {
        if (el.isCard) {
            target = el;
        } else if (el.classList && (el.classList.contains("list") || el.classList.contains("listHeader") || el.classList.contains("addCard"))) {
            target = el;
        } else {
            target = getDraggedParent(el.parentNode)
        }
    }
    return target;
}
function archiveEl(el) {
    if (el.firstChild.hiddenType == "list") {
        type = "moveList";
        item = el.parentNode.querySelectorAll(".listContainer");
        target = document.querySelector(".board")
        elem = el.querySelector(".list")
    } else if (el.firstChild.hiddenType == "card") {
        type = "moveCard";
        target = el.parentNode;
        el.actualList = el.parentNode.hiddenId;
        elem = el;
    }
    el.hiddenFunc = "archive";
    list = target.querySelectorAll("." + el.firstChild.hiddenType);
    listArray = [...list];
    pos = listArray.indexOf(elem);
    let args = { "type": type, "el": el, "pos": pos, "idBoard": board.hiddenId };
    el.listId = document.querySelector(".listContainer:last-child").firstElementChild.hiddenId
    goFetch(args);
}

function events() { //all my general events
    document.addEventListener("dragstart", function (ev) { //Event trigger when we start dragging
        isBusy(true);
        if (ev.target && (ev.target.hiddenType == "list" || ev.target.hiddenType == "card")) //If we drag something && we drag a card || we drag a list
        {
            draggedElement = ev.target; //For better clarity
            if (draggedElement.hiddenType == "card") {
                draggedElement.style.backgroundColor = "lightgray";
                draggedElement.oldList = draggedElement.parentNode.hiddenId //We save the old list position
                ev.dataTransfer.setDragImage(draggedElement, -10, -10);
            } else if (draggedElement.classList.contains('listHeader')) { //Nothing to do in it for now
                draggedElement.style.backgroundColor = "#2C233F";
                draggedElement.style.color = "white";
                ev.dataTransfer.setDragImage(draggedElement.parentNode, 0, 0);
            }
        } else {
            draggedElement = null;
        }
    });
    document.addEventListener("dragenter", function (ev) { //Even start when the dragged target enter an element
        ev.stopImmediatePropagation();
        if (ev.target && (ev.target.hiddenType == "card" || ev.target.hiddenType == "list" || ev.target.classList.contains('listHeader')) && draggedElement) //If we drag into something && we drag into a card || we drag into a list
        {
            draggedInto = getDraggedParent(ev.target);
            if (draggedInto.hiddenType == "list") //if we drag into a list
            {
                if (!draggedElement.classList.contains("listHeader") && !draggedInto.classList.contains("listHeader") && !draggedInto.classList.contains("addCard")) { //if we drag something else than a list (can only be a card)
                    draggedInto.appendChild(draggedElement); //If the card is dragged over a list we attach it to the end of the list (kinda like a preview)
                }
            }
            if (draggedInto.hiddenId !== draggedElement.hiddenId && !draggedElement.classList.contains("listHeader") && draggedInto.hiddenType == "card") { //D&D code for card dragging
                let ep = draggedInto.previousElementSibling;
                let en = draggedInto.nextElementSibling;
                let dp = draggedElement.previousElementSibling;
                let dn = draggedElement.nextElementSibling;
                if (!ep && !dn) {
                    draggedInto.insertAdjacentElement("beforebegin", draggedElement);
                }
                else if (!en && !dp) {
                    draggedInto.insertAdjacentElement("afterend", draggedElement);
                }
                else if (ep && ep != draggedElement) {
                    ep.insertAdjacentElement("afterend", draggedElement);
                    draggedElement.insertAdjacentElement("afterend", draggedInto);
                }
                else if (!ep) {
                    draggedInto.insertAdjacentElement("beforebegin", draggedElement);
                }
                else if (en && en != draggedElement) {
                    en.insertAdjacentElement("beforebegin", draggedElement);
                    draggedElement.insertAdjacentElement("beforebegin", draggedInto);
                }
                else if (!en) {
                    dp.insertAdjacentElement("afterend", draggedInto);
                }
            }
            if (draggedInto.hiddenId !== draggedElement.hiddenId && draggedInto.hiddenFunc != "archive" && draggedElement.classList.contains("listHeader") && (draggedInto.hiddenType == "list" || draggedInto.classList.contains("listHeader"))) { //D&D code for list dragging
                draggedIntoContainer = draggedInto.classList.contains("card") ? draggedInto.parentNode.parentNode : draggedInto.parentNode;
                draggedParent = draggedElement.parentNode;
                let dip = draggedIntoContainer.previousElementSibling;
                let din = draggedIntoContainer.nextElementSibling;
                let dpp = draggedParent.previousElementSibling;
                let dpn = draggedParent.nextElementSibling;
                if (!dip && !dpn) {
                    draggedIntoContainer.insertAdjacentElement("beforebegin", draggedParent);
                }
                else if (!din && !dpp) {
                    draggedIntoContainer.insertAdjacentElement("afterend", draggedParent);
                }
                else if (dip && dip != draggedParent) {
                    dip.insertAdjacentElement("afterend", draggedParent);
                    draggedParent.insertAdjacentElement("afterend", draggedIntoContainer);
                }
                else if (!dip) {
                    draggedIntoContainer.insertAdjacentElement("beforebegin", draggedParent);
                }
                else if (din && din != draggedParent) {
                    dip.insertAdjacentElement("beforebegin", draggedParent);
                    draggedParent.insertAdjacentElement("beforebegin", draggedIntoContainer);
                }
                else if (!din) {
                    dpp.insertAdjacentElement("afterend", draggedIntoContainer);
                }
            }
        }
    });
    document.addEventListener("dragleave", function (ev) {
        ev.preventDefault();
    });
    document.addEventListener("dragover", function (ev) {
        ev.preventDefault();
    });
    document.addEventListener("drop", function (ev) {
        isBusy(false);
        if (!draggedElement) { //if we drag something not authorized , we stop everythin
            return;
        }
        draggedElement.style.backgroundColor = "";
        draggedElement.style.color = "#2C233F";
        if (ev.target && (ev.target.hiddenType == "card" || ev.target.classList.contains("board") || ev.target.hiddenType == "list")) { //we make sure to limit where we can drop items
            ev.preventDefault();
            if (draggedElement.classList.contains("card")) { //if we drag a card into a board we stop the code (nothing happens)
                if (ev.target.hiddenType != "card" && !ev.target.classList.contains("list") && !ev.target.classList.contains("cardHeader")) {
                    return;
                }
            }
            if (draggedElement.classList.contains("card")) {
                target = findParentList(ev.target);
            } else {
                target = document.querySelector(".board") //if the list is dragged , we only have one board
            }
            let type = null;
            if (draggedElement.classList.contains("card")) {
                elClass = "card"
            } else if (draggedElement.classList.contains("listHeader")) {
                elClass = "list"
            }
            el = draggedElement.classList.contains("listHeader") ? draggedElement.nextElementSibling : draggedElement
            type = draggedElement.classList.contains("listHeader") ? "moveList" : "moveCard"
            list = target.querySelectorAll("." + elClass);
            listArray = [...list];
            pos = listArray.indexOf(el);
            let args = { "type": type, "el": el, "pos": pos, "idBoard": board.hiddenId };
            goFetch(args);
        }
    });
    document.addEventListener("click", ev => { //Function to "close" elements that are still open
        let elList = document.getElementsByClassName("inputOpen")
        let elSpecialList = document.getElementsByClassName("specialInputOpen")
        if (elList.length > 0 || elSpecialList.length > 0) {
            let el = ev.target;
            let toClose = null;
            toClose = el.closest("#addList >span:first-child") ? el.closest("#addList >span:first-child") : toClose;
            toClose = el.closest(".addCard") ? el.closest(".addCard") : toClose;
            toClose = el.closest(".listTitle") ? el.closest(".listTitle") : toClose;
            toClose = el.closest(".cardTitle") ? el.closest(".cardTitle") : toClose;
            if (!toClose) {
                isBusy(false);
                for (let item of elList) {
                    item.classList.remove("inputOpen")
                    item.parentElement.innerHTML = item.parentNode.oldText;
                }
                for (let item of elSpecialList) {
                    item.classList.remove("specialInputOpen")
                    item.innerHTML = item.parentNode.oldText;
                    item.parentNode.nextElementSibling.style.display = "block"
                }
            }
        }
        let menu = document.getElementById("cardMenu");
        if (!ev.target.classList.contains("modalMenu") && !ev.target.classList.contains("menu")) {
            menu.style.display = "none";
        }
        menu = document.getElementById("cardDetail");
        if (!ev.target.classList.contains("modalMenu") && ev.target.id == "cardDetail") {
            menu.style.display = "none";
            $file = menu.querySelector("#modalFile")
            menu.querySelector("#modalFile") ? menu.querySelector("#modalFile").outerHTML = "" : null;
        }
        menu = document.getElementById("listMenu");
        if (!ev.target.classList.contains("modalMenu") && !ev.target.classList.contains("menu")) {
            menu.style.display = "none";
        }
        menu = document.querySelector(".userIcon");
        if (!ev.target.classList.contains("userIcon") && !ev.target.classList.contains("tooltip")) {
            if(menu){
                menu.outerHTML="";
            }
        }
    });
}
init();
events();