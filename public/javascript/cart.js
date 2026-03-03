const notyf = new Notyf({
  duration: 3000,
  position: { x: "right", y: "bottom" },
});

function updateQuantity(productId, change, maxStock) {
  const input = document.querySelector(`input[data-product-id="${productId}"]`);
  let newQuantity = parseInt(input.value) + change;

  if (newQuantity < 1) newQuantity = 1;
  if (newQuantity > maxStock) {
    notyf.error("Not enough stock available");
    return;
  }

  input.value = newQuantity;
  updateCart(productId, newQuantity);
}

function updateQuantityDirect(productId, quantity, maxStock) {
  let newQuantity = parseInt(quantity);

  if (newQuantity < 1) {
    newQuantity = 1;
    document.querySelector(`input[data-product-id="${productId}"]`).value = 1;
  }
  if (newQuantity > maxStock) {
    notyf.error("Not enough stock available");
    newQuantity = maxStock;
    document.querySelector(`input[data-product-id="${productId}"]`).value =
      maxStock;
  }

  updateCart(productId, newQuantity);
}

function updateCart(productId, quantity) {
  const formData = new FormData();
  formData.append("product_id", productId);
  formData.append("quantity", quantity);

  fetch("/volta/public/cart/update", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Update item total
        const itemRow = document.querySelector(
          `.cart-item[data-product-id="${productId}"]`
        );
        itemRow.querySelector(".item-total").textContent =
          new Intl.NumberFormat("vi-VN").format(data.itemTotal) + " ₫";

        // Update subtotal and total
        document.getElementById("subtotal").textContent =
          new Intl.NumberFormat("vi-VN").format(data.subtotal) + " ₫";
        document.getElementById("total").textContent =
          new Intl.NumberFormat("vi-VN").format(data.subtotal) + " ₫";

        // Update cart count
        document.getElementById("cart-count").textContent = data.cartCount;
      } else {
        notyf.error(data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      notyf.error("Failed to update cart");
    });
}

function removeItem(productId) {
  if (!confirm("Are you sure you want to remove this item?")) {
    return;
  }

  const formData = new FormData();
  formData.append("product_id", productId);

  fetch("/volta/public/cart/remove", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Remove item from DOM
        const itemRow = document.querySelector(
          `.cart-item[data-product-id="${productId}"]`
        );
        itemRow.remove();

        // Update subtotal and total
        document.getElementById("subtotal").textContent =
          new Intl.NumberFormat("vi-VN").format(data.subtotal) + " ₫";
        document.getElementById("total").textContent =
          new Intl.NumberFormat("vi-VN").format(data.subtotal) + " ₫";

        // Update cart count
        document.getElementById("cart-count").textContent = data.cartCount;

        // Check if cart is empty
        if (data.cartCount === 0) {
          location.reload();
        }

        notyf.success("Item removed from cart");
      } else {
        notyf.error(data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      notyf.error("Failed to remove item");
    });
}
