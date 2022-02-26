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
            // foundProduct.stock--;
        }
        
        else
        {   
            
            product.quantity = 1;
            this.cart.push(product);
            // product.stock--;
            
        }
        
        
        this.save();
    
        document.querySelector('.cart span').textContent = this.getNumberProduct();
    }

    remove(product){

        this.cart = this.cart.filter(p => p.id != product.id);
        this.save();
    }

    changeQuantity(product, quantity){

        let foundProduct = this.cart.find(p => p.id == product.id);
    
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
            // location.reload();
            // document.querySelector('.cart span').textContent = this.getNumberProduct();
        }
    }

    renderCart(item, x, y, z){
        for(let i=0; i<item.length; i++){

            x.innerHTML +=`
                <tr><td><p class='text-start mb-0'><span class='col-2 mx-5'><img src=${item[i].image} class= ' img-fluid img-cart'></span><a href='/produit/${item[i].id}'>${item[i].name} (${item[i].color})</a></p></td><td> ${item[i].quantity} <button class='${z} mx-2 cartitem'>+</button></td><td class='text-center'>${item[i].price}€</td></tr>`;
        
                y.innerHTML = 
                "<th colspan='2' class='text-end p-2 mx-2'>Total TTC</th><td class='text-center fw-bold'>" + this.getTotalPrice() + "€</td>";
           
                z[i].addEventListener('click', () => {
                    this.changeQuantity(items[i], 1);
                });
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

    getCartItems(){

        let items=[];

        for(let product of this.cart){
            items.push(product);
        }

        return items;
    }

}
