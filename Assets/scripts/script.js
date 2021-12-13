let boardContainer = document.querySelector(".boardContainer");
let board = boardContainer.querySelector(".board");
let cards = board.querySelectorAll(".card");



cards.forEach(item => item.addEventListener("click", (e) => //Event for when we're gonna click on the cards
{
    cards.forEach(item => item.className = "card");
    e.target.className = "card active";
}));


let draggedTarget;

document.addEventListener("dragstart", function(ev) {

    draggedTarget = ev.target;
    draggedTarget.id = "cardActive";
    ev.dataTransfer.setData("Data", ev.target.id);
    draggedTarget.style.backgroundColor = "#444";
    ev.dataTransfer.setDragImage(draggedTarget, -10, -10);
});

document.addEventListener("dragenter", function(ev) {

    if(ev.target.classList.contains("board"))
    {
        if(!draggedTarget.classList.contains("board")){
            ev.target.appendChild(draggedTarget);
        }
        ev.target.addEventListener("dragleave", function(boardEv) {
            boardEv.preventDefault();
            if(boardEv.target.classList.contains("board")){
                boardEv.target.style.cssText = "border:5px solid black;";
            }
        });
    }

    if(draggedTarget.classList.contains("card")){
        if(ev.target.classList.contains("board")){
            ev.target.style.cssText = "border:5px solid green;";
        }else if(ev.target.parentNode.className == "board"){
            ev.target.parentNode.style.cssText = "border:5px solid green;";
        }
    }

    if (ev.target !== draggedTarget  && !draggedTarget.classList.contains("board") && ev.target.classList.contains("card")) {
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

});

/*document.addEventListener("dragleave", function(ev) {
    ev.preventDefault();
    if(ev.target.classList.contains("board") ){
        ev.target.style.cssText = "border:5px solid black;";
    }
});*/

document.addEventListener("dragover", function(ev) {
    ev.preventDefault();
});

document.addEventListener("drop", function(ev) {
    ev.preventDefault();
    draggedTarget.style.backgroundColor = "";
    ev.target.style.cssText = "border:5px solid black;";

    if(ev.target.classList.contains("board") && ev.target !== draggedTarget && !draggedTarget.classList.contains("board"))
    {
        data = ev.dataTransfer.getData("Data");
        el = document.getElementById(data);
        ev.target.appendChild(el);
    }
    draggedTarget.id = "";
}); 