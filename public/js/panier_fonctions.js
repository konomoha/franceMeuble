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
                    location.reload(); //A défaut de mettre en place une méthode plus adaptée, on utilise la fonction reload() pour actualiser l'affichage des produits présents dans le panier après la suppression d'un élément.
                }
                else
                {
                this.save(); 
                }
                document.querySelector('.cart span').textContent = this.getNumberProduct();
                
            }
    }

    renderCart(){ //les queryselectors sont directement déclaré dans la fonction renderCart juste en-dessous des innerHTML. Cela permet de récupérer les attributs des boutons plus et moins dans le panier.
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

            for(let i = 0; i < qte_plus.length; i++){

                //qte_plus permettra de rajouter 1 produit de plus dans le panier. Et qte_moins servira à retirer un produit.
                qte_plus[i].addEventListener('click', () => {
                    
                    this.changeQuantity(items[i], 1);

                    qte_item[i].textContent = items[i].quantity;
                
                    total_price.textContent = this.getTotalPrice(); //Le prix total sera directement mis à jour grâce à .TextContent.

                    // location.reload();
                });

                qte_minus[i].addEventListener('click', () => {
                        
                    this.changeQuantity(items[i], -1);

                    if(items[i].quantity > 0){

                        qte_item[i].textContent = items[i].quantity; //La quantité du produit sera mise à jour sur le template tant qu'elle sera supérieure à 1.
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
