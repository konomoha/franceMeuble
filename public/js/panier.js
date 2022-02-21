let carts = document.querySelectorAll('.add-cart');

let produit = document.querySelectorAll('.produit');

let products = {};

for (let i=0; i < carts.length; i++){
    products[i] = 
    {
        id: produit[i].dataset.id,
        name: produit[i].dataset.name,
        price: parseInt(produit[i].dataset.price),
        image: produit[i].dataset.img,
        inCart: 0

    }
}
// console.log(products);
for (let i=0; i < carts.length; i++){
    carts[i].addEventListener('click', () => {
        cartNumbers(products[i]);
        totalCost(products[i])
    });
}

function onLoadCartNumbers(){
    let productNumbers = localStorage.getItem('cartNumbers');

    if(productNumbers)
    {
        document.querySelector('.cart span').textContent = productNumbers;
    }
}

function cartNumbers(product){
    // console.log("Le produit sélectionné est ", product)
    let productNumbers = localStorage.getItem('cartNumbers');

    productNumbers = parseInt(productNumbers);
    
    if( productNumbers){
        localStorage.setItem('cartNumbers', productNumbers + 1);
        document.querySelector('.cart span').textContent = productNumbers + 1;
        // console.log(products);
    }

    else{
        localStorage.setItem('cartNumbers', 1);
        document.querySelector('.cart span').textContent = 1;
    }

    setItems(product);
}

function setItems(product){
    
    let cartItems = localStorage.getItem('productsInCart');

    cartItems= JSON.parse(cartItems);

    if(cartItems != null){

        if(cartItems[product.id] == undefined)
        {
            cartItems = {
                ...cartItems,
                [product.id]: product
            }

        }
        cartItems[product.id].inCart += 1;
    }

    else{
        product.inCart = 1;

        cartItems = {
                [product.id]: product
        }
    }

    localStorage.setItem("productsInCart", JSON.stringify(cartItems));
}

function totalCost(product){

    // console.log(product.price);
    let cartCost = localStorage.getItem('totalCost');

    // console.log(typeof cartCost);
    if(cartCost != null){

        cartCost = parseInt(cartCost);

        localStorage.setItem("totalCost", cartCost + product.price)
        console.log(typeof product.price);
    }
    else{
            localStorage.setItem("totalCost", product.price);

    }

}

onLoadCartNumbers();