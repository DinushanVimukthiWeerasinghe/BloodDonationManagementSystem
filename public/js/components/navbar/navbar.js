const navList = document.querySelector('.navList');
const navBtn = document.querySelector('.navBtn');
const navLinks = document.querySelectorAll('.navLi');
window.addEventListener("scroll", preventMotion, false);
window.addEventListener("touchmove", preventMotion, false);

function preventMotion(event)
{
    window.scrollTo(0, 0);
    event.preventDefault();
    event.stopPropagation();
}

const Redirect=(path)=>{
    window.location.href=path
}
navBtn.addEventListener('click',()=>{
    navBtn.classList.toggle('navBtnToggle')
    navList.classList.toggle('navActive')
    navLinks.forEach((item, index) => {
        const delay = index / 10 + 0.05
        if (item.style.animation)
            item.style.animation = ''
        else
            item.style.animation = `SlideIn 0.5s forwards ${delay}s`
    })
})