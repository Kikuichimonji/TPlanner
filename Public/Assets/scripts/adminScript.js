deleteButtons = document.getElementsByClassName("delete")
for (let el of deleteButtons) {
    el.addEventListener("click", ev => {
        ev.preventDefault();
        youSure(redirect, ev.target.parentNode.href)
    })
}
function redirect(link)
{
    window.location.href = link;
}