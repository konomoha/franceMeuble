// let nbproduit = document.querySelectorAll('.nbproduits');

// let produit = document.querySelectorAll('.produit');

// let products = {};

// for (let i=0; i < nbproduit.length; i++){
//     products[i] = 
//     {
//         id: produit[i].dataset.id,
//         name: produit[i].dataset.name,
//         price: parseInt(produit[i].dataset.price),
//         image: produit[i].dataset.img

//     }
// }

// for (let i=0; i < nbproduit.length; i++){
//     nbproduit[i].addEventListener('click', () => {
//         addCart(products[i]);
//     });
// }

class Cart{
    constructor(){
        let cart = localStorage.getItem("cart");

        if(cart == null)
        {
           this.cart = [];
        }

        else
        {
            this.cart= JSON.parse(cart);
        }
    }

    save(){

        localStorage.setItem("cart", JSON.stringify(this.cart));
    
    }
    
    onLoad(){

        let productNumbers = this.getNumberProduct();

        if(productNumbers)
        {
            document.querySelector('.cart span').textContent = productNumbers;
        }
    }

    add(product){

        let foundProduct = this.cart.find(p => p.id == product.id);
    
        if(foundProduct != undefined)
        {
            foundProduct.quantity++;
        }
        
        else
        {
            product.quantity = 1;
            this.cart.push(product);
        }
        
        
        this.save();
    
        document.querySelector('.cart span').textContent = this.getNumberProduct();
    }

    remove(product){

        this.cart = this.cart.filter(p => p.id != product.id);
        this.save();
    }

    changeQuantity(product, quantity){

        let foundProduct = cart.find(p => p.id == product.id);
    
        if(foundProduct != undefined)
        {
            foundProduct.quantity += quantity;
    
            if (foundProduct.quantity <= 0)
            {
                remove(foundProduct);
            }
            else
            {
               this.save(); 
            }
            document.querySelector('.cart span').textContent = this.getNumberProduct();
        }
    }

    getNumberProduct(){

        let number = 0;
    
        for(let product of this.cart){
            number += product.quantity;
        }
    
        return number;
    }

    getTotalPrice(){

        let total = 0;
    
        for(let product of this.cart){
            total += product.quantity * product.price;
        }
    
        return total;
    }

}

// onLoad();