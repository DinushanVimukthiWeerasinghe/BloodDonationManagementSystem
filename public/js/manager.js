const Loader=document.getElementById('loader');
const Months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const Search = (path,type='')=>{
    const url=path;
    const q=document.getElementById('search').value;
    const Form = new FormData();
    Form.append('q',q)
    Form.append('type',type)
    fetch(path,{
        method : 'POST',
        body : Form

    })
        .then((res)=>res.text())
        .then((data)=>{
            console.log(data)
            Loader.classList.remove('none');
            const DP = new DOMParser();
            const Doc = DP.parseFromString(data,'text/html');
            document.getElementById('content').innerHTML=Doc.getElementById('content').innerHTML;
            if (type ==='assign'){

            }
            setTimeout(()=>{
                Loader.classList.add('none')
            },500)
        })

}
window.onload = () => {
    if (Loader) {
        setTimeout(() => {
            Loader.classList.add('none')
        }, 500)
    }
}
const ShowLoader = () => {
    Loader.classList.remove('none')
}
const HideLoader = () => {
    Loader.classList.add('none')
}


