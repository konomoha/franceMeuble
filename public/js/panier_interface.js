let cart = new Cart;

let nbproduit = document.querySelectorAll('.nbproduits');

let produit = document.querySelectorAll('.produit');

let products = {};

let test = document.querySelector('.item');

let items = cart.getCartItems();

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

// console.log(cart.cart); //cart est un objet issu de la class Cart, pour accéder à l'array 'cart' contenant l'ensemble des produits sélectionnés, je dois entrer cart.cart

cart.onLoad();

items.forEach((product) =>{

    test.innerHTML += 
        "<tr><td class='row align-items-center'>" + "<div class='col-2'><img src=" + product.image + " class= ' img-fluid img-cart'></div><p class='col-8 text-center'>" + product.name + "</p></td><td>" + product.quantity + "</td><td class='text-center'>"+ product.price+"€</td></tr>";
        
})




