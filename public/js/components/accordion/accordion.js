const accordion = document.querySelector('.accordion');
const accordionItems = accordion.querySelectorAll('.accordion-item');
const accordionTitles = accordion.querySelectorAll('.accordion-title');
const accordionButtons = accordion.querySelectorAll('.accordion-button');

accordionItems[0].classList.add('active');
for(let i = 0; i < accordionTitles.length; i++) {
  accordionItems[i].setAttribute('data-index', i.toString());
  accordionTitles[i].addEventListener('click', function() {
      accordionItems[i].classList.toggle('active');
      for(let j = 0; j < accordionItems.length; j++) {
        if(j !== i) {
          accordionItems[j].classList.remove('active');
        }
      }
  });
}