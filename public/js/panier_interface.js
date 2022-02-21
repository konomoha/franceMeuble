let cart = new Cart;
let nbproduit = document.querySelectorAll('.nbproduits');

let produit = document.querySelectorAll('.produit');

let products = {};

for (let i=0; i < nbproduit.length; i++){
    products[i] = 
    {
        id: produit[i].dataset.id,
        name: produit[i].dataset.name,
        price: parseInt(produit[i].dataset.price),
        image: produit[i].dataset.img

    }
}

for (let i=0; i < nbproduit.length; i++){
    nbproduit[i].addEventListener('click', () => {
        cart.add(products[i]);
    });
}

cart.onLoad();


