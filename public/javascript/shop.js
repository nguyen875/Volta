const notyf = new Notyf({
  duration: 3000,
  position: { x: "right", y: "bottom" },
});

function addToCart(productId) {
  const formData = new FormData();
  formData.append("product_id", productId);
  formData.append("quantity", 1);

  fetch("/volta/public/cart/add", {
    method: "POST",
    headers: {
      "X-Requested-With": "XMLHttpRequest"
    },
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        notyf.success("Product added to cart!");
        // Update cart count
        document.getElementById("cart-count").textContent = data.cartCount;
      } else {
        notyf.error(data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      notyf.error("Failed to add product to cart");
    });
}

// Lazy loading images observer
if ("IntersectionObserver" in window) {
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src || img.src;
        img.classList.remove("skeleton");
        observer.unobserve(img);
      }
    });
  });

  document.querySelectorAll(".product-image").forEach((img) => {
    imageObserver.observe(img);
  });
}
