// Initialize Notyf notification library
const notyf = new Notyf({
    duration: 3000,
    position: { x: 'right', y: 'bottom' }
});

// Global variables for discount handling
let appliedDiscountCode = null;
let discountAmount = 0;
let baseSubtotal = 0;

// Initialize baseSubtotal from the page
function initializeCheckout(subtotal) {
    baseSubtotal = subtotal;
}

// Place order
function placeOrder() {
    // Validate customer information
    const name = document.getElementById('customer-name').value.trim();
    const phone = document.getElementById('customer-phone').value.trim();
    const address = document.getElementById('customer-address').value.trim();
    const paymentMethod = document.querySelector('input[name="payment-method"]:checked').value;

    if (!name) {
        notyf.error('Please enter your name');
        return;
    }
    if (!phone) {
        notyf.error('Please enter your phone number');
        return;
    }
    if (!address) {
        notyf.error('Please enter your delivery address');
        return;
    }

    // Show loading state
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = 'Processing...';
    button.disabled = true;

    // Prepare order data
    const formData = new FormData();
    formData.append('customer_name', name);
    formData.append('customer_phone', phone);
    formData.append('customer_address', address);
    formData.append('payment_method', paymentMethod);
    
    // Only append discount code if one was actually applied
    if (appliedDiscountCode) {
        formData.append('discount_code', appliedDiscountCode);
        formData.append('discount_amount', discountAmount);
    } else {
        formData.append('discount_amount', 0);
    }
    
    formData.append('subtotal', baseSubtotal);
    formData.append('total', baseSubtotal - discountAmount);

    // Submit order to backend
    fetch('/volta/public/cart/place-order', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            notyf.success('Order placed successfully!');
            // Redirect to success page
            setTimeout(() => {
                window.location.href = '/volta/public/order-success/' + data.orderId;
            }, 1000);
        } else {
            notyf.error(data.message);
            button.textContent = originalText;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        notyf.error('Failed to place order. Please try again.');
        button.textContent = originalText;
        button.disabled = false;
    });
}
