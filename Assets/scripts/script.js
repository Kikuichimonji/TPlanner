let cards = document.querySelectorAll(".card");
let lists = document.querySelectorAll(".list");

cards.forEach((item)=>{
    item.hiddenId = item.id;
    item.removeAttribute('id');
});

lists.forEach((item)=>{
    item.hiddenId = item.id;
    item.removeAttribute('id');
});


cards.forEach(item => item.addEventListener("click", (e) => //Event for when we're gonna click on the cards
{
    cards.forEach((item) => {
        item => item.className = "card";
    })
    e.target.className = "card active";
}));


document.addEventListener("dragstart", function(ev) {
    //console.log(ev.target.nodeName)
    if(ev.target && (ev.target.nodeName =="LI" || ev.target.nodeName == "UL"))
    {
        draggedTarget = ev.target;
        draggedTarget.id = "cardActive";
        ev.dataTransfer.setData("Data", ev.target.id);
        draggedTarget.style.backgroundColor = "#444";
        ev.dataTransfer.setDragImage(draggedTarget, -10, -10);
    }
});

document.addEventListener("dragenter", function(ev) {
    if(ev.target && (ev.target.nodeName =="LI" || ev.target.nodeName == "UL"))
    {
        if(ev.target.classList.contains("list"))
        {
            if(!draggedTarget.classList.contains("list")){
                ev.target.appendChild(draggedTarget);
            }
            ev.target.addEventListener("dragleave", function(boardEv) {
                boardEv.preventDefault();
                if(boardEv.target.classList.contains("list")){
                    boardEv.target.style.cssText = "border:5px solid black;";
                }
            });
        }

        if(draggedTarget.classList.contains("card")){
            if(ev.target.classList.contains("list")){
                ev.target.style.cssText = "border:5px solid green;";
            }else if(ev.target.parentNode.className == "list"){
                ev.target.parentNode.style.cssText = "border:5px solid green;";
            }
        }

        if (ev.target !== draggedTarget  && !draggedTarget.classList.contains("list") && ev.target.classList.contains("card")) {
            let ep = ev.target.previousElementSibling;
            let en = ev.target.nextElementSibling;
            let dp = draggedTarget.previousElementSibling;
            let dn = draggedTarget.nextElementSibling;
            /*console.log(ep.innerHTML)
            console.log(en.innerHTML)*/
            
            if (!ep && !dn) { //If you take the last element and drag it to the start (from the side)
                ev.target.insertAdjacentElement("beforebegin", draggedTarget);
            }
            else if (!en && !dp) {  //if you take the first element and drag it to the end (from the side)
                ev.target.insertAdjacentElement("afterend", draggedTarget);
            } 
            else if (ep && ep != draggedTarget) {   //if we move up (the previous element target is different than the one dragged)
                ep.insertAdjacentElement("afterend", draggedTarget);
                draggedTarget.insertAdjacentElement("afterend", ev.target);
            } 
            else if (!ep) {     //if we reach the top from inside the list
                ev.target.insertAdjacentElement("beforebegin", draggedTarget);
            } 
            else if (en && en != draggedTarget) { //if we move down (the next element target is different than the one dragged)
                en.insertAdjacentElement("beforebegin", draggedTarget);
                draggedTarget.insertAdjacentElement("beforebegin", ev.target);
            } 
            else if (!en) {     //if we reach the end from inside the list
                dp.insertAdjacentElement("afterend", ev.target); // we attach it just after the previous one
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
    if(ev.target && (ev.target.nodeName =="LI" || ev.target.nodeName == "UL"))
    {
        ev.preventDefault();

        draggedTarget.style.backgroundColor = "";

        if(ev.target.classList.contains("list")){
            ev.target.style.cssText = "border:5px solid black;";
        }else if(ev.target.parentNode.classList.contains("list")){
            ev.target.parentNode.style.cssText = "border:5px solid black;";
        }
        
        if(ev.target.classList.contains("list") && ev.target !== draggedTarget && !draggedTarget.classList.contains("list"))
        {
            data = ev.dataTransfer.getData("Data");
            el = document.getElementById(data);
            ev.target.appendChild(el);
        }
        
        if(ev.target.parentNode.classList.contains("list")){
            target = ev.target.parentNode 
        }else if(ev.target.classList.contains("list")){
            target = ev.target 
        }
        
        cardList = target.querySelectorAll(".card")
        cardsArray = [... cardList]
        cardPos = cardsArray.indexOf(draggedTarget)


        myHeaders = new Headers();

        var myInit = { method: 'GET',
                headers: myHeaders,
                mode: 'cors',
                cache: 'default' };

        const moveCard = "board.php?list=" + draggedTarget.parentNode.hiddenId + "&pos=" + cardPos + "&card=" + draggedTarget.hiddenId;

        var myRequest = new Request(moveCard,myInit);
        
        fetch(myRequest).then((response) => {
            response.text().then(response => {
                console.log(response)
                if(response === 'false')
                    console.log("Problème de paramètres")
                else
                    console.log("tout est ok")
            })
            if(!response.ok) {
                console.log("Mauvaise réponse du réseau")
            }
        })

        
        /*fetch(myRequest).then(function(response) {
        if(response.ok) {
            response.blob().then(function(myBlob) {
            var objectURL = URL.createObjectURL(myBlob);
            myImage.src = objectURL;
            });
        } else {
            console.log('Mauvaise réponse du réseau');
        }
        })
        .catch(function(error) {
        console.log('Il y a eu un problème avec l\'opération fetch: ' + error.message);
        });*/

        draggedTarget.removeAttribute("id");
    }
}); 