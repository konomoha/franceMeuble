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
                console.log(foundProduct);

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

    renderCart(){ //Le bouton onclick ne fonctionne pas. De plus, la méthode changeQuantity() s'active automatiquement lorsque je rafraîchis la page. Le problème vient de quelque part dans ce innerHTML. Peut-être que toutes les fonctions présentes dans un innerHTML s'activent automatiquement au chargement de la page. Pourquoi je n'arrive pas à récupérer une class présente dans le innerHTML?
        let items = this.getCartItems();

        console.log(items.length);

        items.forEach((product) =>{

            article.innerHTML += 
                "<tr><td><p class='text-start mb-0'><span class='col-2 mx-5'><img src=" + product.image + " class= ' img-fluid img-cart'></span><a href='/produit/" + product.id + "'>" + product.name + " (" + product.color + ")</a></p></td><td><span class='qte_minus mx-2'><i class='bi bi-dash-circle-fill'></i></span>" + product.quantity + "<span class='qte_plus mx-2'><i class='bi bi-plus-circle-fill'></i></span></td><td class='text-center'>"+ product.price+"€</td></tr>";
        
                total.innerHTML = 
                "<th colspan='2' class='text-end p-2 mx-2'>Total TTC</th><td class='text-center fw-bold'>" + cart.getTotalPrice() + "€</td>";

            let qte_plus = document.querySelector('.qte_plus');

            let qte_minus = document.querySelector('.qte_minus');

            // console.log(qte_plus);
            //Un autre problème se pose: les boutons marchent, mais la quantité ne change que pour le dernier article de la liste. Je n'arrive pas à comprendre pourquoi.

                qte_plus.addEventListener('click', () => {
                    
                    console.log(product);
                    this.changeQuantity(product, 1);
                    // location.reload();
                });

                qte_minus.addEventListener('click', () => {
                        
                    this.changeQuantity(product, -1);
                    // location.reload();
                });
            
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
