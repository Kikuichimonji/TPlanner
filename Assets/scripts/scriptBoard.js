let cards = null
let lists = null
let board = null
let draggedElement = null;
let newListButton = null;
let boardTitle = null;
let okayToClose = false;
let options = null;
let cardOptions = null;
let target = null;
const stripHTML = (unsafe) => {
    return unsafe.replace(/(<([^>]+)>)/gi, "");

}

function init(){

    cards = document.querySelectorAll(".card");
    lists = document.querySelectorAll(".list");;
    board = document.querySelector(".board");
    board.hiddenId = board.id;
    board.removeAttribute("id");
    document.querySelector("main").removeAttribute("id")
    options = document.getElementById("cardMenu").getElementsByTagName("li")
    for(let item of options){
        
        item.hiddenFunc = item.getAttribute("func");
        item.removeAttribute("func")
    }
    cardOptions = document.getElementById("cardDetail").getElementsByTagName("li")
    for(let item of cardOptions){
        item.hiddenFunc = item.getAttribute("func");
        item.removeAttribute("func")
    }

    newListButton = document.getElementById("addList");
    boardTitle = document.querySelector("#leftside div div:first-child");

    /*document.addEventListener("click", (ev) =>{
        //console.log(document.contains(ev.target))
    })*/

    handler = function (ev){
        
        let newBox = document.createElement("input");
        newBox.setAttribute("type","text");
        newBox.value = ev.target.textContent
        newBox.classList.add("instantInput");

        let newButton = document.createElement("button");
        newButton.innerHTML = "Valider";
        newButton.hiddenId = board.hiddenId;
        newButton.classList.add("confirmButton");

        
        ev.target.parentNode.appendChild(newBox)
        ev.target.parentNode.appendChild(newButton)
        ev.target.outerHTML = ""
        newBox.focus();
        ev.target.removeEventListener("click",handler);
        newButton.addEventListener("click", (ev) => {
            args = {"type" : "changeBoard", 'board' : ev.target, 'text' : newBox.value};
            goFetch(args)
            myDiv = document.createElement("div")
            myDiv.innerHTML = newBox.value;
            ev.target.parentNode.innerHTML = myDiv.outerHTML
            boardTitle = document.querySelector("#leftside div div:first-child");
            boardTitle.addEventListener("click", handler);
        });
    };

    boardTitle.addEventListener("click", handler);
    


    cards.forEach((item)=>{ // We hide the id in a parameter so people can't mess with the positions
        item.hiddenId = item.id;
        item.hiddenType = "card";
        item.removeAttribute('id');
        item.querySelector(".menu").hiddenClass = "menu"
        item.childNodes.forEach(child => {
            child.hiddenType = "card";
            child.childNodes.forEach(child => {
                child.hiddenType = "card";
            })
        })
    });

    lists.forEach((item)=>{
        item.hiddenId = item.id;
        item.hiddenType = "list";
        item.previousElementSibling.hiddenId = item.id;
        item.previousElementSibling.hiddenType = "list";
        item.previousElementSibling.childNodes.forEach(el => {
            el.hiddenType = "list";
            el.childNodes.forEach(el => {
                el.hiddenType = "list";
            })
        })

        listTitle = item.previousElementSibling.querySelector(".picto").nextElementSibling

        handlerList = function (ev){
            let newBox = document.createElement("input");
            newBox.setAttribute("type","text");
            newBox.value = ev.target.textContent
            newBox.classList.add("instantInput");

            let newButton = document.createElement("button");
            newButton.innerHTML = "Valider";
            newButton.hiddenId = ev.target.parentNode.parentNode.hiddenId;
            newButton.classList.add("confirmButton");

            ev.target.parentNode.nextElementSibling.style.display= 'none';
            ev.target.parentNode.appendChild(newBox)
            ev.target.parentNode.appendChild(newButton)
            ev.target.outerHTML = ""
            newBox.focus();
            ev.target.removeEventListener("click",handlerList);
            newButton.addEventListener("click", (ev) => {
                args = {"type" : "changeList", 'list' : ev.target.hiddenId, 'text' : newBox.value};
                goFetch(args)
                mySpan = document.createElement("span")
                mySpan.innerHTML = newBox.value;
                ev.target.parentNode.appendChild(mySpan)
                ev.target.previousElementSibling.outerHTML = "";
                ev.target.outerHTML = "";
                mySpan.addEventListener("click", handlerList);
                mySpan.parentNode.nextElementSibling.style.display= 'block';
            });
        }

        listTitle.addEventListener("click", handlerList)
        

        item.parentNode.hiddenId = item.hiddenId;
        item.removeAttribute('id');
        item.nextElementSibling.hiddenId = item.hiddenId;
        item.nextElementSibling.hiddenType = "list";
        item.nextElementSibling.addEventListener("click", (ev) =>
        {
            ev.target.classList.contains("addCard") ? addNewEl(ev.target) : addNewEl(ev.target.parentNode);
        })
        item.previousElementSibling.addEventListener("click", (ev) => {
            if(ev.target.nodeName=="IMG"){
                deleteList(ev.target.parentNode.parentNode.parentNode);
            }
            
        })
    });

    cards.forEach(item => item.addEventListener("click", (ev) => //Event for when we're gonna click on the cards
    {
        if(ev.target.classList.contains("cardBody")){
            openEditor(item);
            /*cards.forEach((item) => {
                item.className = "card";
            })
            ev.target.parentNode.className = "card active";*/


        }else if(ev.target.classList.contains("menu") && ev.target.hiddenClass == "menu"){
            let menu = document.getElementById("cardMenu");
            let card = ev.target.parentNode.parentNode;
            
            if(menu.style.display != "block" || (menu.style.display == "block" && menu.hiddenId != card.hiddenId))
            {
                menu.style.display = "block";
                menu.hiddenId = card.hiddenId
                let rect = ev.target.getBoundingClientRect();
                menu.style.left = rect.x + 20 +"px";
                menu.style.top = rect.y + 20 +"px";
                menu.firstElementChild.innerHTML = "Paramètres "+ ev.target.previousElementSibling.innerHTML
                for(let item of options)
                {
                    item.card = card
                    item.addEventListener("click", ev => {
                        let card = ev.currentTarget.card
                        item.hiddenFunc == "delete" ?  ev.target.nodeName=="IMG" ? (deleteCard(card),menu.style.display = "none") : null : null;
                        item.hiddenFunc == "edit" ?  ev.target.nodeName=="SPAN" ? (openEditor(card),menu.style.display = "none") : null : null;
                        ev.stopImmediatePropagation();
                    })
                    
                };
            }else{
                menu.style.display = "none";
            }
            
            //console.log(ev.target.parentNode.parentNode.parentNode)
            //
        }
    }));
    newListButton.addEventListener("click", (ev) =>
    {
        ev.target.parentNode.hiddenId = board.hiddenId 
        //console.log(ev.target)
        addNewEl(ev.target.parentNode);
    });
    
}
function openEditor(el)
{
    let modal = document.getElementById("cardDetail");
    //console.log(el)
    modal.querySelector(".modalMenu").firstElementChild.textContent = el.querySelector(".cardHeader").firstElementChild.textContent
    modal.style.display = "block";
    modal.el = el
    textarea = modal.querySelector("#cardDescription")
    textarea.value = el.querySelector(".cardBody").textContent
    for(let item of cardOptions)
    {
        item.addEventListener("click", ev => {
            console.log(ev.target)
            ev.stopImmediatePropagation();
        })
    }
    modal.querySelector("button").addEventListener("click", ev => {
        args = {"type" : "editCardDesc", 'card' : modal.el, "text" :textarea.value};
        ev.stopImmediatePropagation();
        //console.log(modal.el)
        goFetch(args);
        modal.el.querySelector(".cardBody").textContent = stripHTML(textarea.value);
        modal.style.display = "none";
    })
}

