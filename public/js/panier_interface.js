let cart = new Cart;

let nbproduit = document.querySelectorAll('.nbproduits');

let produit = document.querySelectorAll('.produit');

let products = {};

let article = document.querySelector('.item');

let qte_plus = document.querySelectorAll('.qte_plus');

let total = document.querySelector('.total');

let items = cart.getCartItems();

for (let i=0; i < nbproduit.length; i++){

    products[i] = 
    {
        color: produit[i].dataset.color,
        id: produit[i].dataset.id,
        name: produit[i].dataset.name,
        price: parseInt(produit[i].dataset.price),
        image: produit[i].dataset.img,

    }

}

for (let i=0; i < produit.length; i++){

    produit[i].addEventListener('click', () => {
        cart.add(products[i]);
    });

}

cart.onLoad();

if(items != null){
    cart.renderCart(items, article, total, qte_plus);
}

console.log(qte_plus.length);


// for (let i=0; i < qte_plus.length; i++){

//     qte_plus[i].addEventListener('click', () => {
//         cart.changeQuantity(items[i], 1);
//     });

// }





