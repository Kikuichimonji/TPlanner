let listMenu = document.getElementById("userTabs").querySelectorAll("li")
let listContent = document.getElementById("userContent").querySelectorAll("div")
let listArray = [...listContent];
let listCount = 0;
listArray[0].style.display = "block";

for(item of listMenu) {
    item.hiddenId = listCount;
    listCount++;
}
listMenu.forEach(item => {
    item.addEventListener("click", ev =>{
        listArray.forEach(item=>{
            item.style.display = 'none';
        })
        listMenu.forEach(item =>{
            item.classList.remove("active")
        })
        listArray[ev.target.hiddenId].style.display = "flex"
        item.classList.add("active")
    })
})