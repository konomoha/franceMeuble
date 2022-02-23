let cart = new Cart;

let nbproduit = document.querySelectorAll('.nbproduits');

let produit = document.querySelectorAll('.produit');

let products = {};

let article = document.querySelector('.item');

let total = document.querySelector('.total');

let items = cart.getCartItems();

let removeOne = document.querySelectorAll('.btn_qte_minus')

for (let i=0; i < nbproduit.length; i++){

    products[i] = 
    {
        color: produit[i].dataset.color,
        id: produit[i].dataset.id,
        name: produit[i].dataset.name,
        price: parseInt(produit[i].dataset.price),
        image: produit[i].dataset.img,
        stock: produit[i].dataset.stock

    }

}

for (let i=0; i < produit.length; i++){

    produit[i].addEventListener('click', () => {
        cart.add(products[i]);
    });

}

items.forEach((product) =>{

    article.innerHTML += 
        "<tr><td>" + "<p class='text-start mb-0'><span class='col-2 mx-5'><img src=" + product.image + " class= ' img-fluid img-cart'></span><a href='/produit/" + product.id + "'>" + product.name + " (" + product.color + ")</a></p></td><td><span class='qte_minus mx-2'><i class='bi bi-dash-circle-fill'></i></span>" + product.quantity + "<button class='qte_plus mx-2 '><i class='bi bi-plus-circle-fill'></i></button></td><td class='text-center'>"+ product.price+"€</td></tr>";

        total.innerHTML = 
        "<th colspan='2' class='text-end p-2 mx-2'>Total TTC</th><td class='text-center fw-bold'>" + cart.getTotalPrice() + "€</td>";
    
})

cart.onLoad();