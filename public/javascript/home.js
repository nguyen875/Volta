function showToast(message, isError = false) {
  const toast = document.createElement("div");
  toast.className = "toast" + (isError ? " error" : "");
  toast.textContent = message;
  document.body.appendChild(toast);

  setTimeout(() => {
    toast.classList.add("hide");
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

function deleteProduct(productId) {
  if (!confirm("Are you sure you want to delete this product?")) {
    return;
  }

  fetch(`/volta/public/products/delete/${productId}`, {
    method: "GET",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        showToast("Product deleted successfully!");

        const row = document.getElementById(`product-${productId}`);
        row.classList.add("fade-out");

        setTimeout(() => {
          row.remove();

          const tbody = document.getElementById("products-table-body");
          if (tbody.children.length === 0) {
            const table = tbody.closest(".overflow-x-auto");
            table.innerHTML = `
                                <div id="empty-state" class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                                    <p class="mt-1 text-sm text-gray-500">Start by creating a new product.</p>
                                </div>
                            `;
          }
        }, 300);
      } else {
        showToast(data.message || "Failed to delete product", true);
      }
    })
    .catch((error) => {
      console.error("Delete error:", error);
      showToast("Error: " + error.message, true);
    });
}

function toggleFAQ(button) {
    const answer = button.nextElementSibling;
    const icon = button.querySelector('svg');
    
    // Close all other FAQs
    document.querySelectorAll('.faq-answer').forEach(item => {
        if (item !== answer) {
            item.classList.add('hidden');
            item.previousElementSibling.querySelector('svg').classList.remove('rotate-180');
        }
    });
    
    // Toggle current FAQ
    answer.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}
