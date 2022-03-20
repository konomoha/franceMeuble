let cart = new Cart;

let nbproduit = document.querySelectorAll('.nbproduits');

let produit = document.querySelectorAll('.produit');

let products = {};

let article = document.querySelector('.item');

let total = document.querySelector('.total');

// let items = cart.getCartItems();

let panier = document.getElementById('panier');

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

// if(items == null){
//     cart.renderCart();

// } Visiblement cette condition-là est inutile pour le afficher les produits sur le template panier

if(cart.getNumberProduct() == 0){

    // cart.renderCart();
    panier.outerHTML = "<h1 class='fst-italic text-center'>Votre panier est vide !</h1>";

}
else{

    cart.renderCart();
    
}





