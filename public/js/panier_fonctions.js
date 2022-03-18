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
        
        let foundProduct = this.cart.find(p => p.id == product.id);

            if(foundProduct != undefined)
            {

                foundProduct.quantity += quantity;
        
                if (foundProduct.quantity <= 0)
                {
                    this.remove(foundProduct);
                    location.reload();
                }
                else
                {
                this.save(); 
                }
                document.querySelector('.cart span').textContent = this.getNumberProduct();
                
            }
    }

    renderCart(){ //Le bouton onclick ne fonctionne pas. De plus, la méthode changeQuantity() s'active automatiquement lorsque je rafraîchis la page. Le problème vient de quelque part dans ce innerHTML. Peut-être que toutes les fonctions présentes dans un innerHTML s'activent automatiquement au chargement de la page. Pourquoi je n'arrive pas à récupérer une class présente dans le innerHTML?
        let items = this.getCartItems();

        // console.log(items.length);

        items.forEach((product) =>{

            article.innerHTML += 
                "<tr><td><p class='text-start mb-0'><span class='col-2 mx-5'><img src=" + product.image + " class= ' img-fluid img-cart'></span><a href='/produit/" + product.id + "'>" + product.name + " (" + product.color + ")</a></p></td><td><i class='bi bi-dash-circle-fill qte_minus mx-3'></i><span class='qte_item'>"+ product.quantity +"</span><i class='bi bi-plus-circle-fill qte_plus mx-3'></i></td><td class='text-center'>"+ product.price+"€</td></tr>";
        
            total.innerHTML = 
                "<th colspan='2' class='text-end p-2 mx-2'>Total TTC</th><td class='text-center fw-bold'><span class='total_price'>" + cart.getTotalPrice() + "</span>€</td>";

            let qte_plus = document.querySelectorAll('.qte_plus');

            let qte_minus = document.querySelectorAll('.qte_minus');

            let qte_item = document.querySelectorAll('.qte_item');

            let total_price = document.querySelector('.total_price');

            // console.log(qte_plus);
            //Un autre problème se pose: les boutons marchent, mais la quantité ne change que pour le dernier article de la liste. Je n'arrive pas à comprendre pourquoi.
            for(let i = 0; i < qte_plus.length; i++){

                qte_plus[i].addEventListener('click', () => {
                    
                    this.changeQuantity(items[i], 1);

                    qte_item[i].textContent = items[i].quantity;
                
                    total_price.textContent = this.getTotalPrice();

                    // location.reload();
                });

                qte_minus[i].addEventListener('click', () => {
                        
                    this.changeQuantity(items[i], -1);

                    if(items[i].quantity > 0){

                        qte_item[i].textContent = items[i].quantity;
                    }
                    
                    total_price.textContent = this.getTotalPrice();

                    // location.reload();
                });
            }
        });
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
