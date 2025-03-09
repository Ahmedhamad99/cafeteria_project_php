const selectedUser = document.querySelector(".user");
let products = document.querySelectorAll(".product");
let selectedProduct = document.querySelector(".selectedProduct");
let totalPrice = document.querySelector(".total-price span");

let productId, userId, productPrice, productName, order, userStatus, total;

// ***********************************
selectedUser.addEventListener("change", (e) => {
  userId = e.target.value;
  userStatus = true;
  order = [];
  total = 0;
});

// ***********************************
products.forEach((product) => {
  product.addEventListener("click", () => {
    productId = product.getAttribute("product-id");
    productPrice = product.getAttribute("product-price");
    productName = product.getAttribute("product-name");

    if (userStatus == false)
      order = JSON.parse(sessionStorage.getItem("order"));

    if (userId) {
      if (order.length == 0 && userStatus == true) {
        order = [];
        userStatus = false;
        order = addProduct(
          order,
          userId,
          productId,
          productPrice,
          productName,
          1
        );
        selectedProduct.innerHTML = createProductDiv(
          productName,
          productId,
          productPrice,
          1
        );
        changetotalPrice(productPrice);
        sessionStorage.setItem("order", JSON.stringify(order));
      } else {
        let exist = true;
        for (let element of order) {
          if (element.product_Id === productId) {
            element.product_Quantity++;
            changePrice(
              element.product_Price,
              productId,
              element.product_Quantity
            );
            changetotalPrice(element.product_Price);
            sessionStorage.setItem("order", JSON.stringify(order));
            exist = false;
          }
        }
        if (exist) {
          order = addProduct(
            order,
            userId,
            productId,
            productPrice,
            productName,
            1
          );
          selectedProduct.innerHTML += createProductDiv(
            productName,
            productId,
            productPrice,
            1
          );
          changetotalPrice(productPrice);
          sessionStorage.setItem("order", JSON.stringify(order));
        }
      }
    } else {
      console.log("User ID is missing.");
    }
  });
});

// ***********************************
// ***********************************
function addProduct(myOrder, usId, prodId, prodPrice, prodName, prodQuant) {
  myOrder.push({
    user_Id: usId,
    product_Id: prodId,
    product_Price: prodPrice,
    product_Name: prodName,
    product_Quantity: prodQuant,
  });
  return myOrder;
}
// ***********************************
function createProductDiv(prodName, prodId, prodPrice, quantity) {
  return ` <div index=${prodId} class="quantity-container d-flex align-items-center justify-content-between p-1 bg-light rounded mb-1">
                <span class="w-25">${prodName}</span>
                <button class="button btn fw-bold fs-4 text-danger" id="decrease" onclick="changeQuantity(${prodId}, -1,event)">-</button>
                <span class="box text-center d-inline-block" style="width: 20px;" id="quantity">${quantity}</span>
                <button class="button btn fw-bold fs-4 text-success " id="increase" onclick="changeQuantity(${prodId}, 1,event)">+</button>
                EGP <span class="d-inline-block" style="width: 30px;" id="price">${Number(
                  prodPrice
                ).toFixed(2)}</span>
                <span class="text-danger fw-bold delete fs-4" style='cursor:pointer;' id="remove" onclick="deleteProduct(${prodId})">X</span>
            </div>
        `;
}

// ***********************************
function changeQuantity(prodId, change, event) {
  event.preventDefault();
  order = JSON.parse(sessionStorage.getItem("order"));
  for (const product of order) {
    if (product.product_Id == prodId) {
      if (product.product_Quantity + change < 1) return;
      product.product_Quantity = product.product_Quantity + change;
      changePrice(
        product.product_Price,
        product.product_Id,
        product.product_Quantity
      );
      changetotalPriceID(product.product_Price, change);
      sessionStorage.setItem("order", JSON.stringify(order));
    }
  }
}
// ***********************************
function changePrice(proPrice, prodId, prodQuant) {
  document.querySelector(
    `.quantity-container[index="${prodId}"] .box`
  ).innerHTML = prodQuant;
  document.querySelector(
    `.quantity-container[index="${prodId}"] #price`
  ).innerHTML = (Number(proPrice) * prodQuant).toFixed(2);
}
// ***********************************
function changetotalPriceID(prodPrice, change) {
  if (change == 1) {
    total += Number(prodPrice);
  } else {
    total -= Number(prodPrice);
  }
  totalPrice.innerHTML = total.toFixed(2);
}
// ***********************************
function chngTotPriceOnDel(prodId, order) {
  let deletedProd = order.filter((item) => item.product_Id == prodId)[0];
  let totDecPrice =
    Number(deletedProd.product_Price) * deletedProd.product_Quantity;
  total -= Number(totDecPrice);
  totalPrice.innerHTML = total.toFixed(2);
}
// ***********************************
function changetotalPrice(prodPrice) {
  total += Number(prodPrice);
  totalPrice.innerHTML = total.toFixed(2);
}
// ***********************************
function deleteProduct(prodId) {
  document.querySelector(`.quantity-container[index="${prodId}"]`).remove();
  order = JSON.parse(sessionStorage.getItem("order"));
  chngTotPriceOnDel(prodId, order);
  order = order.filter((item) => item.product_Id != prodId);
  sessionStorage.setItem("order", JSON.stringify(order));
}
// ***********************************

function sendToSave() {
  let xhr = new XMLHttpRequest();

  let order = JSON.parse(sessionStorage.getItem("order")) || [];

  if (order.length === 0) {
    alert("Cart is empty");
    return;
  }
  let roomElement = document.getElementById("room");
  let roomSelected = roomElement ? roomElement.value.trim() : "";
  if (!roomSelected || roomSelected === "Select Room") {
    alert("Please select a valid room.");
    return;
  }
  xhr.open("POST", "createorder.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        document.querySelector(".selectedProduct").innerHTML = "";
        document.getElementById("notes").value = "";
        document.getElementById("room").value = 0;
        changetotalPrice(-total);
        alert("Order data received and logged successfully.");
        sessionStorage.clear();
        location.reload();
      } else {
        alert("Request failed with status: " + xhr.status);
      }
    }
  };
  let data = {
    cart: order,
    orderDesc: document.getElementById("notes").value,
    roomNum: document.getElementById("room").value,
    total_price: total,
  };
  xhr.send(JSON.stringify(data));
}
