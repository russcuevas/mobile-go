const iconCart = document.getElementById('iconCart');
const closeCart = document.querySelector('.close');
const cartTab = document.querySelector('.cartTab');
const body = document.body;

// Toggle cart visibility when cart icon is clicked
iconCart.addEventListener('click', () => {
    body.classList.toggle('showCart');
    cartTab.classList.toggle('hidden');
});

// Hide cart when close button is clicked
closeCart.addEventListener('click', () => {
    cartTab.classList.add('hidden');
    body.classList.remove('showCart');
});
