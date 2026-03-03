        const notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'bottom' }
        });

        function changeMainImage(src) {
            const mainImage = document.querySelector('.product-detail-image');
            mainImage.src = src;
        }

        function increaseQuantity(maxStock) {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value);
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }

        function addToCart(productId) {
            const quantity = parseInt(document.getElementById('quantity').value);
            
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);

            fetch('/volta/public/cart/add', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    notyf.success(`Added ${quantity} item(s) to cart!`);
                    // Update cart count
                    document.getElementById('cart-count').textContent = data.cartCount;
                } else {
                    notyf.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                notyf.error('Failed to add product to cart');
            });
        }