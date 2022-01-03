let popupMenu = null;
popupMenu = document.getElementById("popUpProfile");

popupMenu ? document.querySelector("#headerContainer .icon").addEventListener("click",(ev) => { //We open and close the user menu
                popupMenu.style.display = popupMenu.style.display == "block" ? "none" : "block" //If the display is block, then we hide it, and vice versa
            })
            : null;