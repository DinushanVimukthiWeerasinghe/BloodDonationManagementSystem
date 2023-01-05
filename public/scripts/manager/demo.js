const mediaQuery = window.matchMedia('(max-width: 500px)')
const RedirectID = (id) => {
    console.log(id)
    window.location.href = "/manager/mngMedicalOfficer/view?id="+id
}

if (mediaQuery.matches)
{
    cards=document.getElementsByClassName('detail-card');
    Add_card_mb=document.getElementsByClassName('add-card-mb');
    for (let i = 0; i < cards.length; i++) {
        cards[i].addEventListener('touchstart', function(e) {
            console.log(cards[i].id);
            window.location.href = '/manager/mngMedicalOfficer/view?id='+cards[i].id;
        })
    }
    Add_card_mb[0].addEventListener('touchstart', function(e) {
        window.location.href = '/manager/mngMedicalOfficer/add';
    })
}