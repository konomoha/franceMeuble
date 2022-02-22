let cart = new Cart;

let nbproduit = document.querySelectorAll('.nbproduits');

let produit = document.querySelectorAll('.produit');

let products = {};

let article = document.querySelector('.item');

let total = document.querySelector('.total');

let items = cart.getCartItems();

for (let i=0; i < nbproduit.length; i++){

    products[i] = 
    {
        color: produit[i].dataset.color,
        id: produit[i].dataset.id,
        name: produit[i].dataset.name,
        price: parseInt(produit[i].dataset.price),
        image: produit[i].dataset.img

    }

}

for (let i=0; i < produit.length; i++){

    produit[i].addEventListener('click', () => {
        cart.add(products[i]);
    });

}

// console.log(cart.cart); //cart est un objet issu de la class Cart, pour accéder à l'array 'cart' contenant l'ensemble des produits sélectionnés, je dois entrer cart.cart

cart.onLoad();

items.forEach((product) =>{

    article.innerHTML += 
        "<tr><td>" + "<p class='text-start mb-0'><span class='col-2 mx-5'><img src=" + product.image + " class= ' img-fluid img-cart'></span>" + product.name + " (" + product.color + ")</p></td><td>" + product.quantity + "</td><td class='text-center'>"+ product.price+"€</td></tr>";
        total.innerHTML = 
        "<th colspan='2' class='text-end p-2 mx-2'>Total TTC</th><td class='text-center fw-bold'>" + cart.getTotalPrice() + "€</td>";

})






