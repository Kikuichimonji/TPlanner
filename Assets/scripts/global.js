let popupMenu = null;
popupMenu = document.getElementById("popUpProfile");

popupMenu   ? document.querySelector("#headerContainer .icon").addEventListener("click",(ev) => {
                popupMenu.style.display = popupMenu.style.display == "block" ? "none" : "block"
            })
            : null;