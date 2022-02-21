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
        addCart(products[i]);
    });
}

function onLoadCartNumbers(){
    let productNumbers = getNumberProduct();

    if(productNumbers)
    {
        document.querySelector('.cart span').textContent = productNumbers;
    }
}

function saveCart(cart){

    localStorage.setItem("cart", JSON.stringify(cart));

}

function getCart(){

    let cart = localStorage.getItem("cart");

    if(cart == null)
    {
        return [];
    }

    else
    {
        return JSON.parse(cart);
    }
}

function addCart(product){

    let cart = getCart();

    let foundProduct = cart.find(p => p.id == product.id);

    if(foundProduct != undefined)
    {
        foundProduct.quantity++;
    }
    
    else
    {
        product.quantity = 1;
        cart.push(product);
    }
    
    
    saveCart(cart);

    document.querySelector('.cart span').textContent = getNumberProduct();
}

function removeFromCart(product){

    let cart = getCart();
    cart = cart.filter(p => p.id != product.id);
    saveCart(cart);
}

function changeQuantity(product, quantity){

    let cart = getCart();

    let foundProduct = cart.find(p => p.id == product.id);

    if(foundProduct != undefined)
    {
        foundProduct.quantity += quantity;

        if (foundProduct.quantity <= 0)
        {
            removeFromCart(foundProduct);
        }
        else
        {
           saveCart(cart); 
        }
        document.querySelector('.cart span').textContent = getNumberProduct();
    }
}

function getNumberProduct(){

    let cart = getCart();

    let number = 0;

    for(let product of cart){
        number += product.quantity;
    }

    return number;
}

function getTotalPrice(){
    let cart = getCart();

    let total = 0;

    for(let product of cart){
        total += product.quantity * product.price;
    }

    return total;
}

onLoadCartNumbers();