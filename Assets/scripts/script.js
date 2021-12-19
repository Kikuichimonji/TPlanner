let cards = null
let lists = null
let board = null
let draggedElement = null;

function init(){

    cards = document.querySelectorAll(".card");
    lists = document.querySelectorAll(".list");
    board = document.querySelector("main").id;
    document.querySelector("main").removeAttribute("id");

    cards.forEach((item)=>{ // We hide the id in a parameter so people can't mess with the positions
        item.hiddenId = item.id;
        item.removeAttribute('id');
    });

    lists.forEach((item)=>{
        item.hiddenId = item.id;
        item.removeAttribute('id');
        item.nextElementSibling.hiddenId = item.hiddenId;
        item.nextElementSibling.addEventListener("click", (ev) =>
        {
            addNewCard(ev.target);
        })
    });

    cards.forEach(item => item.addEventListener("click", (ev) => //Event for when we're gonna click on the cards
    {
        if(ev.target.classList.contains("card")){
            cards.forEach((item) => {
                item.className = "card";
            })
            ev.target.className = "card active";
        }else if(ev.target.nodeName= "SPAN"){
            //console.log(ev.target.parentNode.parentNode.hiddenId)
            deleteCard(ev.target.parentNode.parentNode);
        }
    }));
}

function addNewCard(el)
{
    let newBox = document.createElement("input");
    newBox.setAttribute("type","text");
    newBox.setAttribute("placeholder","Enter card title here");

    let newButton = document.createElement("button");
    newButton.innerHTML = "Confirm";
    newBox.hiddenId = el.hiddenId;
    newButton.hiddenId = el.hiddenId;

    let parent = el.parentNode;
    parent.removeChild(el);
    parent.appendChild(newBox);
    parent.appendChild(newButton);
    newButton.addEventListener("click", ev =>{
        let card = ev.target.previousElementSibling
        let cardText = card.value;
        let args = {"type" : "newCard","card" : card};

        if(cardText !== ""){
            //console.log(ev.target.hiddenId)
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
    let args = {"type" : "deleteCard",
                "el" : card,
                "pos"  : pos,
                "list" : el.parentNode.hiddenId};
    goFetch(args)
}

function goFetch(args)
{

    myHeaders = new Headers(); //If we want custom headers

    let myInit = { method: 'GET', //Fetch settings
            headers: myHeaders,
            mode: 'cors',
            cache: 'default' };

    if(args["type"]){
        switch(args['type']) {
            case "newCard" :
                let el = args['card']
                link = "board.php?act=" + args['type'] + "&list=" + el.hiddenId + "&text="+el.value; //the link for a new card
                break
            case "moveList" :
                link = "board.php?act=" + args['type'] + "&list=" + args["el"].hiddenId + "&listPos=" + args["pos"] ; //the link for moving lists
                break
            case "moveCard" :
                link = "board.php?act=" + args['type'] + "&list=" + args["el"].parentNode.hiddenId + "&pos=" + args["pos"] + "&card=" + args["el"].hiddenId + "&oldList="+args["el"].oldList; //the link for moving cards
                break
            case "deleteCard" :
                link = "board.php?act=" + args['type'] + "&card=" + args["el"].hiddenId + "&pos=" + args["pos"] + "&list=" + args["list"] ; //the link for moving cards
                break
            default:
                link = null;
        }
    }else{
        link = null;
        console.log("goFetch need a type to operate")
    }
    
    //console.log(link)
    let myRequest = new Request(link,myInit); //We prepare the fetch request with settings and our link destination
    fetch(myRequest).then((response) => { //We fetch the result
        response.text().then(response => {
            console.log(response) //My check of the controler response
            if(response === 'false')    //If the controler writes 'false' , i know it's shit but i haven't found out how to return a boolean with fetch
                console.log("Problème de paramètres")
            else{
                console.log("good doggy")
                if(args["type"] == "newCard" || args["type"] == "deleteCard"){
                    let link2 = "board.php?act=reload&id=" + board; 
                    //console.log(link2)
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
}

function events(){
    document.addEventListener("dragstart", function(ev) { //Event start when we start dragging
        if(ev.target && (ev.target.nodeName =="LI" || ev.target.nodeName == "UL")) //If we drag something && we drag a card || we drag a list
        {
            draggedElement = ev.target; //For better clarity
            draggedElement.style.backgroundColor = "#444";
            
            if(draggedElement.nodeName =="LI"){
                draggedElement.oldList = draggedElement.parentNode.hiddenId //We save the old list position
                ev.dataTransfer.setDragImage(draggedElement, -10, -10);
            }else if(draggedElement.nodeName == "UL"){ //Nothing to do in it for now
    
            }
            
        }else{
            draggedElement = null;
        }
    });

    document.addEventListener("dragenter", function(ev) { //Even start when the dragged target enter an element
        if(ev.target && (ev.target.nodeName =="LI" || ev.target.nodeName == "UL") && draggedElement) //If we drag into something && we drag into a card || we drag into a list
        {
            draggedInto = ev.target;
            if(draggedInto.classList.contains("list")) //if we drag into a list
            {
                if(!draggedElement.classList.contains("list")){ //if we drag something else than a list (can only be a card)
                    draggedInto.appendChild(draggedElement); //If the card is dragged over a list we attach it to the end of the list (kinda like a preview)
                }
                draggedInto.addEventListener("dragleave", function(leftEl) { //if we leave an element
                    leftEl.preventDefault();
                    if(leftEl.target.classList.contains("list")){ //if we leave a list
                        leftEl.target.style.cssText = "border:5px solid black;"; //we remove the indication border
                    }
                });
            }
    
            if(draggedElement.classList.contains("card")){ //We put a border to help see where we can drop the element
                if(draggedInto.classList.contains("list")){
                    draggedInto.style.cssText = "border:5px solid green;";
                }else if(draggedInto.parentNode.className == "list"){ //if we drag into a card we have to still color the list green
                    draggedInto.parentNode.style.cssText = "border:5px solid green;";
                }
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
    
            if (draggedInto !== draggedElement  && !draggedElement.classList.contains("list") && draggedInto.classList.contains("card")) { //D&D code for card dragging
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
    
            if (draggedInto !== draggedElement  && draggedElement.classList.contains("list") && draggedInto.classList.contains("list")) { //D&D code for list dragging
    
    
                draggedInto.classList.contains("card") ? draggedIntoContainer = draggedInto.parentNode.parentNode : draggedIntoContainer = draggedInto.parentNode;
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
        if(ev.target && (ev.target.nodeName =="LI" || ev.target.nodeName == "UL" || ev.target.classList.contains("board"))){ //we make sure to limit where we can drop items
            ev.preventDefault();
            
            if(draggedElement.classList.contains("card") && (!ev.target.classList.contains("card") && !ev.target.classList.contains("list"))){ //if we drag a card into a board we stop the code (nothing happens)
                return ;
            }
    
            if(ev.target.classList.contains("list")){  //more border shenanigans
                ev.target.style.cssText = "border:5px solid black;";
            }else if(ev.target.parentNode.classList.contains("list")){
                ev.target.parentNode.style.cssText = "border:5px solid black;";
            }
    
            if(draggedElement.classList.contains("card")){
                if(ev.target.parentNode.classList.contains("list")){ //We verify if the card is drop inside another card or indide a list
                    target = ev.target.parentNode 
                }else if(ev.target.classList.contains("list")){
                    target = ev.target 
                }
            }else{
                target = document.querySelector(".board") //if the list is dragged , we only have one board
            }
            
    
            let type = null;
            if(draggedElement.classList.contains("card")){
                elClass = "card"
            }else if(draggedElement.classList.contains("list")){
                elClass = "list"
            }
            list = target.querySelectorAll("."+elClass);
            listArray = [... list];
            pos = listArray.indexOf(draggedElement);
            
            //console.log(draggedElement)
            type = draggedElement.classList.contains("list") ? "moveList" : "moveCard" 
    
            let args = {"type" : type,"el" : draggedElement, "pos" : pos};

            goFetch(args);
                
    
        }
    }); 
}
init();
events();