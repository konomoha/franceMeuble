let carts = document.querySelectorAll('.add-cart');

let produit = document.querySelectorAll('.produit');

let products = {};

for (let i=0; i < carts.length; i++){
    products[i] = 
    {
        id: produit[i].dataset.id,
        name: produit[i].dataset.name,
        price: produit[i].dataset.price,
        image: produit[i].dataset.img

    }
}
console.log(products);
for (let i=0; i < carts.length; i++){
    carts[i].addEventListener('click', () => {
        cartNumbers(products[i]);
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
        console.log(products);
    }

    else{
        localStorage.setItem('cartNumbers', 1);
        document.querySelector('.cart span').textContent = 1;
    }

    setItems(product);
}

function setItems(product){
    console.log("My product is", product);
}

onLoadCartNumbers();