function addNewEl(el)
{

    let newBox = document.createElement("input");
    newBox.setAttribute("type","text");
    newBox.setAttribute("placeholder","Enter a title here");
    newBox.classList.add("instantInput");

    let newButton = document.createElement("button");
    newButton.innerHTML = "Confirm";
    newBox.hiddenId = el.hiddenId;
    newButton.hiddenId = el.hiddenId;
    newButton.classList.add("confirmButton");

    el.firstChild.parentNode.oldText = el.firstChild.parentNode.innerHTML
    el.firstChild.innerHTML = "" ;
    el.firstChild.appendChild(newBox);
    el.firstChild.appendChild(newButton);
    newBox.focus();

    newButton.parentNode.classList.add("inputOpen")
    newButton.parentNode.hiddenStatus = "inputOpen"

    
    el.style.opacity = 1;
    newButton.addEventListener("click", ev =>{
        let el = ev.target.previousElementSibling
        let elText = el.value;
        
        if(el.parentNode.parentNode){
            
            args = el.parentNode.parentNode.classList.contains("addCard") ? {"type" : "newCard", 'card' : el} : {"type" : "newList", 'list' : el}
        }else{
            args = {"type" : "newList", 'list' : el};
        }
            
        if(elText !== ""){
            //console.log(args)
            goFetch(args)
        }else{
            console.log("Please enter a name")
        }
        //console.log("he clicked")
        
    })
}

