
/**============= Cart Page & Product ====================== */
let listProductHTML = document.querySelector('.listProduct');
let listCartHTML = document.querySelector('.cart-list');
let iconCart = document.querySelector('.nav-shop');
let iconCartSpan = document.querySelector('.nav-shop span');
let body = document.querySelector('body');
let closeCart = document.querySelector('.close');
let linkCart = document.getElementById('cartshow');
let confirmOrderBtn = document.getElementById('confirmOrder');   
let note = document.getElementById('note');

let products = [];
let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

let cartOverlay = document.createElement('div');
cartOverlay.classList.add('cart-overlay');
document.body.appendChild(cartOverlay);

iconCart.addEventListener('click', () => body.classList.toggle('showCart'));
linkCart.addEventListener('click', () => body.classList.toggle('showCart'));
closeCart.addEventListener('click', () => body.classList.remove('showCart'));
cartOverlay.addEventListener('click', () => body.classList.remove('showCart'));


//fetch data from database
const fetchData = async () => {
    try {
        let response = await fetch('Products.php');
        products = await response.json();
        console.log(addDataToHTML(products));
        addCartToHTML();
    } catch (error) {
        console.error("Error fetching products:", error);
    }
};
//show data
const addDataToHTML = (products) => {
    listProductHTML.innerHTML = '';

    if (products.length > 0) {
       
        products.forEach(product => {
            let newProduct = document.createElement('div');
            newProduct.dataset.id = product.id;
            newProduct.classList.add('item');

            
            let path = `../ahmed/images/${product.image}`;

            newProduct.innerHTML = `
                <img src="${path}" alt="">
                <h2 >${product.name}</h2>
                <div class="price">$${product.price}</div>
                <button class="addCart">Add To Cart</button>
            `;
            listProductHTML.appendChild(newProduct);
        });

        attachAddToCartEvents();
    } else {
        listProductHTML.innerHTML = "<p>No products found in this category.</p>";
    }
};
//add product to cart
const attachAddToCartEvents = () => {
    document.querySelectorAll('.addCart').forEach(button => {
        button.addEventListener('click', (event) => {
            let productId = event.target.closest('.item').dataset.id;
            addToCart(productId);
        });
    });
};

const addToCart = (product_id) => {
    let existingItem = cart.find(item => item.product_id == parseInt(product_id));

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        let product = products.find(p => p.id == product_id);
        if (product) {
            cart.push({ product_id: parseInt(product_id), quantity: 1, price: product.price });
        }
    }

    addCartToHTML();
    sessionStorage.setItem('cart', JSON.stringify(cart));
};

const addCartToHTML = () => {
    listCartHTML.innerHTML = '';
    let totalQuantity = 0;
    let totalPrice = 0;

    if (cart.length > 0) {
        cart.forEach(item => {
            let product = products.find(p => p.id == item.product_id);
            if (!product) return;

            totalQuantity += item.quantity;
            totalPrice += product.price * item.quantity;

            let newItem = document.createElement('div');
            newItem.classList.add('item');
            newItem.dataset.id = item.product_id;
            newItem.innerHTML = `
                <div class="image">
                    <img src="../ahmed/images/${product.image}">
                </div>
                <div class="name">${product.name}</div>
                <div class="totalPrice">$${(product.price * item.quantity).toFixed(2)}</div>
                <div class="quantity">
                    <span class="minus">-</span>
                    <span>${item.quantity}</span>
                    <span class="plus">+</span>
                </div>
            `;
            listCartHTML.appendChild(newItem);
        });
    }

    iconCartSpan.innerText = totalQuantity;
    document.querySelector('.total-section').innerText = `Total Price: $${totalPrice.toFixed(2)}`;
};
//dropdown
document.addEventListener("DOMContentLoaded", function() {
    let roomDropdownBtn = document.getElementById("roomDropdownBtn");
    let roomItems = document.querySelectorAll(".dropdown-item");

    roomItems.forEach(item => {
        item.addEventListener("click", function() {
            let selectedRoom = this.getAttribute("data-room");
            roomDropdownBtn.innerText = selectedRoom;
        });
    });
});

//filter products
const applyFilter = (selectedCategory) => {
    let filteredProducts = selectedCategory === " " ? products : products.filter(product => parseInt(product.category_id) === parseInt(selectedCategory));
    addDataToHTML(filteredProducts);
};
 
document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', (event) => {
        applyFilter(event.target.value);
    });
});

//change quantity
listCartHTML.addEventListener('click', (event) => {
    let positionClick = event.target;
    if (positionClick.classList.contains('minus') || positionClick.classList.contains('plus')) {
        let product_id = positionClick.closest('.item').dataset.id;
        let type = positionClick.classList.contains('plus') ? 'plus' : 'minus';
        changeQuantityCart(product_id, type);
    }
});

// Function to update cart item quantity
const changeQuantityCart = (product_id, type) => {
    let positionItemInCart = cart.findIndex((value) => value.product_id == product_id);

    if (positionItemInCart >= 0) {
        let item = cart[positionItemInCart];

        if (type === 'plus') {
            item.quantity += 1;
        } else {
            item.quantity -= 1;
            if (item.quantity <= 0) {
                cart.splice(positionItemInCart, 1);
            }
        }
    }

    addCartToHTML();
    addCartToMemory();
};
//send data to database
function sendToSave() {
    let xhr = new XMLHttpRequest();
  
    let order = JSON.parse(sessionStorage.getItem("cart")) || [];
  
    if (order.length === 0) {
      toastr.error("Cart is empty");
      return;
    }
    xhr.open("POST", "Cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
        //   document.querySelector(".selectedProduct").innerHTML = "";
          alert("Order data received and logged successfully.");
          console.log("Success!");
          
        } else {
          alert("Request failed with status: " + xhr.status);
        }
      }
    };
  
    let data = {
      cart: order,
    };
  
    xhr.send(JSON.stringify(data));
  }

confirmOrderBtn.addEventListener("click", sendToSave);
//load data
fetchData();

/**======================== Scroll Up ================================ */
let mybutton = document.getElementById("myBtn");

window.onscroll = function() {
    mybutton.style.display = (document.documentElement.scrollTop > 20) ? "block" : "none";
};

function topFunction() {
    document.documentElement.scrollTop = 0;
}

/**======================== Delivered Msg =============================== */
const showAlert = () => {
    alert("🎉 Thanks, Customer! Your order is on its way! 🚚");
};

document.querySelector('.return-home-btn').addEventListener('click', ()=>showAlert);