function deleteCard(el){
    let card = el
    let list = el.parentNode.querySelectorAll(".card");
    listArray = [... list];
    pos = listArray.indexOf(el);
    //console.log(list)
    let args = {"type" : "deleteCard",
                "el" : card,
                "pos"  : pos,
                "list" : el.parentNode.hiddenId};
    goFetch(args)
}

function deleteList(el){

    let list = el.parentNode.querySelectorAll(".listContainer");
    //console.log(list)
    listArray = [... list];
    pos = listArray.indexOf(el);
    let args = {"type" : "deleteList",
                "el" : el,
                "pos"  : pos,
                "board" : el.parentNode.hiddenId};

    //console.log(args);
    goFetch(args)
}

function goFetch(args)
{

    myHeaders = new Headers(); //If we want custom headers
    let formData = new FormData();
    

    if(args["type"]){
        formData.append('act',args['type'])
        switch(args['type']) {
            case "newCard" :
                el = args['card']
                formData.append('text',el.value)
                link = "board.php?list=" + el.hiddenId; //the link for a new card
                break
            case "newList" :
                el = args['list']
                formData.append('text',el.value)
                link = "board.php?board="+ el.hiddenId; //the link for a new list
                break
            case "moveList" :
                link = "board.php?list=" + args["el"].hiddenId + "&listPos=" + args["pos"] ; //the link for moving lists
                break
            case "moveCard" :
                link = "board.php?list=" + args["el"].parentNode.hiddenId + "&pos=" + args["pos"] + "&card=" + args["el"].hiddenId + "&oldList="+args["el"].oldList; //the link for moving cards
                break
            case "deleteCard" :
                link = "board.php?card=" + args["el"].hiddenId + "&pos=" + args["pos"] + "&list=" + args["list"] ; //the link for deleting a card
                break
            case "deleteList" :
                link = "board.php?list=" + args["el"].hiddenId + "&pos=" + args["pos"] + "&board=" + args["board"] ; //the link for Deleting a list
                break
            case "changeBoard" :
                formData.append("text",args['text'])
                link = "board.php?board=" + args["board"].hiddenId ; //the link for changing the board title
                break
            case "changeList" :
                formData.append("text",args['text'])
                link = "board.php?list=" + args["list"] ; //the link for changing the board title
                break
            case "editCardDesc" :
                formData.append("text",args['text'])
                link = "board.php?card=" + args["card"].hiddenId ; //the link for changing the board title
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
                    if(args["type"] == "newCard" || args["type"] == "deleteCard" || args["type"] == "newList" || args["type"] == "deleteList" ){
                        let link2 = "board.php?act=reload&id=" + board.hiddenId;
                        //console.log(link2)
                        formData = new FormData();
                        formData.append('act','reload')
                        myInit = { method: 'POST', //Fetch settings
                                    headers: myHeaders,
                                    mode: 'cors',
                                    cache: 'default',
                                    body:  formData};
                        let contentRefresh = new Request(link2,myInit);
                        fetch(contentRefresh).then((response) =>{
                            response.text().then((response) =>{
                                //console.log(response);
                                document.getElementsByTagName("main")[0].outerHTML = response;
                                init();
                            })
                        })
                        //location.reload();
                    }
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

function findParentList(el){
    let target = null
    if(el){
        if(el.hiddenType || el.classList.contains("list")){
            if(el.hiddenType == "card"){
                if(el.parentNode){
                    target = findParentList(el.parentNode)
                }
            }else{
                target = el
            }
        }
    }
    return target
}

function events(){
    document.addEventListener("dragstart", function(ev) { //Event start when we start dragging
        if(ev.target && (ev.target.classList.contains('listHeader') || ev.target.nodeName == "LI")) //If we drag something && we drag a card || we drag a list
        {
            draggedElement = ev.target; //For better clarity
            
            if(draggedElement.nodeName =="LI"){
                draggedElement.style.backgroundColor = "lightgray";
                draggedElement.oldList = draggedElement.parentNode.hiddenId //We save the old list position
                ev.dataTransfer.setDragImage(draggedElement, -10, -10);
            }else if(draggedElement.classList.contains('listHeader')){ //Nothing to do in it for now
                draggedElement.style.backgroundColor = "#2C233F";
                draggedElement.style.color = "white";
                ev.dataTransfer.setDragImage(draggedElement.parentNode,0,0);
            }
            
        }else{
            draggedElement = null;
        }
    });

    document.addEventListener("dragenter", function(ev) { //Even start when the dragged target enter an element
        if(ev.target && (ev.target.nodeName =="LI" || ev.target.nodeName =="UL" || ev.target.classList.contains('listHeader')) && draggedElement) //If we drag into something && we drag into a card || we drag into a list
        {
            draggedInto = ev.target;
            if(draggedInto.classList.contains("list")) //if we drag into a list
            {
                if(!draggedElement.classList.contains("listHeader")){ //if we drag something else than a list (can only be a card)
                    draggedInto.appendChild(draggedElement); //If the card is dragged over a list we attach it to the end of the list (kinda like a preview)
                }
                /*draggedInto.addEventListener("dragleave", function(leftEl) { //if we leave an element
                    leftEl.preventDefault();
                    if(leftEl.target.classList.contains("list")){ //if we leave a list
                        leftEl.target.style.cssText = "border:1px solid black;"; //we remove the indication border
                    }
                });*/
            }
    
            /*
            *
            * i'm trying to not repeat code, but it makes it way more complex because i have to check eveyrtime the targets and dragged element T_T
            * 
            */
    
            /*if (draggedInto !== draggedElement  && (draggedInto.classList.contains("card") || draggedInto.classList.contains("list"))) {
    
                if(draggedElement.classList.contains("list")){
    
                    draggedInto_ = draggedInto.classList.contains("card") ? draggedInto.parentNode.parentNode : draggedInto.parentNode;
                    draggedElement_ = draggedElement.parentNode;
    
                    ep = draggedInto_.previousElementSibling;
                    en = draggedInto_.nextElementSibling;
                    dp = draggedElement_.previousElementSibling;
                    dn = draggedElement_.nextElementSibling;
                }else{
                    draggedInto_ = draggedInto;
                    draggedElement_ = draggedElement;
    
                    ep = draggedInto_.previousElementSibling
                    console.log(ep)
                    en = draggedInto_.nextElementSibling;
                    dp = draggedElement_.previousElementSibling;
                    dn = draggedElement_.nextElementSibling;
                }
    
                
                if (!ep && !dn) { //If you take the last element and drag it to the start (from the side)
                    draggedInto_.insertAdjacentElement("beforebegin", draggedElement_);
                    console.log("!ep !dn")
                }
                else if (!en && !dp) {  //if you take the first element and drag it to the end (from the side)
                    draggedInto_.insertAdjacentElement("afterend", draggedElement_);
                    console.log("!ep !dp")
                } 
                else if (ep && ep != draggedElement_) {   //if we move up (the previous element target is different than the one dragged)
                    ep.insertAdjacentElement("afterend", draggedElement_);
                    draggedElement_.insertAdjacentElement("afterend", draggedInto_);
    
                    console.log("ep ep")
                } 
                else if (!ep) {     //if we reach the top from inside the list
                    draggedInto_.insertAdjacentElement("beforebegin", draggedElement_);
                    console.log("!ep")
                } 
                else if (en && en != draggedElement_) { //if we move down (the next element target is different than the one dragged)
                    en.insertAdjacentElement("beforebegin", draggedElement_);
                    draggedElement_.insertAdjacentElement("beforebegin", draggedInto_);
                    console.log("en en")
                } 
                else if (!en) {     //if we reach the end from inside the list
                    dp.insertAdjacentElement("afterend", draggedInto_); // we attach it just after the previous one
                    console.log("!en")
                }
            }*/
    
            if (draggedInto !== draggedElement  && !draggedElement.classList.contains("listHeader")  && draggedInto.classList.contains("card")) { //D&D code for card dragging
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
    
            if (draggedInto !== draggedElement  && draggedElement.classList.contains("listHeader") && (draggedInto.classList.contains("list") || draggedInto.classList.contains("listHeader"))) { //D&D code for list dragging
    
                draggedIntoContainer = draggedInto.classList.contains("card") ?  draggedInto.parentNode.parentNode :  draggedInto.parentNode;
                draggedParent = draggedElement.parentNode;
                
                let dip = draggedIntoContainer.previousElementSibling;
                let din = draggedIntoContainer.nextElementSibling;
                let dpp = draggedParent.previousElementSibling;
                let dpn = draggedParent.nextElementSibling;
    
                
                if (!dip && !dpn) {
                    draggedIntoContainer.insertAdjacentElement("beforebegin", draggedParent);
                    //console.log('!ep !dpn')
                }
                else if (!din && !dpp) {
                    draggedIntoContainer.insertAdjacentElement("afterend", draggedParent);
                   // console.log('!din !dpp')
                } 
                else if (dip && dip != draggedParent) {
    
                    dip.insertAdjacentElement("afterend", draggedParent);
                    draggedParent.insertAdjacentElement("afterend", draggedIntoContainer);
                    //console.log('dip dip')
                } 
                else if (!dip) {
                    draggedIntoContainer.insertAdjacentElement("beforebegin", draggedParent);
                    //console.log('!dip')
                } 
                else if (din && din != draggedParent) {
                    dip.insertAdjacentElement("beforebegin", draggedParent);
                    draggedParent.insertAdjacentElement("beforebegin", draggedIntoContainer);
                    //console.log('din din')
                } 
                else if (!din) {
                    dpp.insertAdjacentElement("afterend", draggedIntoContainer);
                    //console.log('!din')
                }
            }
        }
    });
    
    document.addEventListener("dragleave", function(ev) {
        ev.preventDefault();
    });
    
    document.addEventListener("dragover", function(ev) {
        ev.preventDefault();
    });
    
    document.addEventListener("drop", function(ev) {
        if(!draggedElement){ //if we drag something not authorized , we stop everythin
            return ; 
        }
        draggedElement.style.backgroundColor = "";
        draggedElement.style.color = "#2C233F";
        if(ev.target && (ev.target.hiddenType == "card" || ev.target.classList.contains("board") || ev.target.hiddenType == "list")){ //we make sure to limit where we can drop items
            ev.preventDefault();
            if(draggedElement.classList.contains("card")){ //if we drag a card into a board we stop the code (nothing happens)
                if(ev.target.hiddenType != "card" && !ev.target.classList.contains("list") && !ev.target.classList.contains("cardHeader")){
                    return ;
                }
            }
            
            if(draggedElement.classList.contains("card")){
                target = findParentList(ev.target);
            }else{
                target = document.querySelector(".board") //if the list is dragged , we only have one board
            }
            
    
            let type = null;
            if(draggedElement.classList.contains("card")){
                elClass = "card"
            }else if(draggedElement.classList.contains("listHeader")){
                elClass = "list"
            }

            el = draggedElement.classList.contains("listHeader") ? draggedElement.nextElementSibling : draggedElement
            type = draggedElement.classList.contains("listHeader") ? "moveList" : "moveCard" 

            list = target.querySelectorAll("."+elClass);
            listArray = [... list];
            pos = listArray.indexOf(el);
            
            
            
            let args = {"type" : type,"el" : el, "pos" : pos};
            //console.log(args)
            goFetch(args);       
        }
    }); 

    document.addEventListener("click", ev => {
        let elList = document.getElementsByClassName("inputOpen")
        
        if(elList.length > 0){

            let el = ev.target;
            let toClose = null;
            toClose = el.closest("#addList") ? el.closest("#addList") : toClose;
            toClose = el.closest(".addCard") ? el.closest(".addCard") : toClose;
            
            if(!toClose){
                for (let item of elList)
                {
                    item.parentNode.innerHTML = item.parentNode.oldText;
                }
                
            }
            //console.log(el)
        }
        let menu = document.getElementById("cardMenu");
        if(!ev.target.classList.contains("modalMenu") && !ev.target.classList.contains("menu") && board.contains(ev.target)){
            menu.style.display = "none";
        }

        menu = document.getElementById("cardDetail");
        if(!ev.target.classList.contains("modalMenu") && ev.target.id == "cardDetail"){
            menu.style.display = "none";
        }

        
    });
}
init();
events();